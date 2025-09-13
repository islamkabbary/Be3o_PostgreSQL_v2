<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="UserRegisterRequest",
 *     required={"first_name","last_name","email","password"},
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="secret123")
 * )
 */
class UserRegisterRequest {}
