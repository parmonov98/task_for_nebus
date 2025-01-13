<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetOrganizationsByBuildingRequest;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationCollection;
use App\Http\Requests\GetOrganizationsByCategoryRequest;
use App\Http\Requests\GetOrganizationsByLocationRequest;
use App\Http\Requests\SearchOrganizationsByCategoryRequest;
use App\Http\Requests\SearchOrganizationsByNameRequest;
use App\Services\OrganizationService;

class OrganizationController extends Controller
{
    public function __construct(protected OrganizationService $organizationService)
    {
    }

    /**
     * Get organizations in a specific building
     * 
     * @OA\Get(
     *     path="/api/organizations/building/{buildingId}",
     *     tags={"Organizations"},
     *     summary="Get organizations by building ID",
     *     @OA\Parameter(
     *         name="buildingId",
     *         in="path",
     *         required=true,
     *         description="Building ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Items per page",
     *         @OA\Schema(type="integer", minimum=1, maximum=100)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Building not found"
     *     )
     * )
     */
    public function getByBuilding(GetOrganizationsByBuildingRequest $request, $buildingId)
    {
        if ($request->has('per_page')) {
            $this->organizationService->setPerPage($request->per_page);
        }

        $organizations = $this->organizationService->getOrganizationsByBuilding($buildingId);
        return new OrganizationCollection($organizations);
    }

    /**
     * Get organizations by category
     * 
     * @OA\Get(
     *     path="/api/organizations/category/{categoryId}",
     *     tags={"Organizations"},
     *     summary="Get organizations by category ID",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Items per page",
     *         @OA\Schema(type="integer", minimum=1, maximum=100)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function getByCategory(GetOrganizationsByCategoryRequest $request, $categoryId)
    {
        if ($request->has('per_page')) {
            $this->organizationService->setPerPage($request->per_page);
        }

        $organizations = $this->organizationService->getOrganizationsByCategory($categoryId);
        return new OrganizationCollection($organizations);
    }

    /**
     * Get organizations within geographical area
     * 
     * @OA\Post(
     *     path="/api/organizations/location",
     *     tags={"Organizations"},
     *     summary="Get organizations within a geographical area",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"latitude", "longitude"},
     *             @OA\Property(property="latitude", type="number", format="float", example=55.7558),
     *             @OA\Property(property="longitude", type="number", format="float", example=37.6173),
     *             @OA\Property(property="radius", type="number", format="float", example=1000),
     *             @OA\Property(
     *                 property="bounds",
     *                 type="object",
     *                 @OA\Property(property="sw_lat", type="number", format="float", example=55.7),
     *                 @OA\Property(property="sw_lng", type="number", format="float", example=37.6),
     *                 @OA\Property(property="ne_lat", type="number", format="float", example=55.8),
     *                 @OA\Property(property="ne_lng", type="number", format="float", example=37.7)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     )
     * )
     */
    public function getByLocation(GetOrganizationsByLocationRequest $request)
    {
        if ($request->has('per_page')) {
            $this->organizationService->setPerPage($request->per_page);
        }

        if ($request->has('radius')) {
            $organizations = $this->organizationService->findInArea(
                $request->latitude,
                $request->longitude,
                radius: $request->radius,
            );
        } else {
            $organizations = $this->organizationService->findInArea(
                $request->latitude,
                $request->longitude,
                bounds: $request->bounds
            );
        }

        return new OrganizationCollection($organizations);
    }

    /**
     * Search organizations by category name
     * 
     * @OA\Get(
     *     path="/api/organizations/search/category/{name}",
     *     tags={"Organizations"},
     *     summary="Search organizations by category name",
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         required=true,
     *         description="Category name to search for",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Items per page",
     *         @OA\Schema(type="integer", minimum=1, maximum=100)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     )
     * )
     */
    public function searchByCategory(SearchOrganizationsByCategoryRequest $request, $name)
    {
        if ($request->has('per_page')) {
            $this->organizationService->setPerPage($request->per_page);
        }

        $organizations = $this->organizationService->searchByCategory($name);
        return new OrganizationCollection($organizations);
    }

    /**
     * Search organizations by name
     * 
     * @OA\Get(
     *     path="/api/organizations/search",
     *     tags={"Organizations"},
     *     summary="Search organizations by name",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Organization name to search for",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Items per page",
     *         @OA\Schema(type="integer", minimum=1, maximum=100)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationCollection")
     *     )
     * )
     */
    public function searchByName(SearchOrganizationsByNameRequest $request)
    {
        if ($request->has('per_page')) {
            $this->organizationService->setPerPage($request->per_page);
        }

        $organizations = $this->organizationService->searchByName($request->name);
        return new OrganizationCollection($organizations);
    }

    /**
     * Get organization by ID
     * 
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     tags={"Organizations"},
     *     summary="Get organization by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Organization ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organization not found"
     *     )
     * )
     */
    public function show($id)
    {
        $organization = $this->organizationService->findById($id);
        return new OrganizationResource($organization);
    }
}