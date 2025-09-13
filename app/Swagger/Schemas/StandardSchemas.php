<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="StandardResponse",
 *     description="Standard success response",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="code", type="integer", example=200),
 *     @OA\Property(property="message", type="string", example="User registered successfully"),
 *     @OA\Property(property="data", type="object", nullable=true, example={"id":1,"email":"user@example.com"}),
 *     @OA\Property(
 *         property="pagination",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="current_page", type="integer", example=1),
 *         @OA\Property(property="total_pages", type="integer", example=5),
 *         @OA\Property(property="items_per_page", type="integer", example=10),
 *         @OA\Property(property="total_items", type="integer", example=50),
 *         @OA\Property(property="next_page_url", type="string", example="http://api.test?page=2"),
 *         @OA\Property(property="prev_page_url", type="string", example=null)
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     description="Standard error response",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="code", type="integer", example=422),
 *     @OA\Property(property="message", type="string", example="Validation error"),
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         example={"email": {"The email field is required."}}
 *     ),
 *     @OA\Property(property="data", type="null", example=null)
 * )
 */
class StandardSchemas {}
