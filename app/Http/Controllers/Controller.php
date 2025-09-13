<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;

/**
 * @OA\Info(
 *     title="Be3o API",
 *     version="1.0.0",
 *     description="API documentation for Be3o classified ads platform",
 *     @OA\Contact(
 *         email="islamkabbary@gmail.com",
 *         name="Islam Kabbary",
 *         url="https://www.linkedin.com/in/islam-kabbary-2b35a814b"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000/api/v1",
 *     description="Base URL for API v1"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="Bearer",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Enter your bearer token in format Bearer <token>"
 * )
 */
abstract class Controller
{
    use ResponseTrait;
}
