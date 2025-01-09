<?php

namespace App\Repositories\Interfaces;

use App\Models\Building;
use Illuminate\Pagination\LengthAwarePaginator;

interface BuildingRepositoryInterface
{
    /**
     * Get all buildings with pagination
     */
    public function getAllPaginated(): LengthAwarePaginator;

    /**
     * Get building by ID with relationships
     */
    public function findById(int $id): ?Building;

    /**
     * Set the number of items per page
     */
    public function setPerPage(int $perPage): void;
}