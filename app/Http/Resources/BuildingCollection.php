<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     schema="BuildingCollection",
 *     title="Building Collection",
 *     description="Collection of buildings",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/BuildingResource")
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         @OA\Property(property="first", type="string", format="uri"),
 *         @OA\Property(property="last", type="string", format="uri"),
 *         @OA\Property(property="prev", type="string", format="uri", nullable=true),
 *         @OA\Property(property="next", type="string", format="uri", nullable=true)
 *     ),
 *     @OA\Property(
 *         property="meta",
 *         type="object",
 *         @OA\Property(property="current_page", type="integer"),
 *         @OA\Property(property="from", type="integer"),
 *         @OA\Property(property="last_page", type="integer"),
 *         @OA\Property(property="path", type="string"),
 *         @OA\Property(property="per_page", type="integer"),
 *         @OA\Property(property="to", type="integer"),
 *         @OA\Property(property="total", type="integer")
 *     )
 * )
 */
class BuildingCollection extends ResourceCollection
{
    public $collects = BuildingResource::class;
}