<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="GetOrganizationsByRadiusRequest",
 *     title="Get Organizations By Radius Request",
 *     required={"latitude", "longitude", "radius"},
 *     @OA\Property(
 *         property="latitude",
 *         type="number",
 *         format="float",
 *         description="Latitude",
 *         minimum=-90,
 *         maximum=90
 *     ),
 *     @OA\Property(
 *         property="longitude",
 *         type="number",
 *         format="float",
 *         description="Longitude",
 *         minimum=-180,
 *         maximum=180
 *     ),
 *     @OA\Property(
 *         property="radius",
 *         type="number",
 *         format="float",
 *         description="Search radius in meters",
 *         minimum=0
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
class GetOrganizationsByRadiusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|numeric|min:0',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ];
    }
}
