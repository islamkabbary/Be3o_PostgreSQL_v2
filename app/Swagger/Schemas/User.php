<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     description="User resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="email", type="string", example="user@example.com"),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-05T20:29:06.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-05T20:29:06.000000Z")
 * )
 */
class User {}