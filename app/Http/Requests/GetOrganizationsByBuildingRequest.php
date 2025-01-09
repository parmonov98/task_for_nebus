<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *     schema="GetOrganizationsByBuildingRequest",
 *     title="Get Organizations By Building Request",
 *     required={"buildingId"},
 *     @OA\Property(
 *         property="buildingId",
 *         type="integer",
 *         description="Building ID"
 *     ),
 *     @OA\Property(
 *         property="per_page",
 *         type="integer",
 *         description="Items per page",
 *         minimum=1,
 *         maximum=100
 *     )
 * )
 */
class GetOrganizationsByBuildingRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|integer|min:1|max:100',
            'buildingId' => 'required|integer|exists:buildings,id'
        ];
    }
}