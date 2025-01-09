<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="BuildingResource",
 *     title="Building Resource",
 *     description="Building resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Building Name"),
 *     @OA\Property(property="address", type="string", example="123 Main St"),
 *     @OA\Property(property="latitude", type="number", format="float", example=55.7558),
 *     @OA\Property(property="longitude", type="number", format="float", example=37.6173),
 *     @OA\Property(
 *         property="organizations",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/OrganizationResource")
 *     )
 * )
 */
class BuildingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'organizations' => OrganizationResource::collection($this->whenLoaded('organizations'))
        ];
    }
}