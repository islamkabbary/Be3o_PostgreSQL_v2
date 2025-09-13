<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="UserLoginRequest",
 *     required={"email","password"},
 *     @OA\Property(property="email", type="string", format="email", example="islam@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="secret123")
 * )
 */
class UserLoginRequest {}