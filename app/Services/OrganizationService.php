<?php

namespace App\Services;

use App\Repositories\Interfaces\OrganizationRepositoryInterface;

class OrganizationService
{
    private $repository;

    public function __construct(OrganizationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getOrganizationsByBuilding(int $buildingId)
    {
        return $this->repository->findByBuilding($buildingId);
    }

    public function getOrganizationsByCategory(int $categoryId)
    {
        return $this->repository->findByCategory($categoryId);
    }

    public function getOrganizationsInArea(float $lat, float $lng, ?float $radius = null, ?array $bounds = null)
    {
        return $this->repository->findInArea($lat, $lng, $radius, $bounds);
    }

    public function searchOrganizationsByName(string $name)
    {
        return $this->repository->searchByName($name);
    }

    public function getOrganizationById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function searchOrganizationsByCategory(string $categoryName)
    {
        return $this->repository->searchByCategory($categoryName);
    }

    public function setPerPage(int $perPage): void
    {
        $this->repository->setPerPage($perPage);
    }
}