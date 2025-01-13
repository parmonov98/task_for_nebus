<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *     schema="GetOrganizationsByCategoryRequest",
 *     title="Get Organizations By Category Request",
 *     required={"categoryId"},
 *     @OA\Property(
 *         property="categoryId",
 *         type="integer",
 *         description="Category ID"
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
class GetOrganizationsByCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|integer|min:1|max:100',
        ];
    }
}