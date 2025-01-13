<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\BuildingCollection;
use App\Services\BuildingService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Buildings",
 *     description="API Endpoints for buildings"
 * )
 */
class BuildingController extends Controller
{
    private $buildingService;

    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }

    /**
     * Get all buildings with pagination
     * 
     * @OA\Get(
     *     path="/api/buildings",
     *     tags={"Buildings"},
     *     summary="Get all buildings",
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
     *         @OA\JsonContent(ref="#/components/schemas/BuildingCollection")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100'
        ]);

        if ($request->has('per_page')) {
            $this->buildingService->setPerPage($request->per_page);
        }

        $buildings = $this->buildingService->getAllBuildings();
        return new BuildingCollection($buildings);
    }

    /**
     * Get building by ID with its organizations
     * 
     * @OA\Get(
     *     path="/api/buildings/{id}",
     *     tags={"Buildings"},
     *     summary="Get building by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Building ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BuildingResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Building not found"
     *     )
     * )
     */
    public function show($id)
    {
        $building = $this->buildingService->getBuildingById($id);
        return new BuildingResource($building);
    }
}