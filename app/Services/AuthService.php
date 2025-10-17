<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw new UnauthorizedHttpException('', __('messages.Invalid credentials'));
        }

        $user = Auth::user();

        if (!$user->email_verified_at) {
            throw new AccessDeniedHttpException(__('messages.Please verify your email first'));
        }

        return [
            'token' => $user->createToken('api_token')->plainTextToken,
            'user' => new UserResource($user),
        ];
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function sendPasswordReset(string $email): array
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            return ['success' => true, 'message' => __($status)];
        }

        throw new \Exception(__($status), 422);
    }

    public function resetPassword(array $data): array
    {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return ['success' => true, 'message' => __($status)];
        }

        throw new \Exception(__($status), 422);
    }
}
