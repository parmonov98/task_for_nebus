<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CategoryResource",
 *     title="Category Resource",
 *     description="Category resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Category Name"),
 *     @OA\Property(property="level", type="integer", example=0),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, example=null),
 *     @OA\Property(
 *         property="children",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CategoryResource"),
 *         description="Nested child categories"
 *     ),
 *     @OA\Property(property="parent", ref="#/components/schemas/CategoryResource"),
 *     @OA\Property(
 *         property="organizations",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/OrganizationResource")
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'parent_id' => $this->parent_id,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'parent' => new CategoryResource($this->whenLoaded('parent')),
            'organizations' => OrganizationResource::collection($this->whenLoaded('organizations')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}