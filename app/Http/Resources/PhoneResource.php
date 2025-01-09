<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PhoneResource",
 *     title="Phone Resource",
 *     description="Phone resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="number", type="string", example="+1234567890"),
 *     @OA\Property(property="organization_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class PhoneResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'organization_id' => $this->organization_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}