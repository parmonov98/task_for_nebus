<?php

namespace App\Repositories\Eloquent;

use App\Models\Building;
use App\Repositories\Interfaces\BuildingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BuildingRepository implements BuildingRepositoryInterface
{
    protected $perPage = 15;

    public function getAllPaginated(): LengthAwarePaginator
    {
        return Building::query()->paginate($this->perPage);
    }

    public function findById(int $id): ?Building
    {
        return Building::with([
            'organizations' => function ($query) {
                $query->with(['categories', 'phones']);
            }
        ])->findOrFail($id);
    }

    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }
}