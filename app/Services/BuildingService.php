<?php

namespace App\Services;

use App\Repositories\Interfaces\BuildingRepositoryInterface;

class BuildingService
{
    private $repository;

    public function __construct(BuildingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllBuildings()
    {
        return $this->repository->getAllPaginated();
    }

    public function getBuildingById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function setPerPage(int $perPage): void
    {
        $this->repository->setPerPage($perPage);
    }
}