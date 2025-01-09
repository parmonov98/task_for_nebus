<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationCollection;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationController extends Controller
{
    private $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * Get organizations in a specific building
     */
    public function getByBuilding($buildingId)
    {
        $organizations = $this->organizationService->getOrganizationsByBuilding($buildingId);
        return new OrganizationCollection($organizations);
    }

    /**
     * Get organizations by category
     */
    public function getByCategory($categoryId)
    {
        $organizations = $this->organizationService->getOrganizationsByCategory($categoryId);
        return new OrganizationCollection($organizations);
    }

    /**
     * Get organizations within geographical area
     */
    public function getByLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required_without:bounds|numeric',
            'bounds' => 'required_without:radius|array',
            'bounds.sw_lat' => 'required_with:bounds|numeric',
            'bounds.sw_lng' => 'required_with:bounds|numeric',
            'bounds.ne_lat' => 'required_with:bounds|numeric',
            'bounds.ne_lng' => 'required_with:bounds|numeric',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ]);

        if ($request->has('per_page')) {
            $this->organizationService->setPerPage($request->per_page);
        }

        $organizations = $this->organizationService->getOrganizationsInArea(
            $request->latitude,
            $request->longitude,
            $request->radius ?? null,
            $request->bounds ?? null
        );

        return new OrganizationCollection($organizations);
    }

    /**
     * Get organization by ID
     */
    public function show($id)
    {
        $organization = $this->organizationService->getOrganizationById($id);
        return new OrganizationResource($organization);
    }

    /**
     * Search organizations by category tree
     */
    public function searchByCategory($name)
    {
        $organizations = $this->organizationService->searchOrganizationsByCategory($name);
        return new OrganizationCollection($organizations);
    }

    /**
     * Search organizations by name
     */
    public function searchByName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ]);

        if ($request->has('per_page')) {
            $this->organizationService->setPerPage($request->per_page);
        }

        $organizations = $this->organizationService->searchOrganizationsByName($request->name);
        return new OrganizationCollection($organizations);
    }
}