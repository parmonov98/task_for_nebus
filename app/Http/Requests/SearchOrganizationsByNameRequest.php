<?php

namespace App\Http\Requests;

/**
 * @OA\Schema(
 *     schema="SearchOrganizationsByNameRequest",
 *     title="Search Organizations By Name Request",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Organization name to search for",
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
class SearchOrganizationsByNameRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|integer|min:1|max:100',
            'name' => 'required|string|min:1|max:255'
        ];
    }
}