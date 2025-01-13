<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="GetOrganizationsByBoundsRequest",
 *     title="Get Organizations By Bounds Request",
 *     required={"bounds"},
 *     @OA\Property(
 *         property="bounds",
 *         type="object",
 *         required={"sw_lat", "sw_lng", "ne_lat", "ne_lng"},
 *         @OA\Property(
 *             property="sw_lat",
 *             type="number",
 *             format="float",
 *             description="Southwest latitude",
 *             minimum=-90,
 *             maximum=90
 *         ),
 *         @OA\Property(
 *             property="sw_lng",
 *             type="number",
 *             format="float",
 *             description="Southwest longitude",
 *             minimum=-180,
 *             maximum=180
 *         ),
 *         @OA\Property(
 *             property="ne_lat",
 *             type="number",
 *             format="float",
 *             description="Northeast latitude",
 *             minimum=-90,
 *             maximum=90
 *         ),
 *         @OA\Property(
 *             property="ne_lng",
 *             type="number",
 *             format="float",
 *             description="Northeast longitude",
 *             minimum=-180,
 *             maximum=180
 *         )
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
class GetOrganizationsByBoundsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bounds' => 'required|array',
            'bounds.sw_lat' => 'required|numeric|between:-90,90',
            'bounds.sw_lng' => 'required|numeric|between:-180,180',
            'bounds.ne_lat' => 'required|numeric|between:-90,90',
            'bounds.ne_lng' => 'required|numeric|between:-180,180',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ];
    }
}
