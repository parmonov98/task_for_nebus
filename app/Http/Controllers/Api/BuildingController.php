<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\BuildingCollection;
use App\Services\BuildingService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingController extends Controller
{
    private $buildingService;

    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }

    /**
     * Get all buildings with pagination
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
     */
    public function show($id)
    {
        $building = $this->buildingService->getBuildingById($id);
        return new BuildingResource($building);
    }
}