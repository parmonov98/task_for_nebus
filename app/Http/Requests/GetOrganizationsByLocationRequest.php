<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *     schema="GetOrganizationsByLocationRequest",
 *     title="Get Organizations By Location Request",
 *     required={"latitude", "longitude"},
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
 *         description="Search radius in meters"
 *     ),
 *     @OA\Property(
 *         property="bounds",
 *         type="object",
 *         description="Rectangular bounds for search",
 *         @OA\Property(property="sw_lat", type="number", format="float", minimum=-90, maximum=90),
 *         @OA\Property(property="sw_lng", type="number", format="float", minimum=-180, maximum=180),
 *         @OA\Property(property="ne_lat", type="number", format="float", minimum=-90, maximum=90),
 *         @OA\Property(property="ne_lng", type="number", format="float", minimum=-180, maximum=180)
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
class GetOrganizationsByLocationRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|integer|min:1|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required_without:bounds|numeric|min:0',
            'bounds' => 'required_without:radius|array',
            'bounds.sw_lat' => 'required_with:bounds|numeric|between:-90,90',
            'bounds.sw_lng' => 'required_with:bounds|numeric|between:-180,180',
            'bounds.ne_lat' => 'required_with:bounds|numeric|between:-90,90',
            'bounds.ne_lng' => 'required_with:bounds|numeric|between:-180,180'
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.between' => 'Latitude must be between -90 and 90 degrees',
            'longitude.between' => 'Longitude must be between -180 and 180 degrees',
            'bounds.sw_lat.between' => 'Southwest latitude must be between -90 and 90 degrees',
            'bounds.sw_lng.between' => 'Southwest longitude must be between -180 and 180 degrees',
            'bounds.ne_lat.between' => 'Northeast latitude must be between -90 and 90 degrees',
            'bounds.ne_lng.between' => 'Northeast longitude must be between -180 and 180 degrees'
        ];
    }
}