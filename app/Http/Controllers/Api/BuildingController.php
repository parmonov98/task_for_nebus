<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\BuildingCollection;
use App\Services\BuildingService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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

    /**
     * Get buildings within geographical area
     * 
     * @OA\Post(
     *     path="/api/buildings/location",
     *     tags={"Buildings"},
     *     summary="Get buildings within a geographical area",
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
     *         @OA\JsonContent(ref="#/components/schemas/BuildingCollection")
     *     )
     * )
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
            'bounds.ne_lng' => 'required_with:bounds|numeric'
        ]);

        if ($request->has('radius')) {
            $buildings = $this->buildingService->findInArea(
                $request->latitude,
                $request->longitude,
                $request->radius
            );
        } else {
            $buildings = $this->buildingService->findInArea(
                $request->latitude,
                $request->longitude,
                null,
                $request->bounds
            );
        }

        return new BuildingCollection($buildings);
    }
}