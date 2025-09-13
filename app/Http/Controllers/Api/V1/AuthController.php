<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Services\VerificationService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Authentication"
 * )
 */
class AuthController extends Controller
{
    protected $authService;
    protected VerificationService $verificationService;

    public function __construct(AuthService $authService, VerificationService $verificationService)
    {
        $this->authService = $authService;
        $this->verificationService = $verificationService;
    }

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StandardResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());
        $this->verificationService->create($user, 'email');
        return $this->success($user, 'messages.User registered successfully', 201);
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Authentication"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserLoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(ref="#/components/schemas/StandardResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return $this->error([], __('messages.Invalid credentials'), 401);
        }

        return $this->success(['token' => $token], __('messages.Login successful'));
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"Authentication"},
     *     summary="Logout user",
     *     description="Revoke user token",
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(ref="#/components/schemas/StandardResponse")
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success([], __('messages.Logged out successfully'));
    }

    /**
     * @OA\Get(
     *     path="/auth/verify/{token}",
     *     tags={"Authentication"},
     *     summary="Verify user email",
     *     description="Activate a user account by verifying their email with a token",
     *     @OA\Parameter(
     *         name="token",
     *         in="path",
     *         required=true,
     *         description="Verification token sent to user email",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="verification_success",
     *         @OA\JsonContent(ref="#/components/schemas/StandardResponse")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="invalid_or_expired_token",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function verify($token)
    {
        $verified = $this->verificationService->verify($token);

        if (!$verified) {
            return $this->error([], __('messages.invalid_or_expired_token'), 400);
        }

        return $this->success([], __('messages.verification_success'));
    }

    /**
     * @OA\Post(
     *     path="/auth/resend-verification",
     *     tags={"Authentication"},
     *     summary="Resend verification email",
     *     description="Resend the verification email if the user has not verified yet",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="verification_email_resent",
     *         @OA\JsonContent(ref="#/components/schemas/StandardResponse")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function resendVerification(Request $request)
    {
        $user = $this->authService->findByEmail($request->email);

        if (!$user) {
            return $this->error([], __('messages.User not found'), 404);
        }

        if ($user->email_verified_at) {
            return $this->error([], __('messages.Email already verified'), 400);
        }

        $this->verificationService->create($user, 'email');

        return $this->success([], __('messages.verification_email_resent'));
    }

    /**
     * @OA\Post(
     *     path="/auth/forgot-password",
     *     tags={"Authentication"},
     *     summary="Send reset password link",
     *     description="Send a reset password email with token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset email sent",
     *         @OA\JsonContent(ref="#/components/schemas/StandardResponse")
     *     )
     * )
     */
    public function forgotPassword(Request $request)
    {
        $this->authService->sendPasswordReset($request->email);
        return $this->success([], __('messages.Password reset link sent'));
    }

    /**
     * @OA\Post(
     *     path="/auth/reset-password",
     *     tags={"Authentication"},
     *     summary="Reset user password",
     *     description="Reset password using a valid reset token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"token","password"},
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successfully",
     *         @OA\JsonContent(ref="#/components/schemas/StandardResponse")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="invalid_or_expired_token",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function resetPassword(Request $request)
    {
        $reset = $this->authService->resetPassword($request->only(['token', 'password']));

        if (!$reset) {
            return $this->error([], __('messages.invalid_or_expired_token'), 400);
        }

        return $this->success([], __('messages.Password reset successfully'));
    }
}
