<?php

namespace App\Repositories\Eloquent;

use App\Models\Organization;
use App\Models\Category;
use App\Repositories\Interfaces\OrganizationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    protected $perPage = 15;

    public function findByBuilding(int $buildingId): LengthAwarePaginator
    {
        return Organization::with(['categories', 'phones'])
            ->where('building_id', $buildingId)
            ->paginate($this->perPage);
    }

    public function findByCategory(int $categoryId): LengthAwarePaginator
    {
        $categoryIds = Category::where('id', $categoryId)
            ->orWhere('parent_id', $categoryId)
            ->pluck('id');

        return Organization::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
            ->with(['categories', 'phones', 'building'])
            ->paginate($this->perPage);
    }

    public function findInArea(float $lat, float $lng, ?float $radius = null, ?array $bounds = null): LengthAwarePaginator
    {
        $query = Organization::with(['categories', 'phones'])
            ->select('organizations.*')
            ->join('buildings', 'organizations.building_id', '=', 'buildings.id');

        if ($radius !== null) {
            $query->whereRaw('
                ST_Distance_Sphere(
                    point(buildings.longitude, buildings.latitude),
                    point(?, ?)
                ) <= ?
            ', [$lng, $lat, $radius]);
        } elseif ($bounds !== null) {
            $query->whereBetween('buildings.latitude', [$bounds['sw_lat'], $bounds['ne_lat']])
                ->whereBetween('buildings.longitude', [$bounds['sw_lng'], $bounds['ne_lng']]);
        }

        return $query->paginate($this->perPage);
    }

    public function searchByName(string $name): LengthAwarePaginator
    {
        return Organization::where('name', 'like', "%{$name}%")
            ->with(['categories', 'phones', 'building'])
            ->paginate($this->perPage);
    }

    public function findById(int $id): ?Organization
    {
        return Organization::with(['categories', 'phones', 'building'])
            ->findOrFail($id);
    }

    public function searchByCategory(string $categoryName): LengthAwarePaginator
    {
        $category = Category::where('name', 'like', "%{$categoryName}%")
            ->where('level', '<=', 3)
            ->first();

        if (!$category) {
            return Organization::where('id', '<', 0)->paginate($this->perPage); // Empty paginator
        }

        $categoryIds = Category::where('id', $category->id)
            ->orWhere(function ($query) use ($category) {
                $query->where('parent_id', $category->id)
                    ->orWhereIn(
                        'parent_id',
                        Category::where('parent_id', $category->id)->pluck('id')
                    );
            })
            ->pluck('id');

        return Organization::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
            ->with(['categories', 'phones', 'building'])
            ->paginate($this->perPage);
    }

    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }
}