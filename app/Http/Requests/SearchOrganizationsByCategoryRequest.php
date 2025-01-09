<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *     schema="SearchOrganizationsByCategoryRequest",
 *     title="Search Organizations By Category Request",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Category name to search for",
 *         minLength=1,
 *         maxLength=255
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
class SearchOrganizationsByCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|integer|min:1|max:100',
            'name' => 'required|string|min:1|max:255'
        ];
    }
}