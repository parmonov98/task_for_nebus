<?php

namespace App\Repositories\Interfaces;

use App\Models\Organization;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrganizationRepositoryInterface
{
    /**
     * Get organizations by building ID
     */
    public function findByBuilding(int $buildingId): LengthAwarePaginator;

    /**
     * Get organizations by category ID (including child categories)
     */
    public function findByCategory(int $categoryId): LengthAwarePaginator;

    /**
     * Get organizations within geographical area
     */
    public function findInArea(float $lat, float $lng, ?float $radius = null, ?array $bounds = null): LengthAwarePaginator;

    /**
     * Search organizations by name
     */
    public function searchByName(string $name): LengthAwarePaginator;

    /**
     * Get organization by ID with relationships
     */
    public function findById(int $id): ?Organization;

    /**
     * Search organizations by category name (including child categories)
     */
    public function searchByCategory(string $categoryName): LengthAwarePaginator;

    /**
     * Set the number of items per page
     */
    public function setPerPage(int $perPage): void;
}