<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OrganizationResource",
 *     title="Organization Resource",
 *     description="Organization resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Organization Name"),
 *     @OA\Property(property="description", type="string", example="Organization Description"),
 *     @OA\Property(
 *         property="categories",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CategoryResource")
 *     ),
 *     @OA\Property(
 *         property="phones",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PhoneResource")
 *     ),
 *     @OA\Property(property="building", ref="#/components/schemas/BuildingResource")
 * )
 */
class OrganizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'phones' => PhoneResource::collection($this->whenLoaded('phones')),
            'building' => new BuildingResource($this->whenLoaded('building'))
        ];
    }
}