<?php

namespace App\Services;

use App\Jobs\SendVerifyEmailJob;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class VerificationService
{
    public function create(User $user, string $channel = 'email'): Verification
    {
        if ($channel === 'email' && $user->email_verified_at) {
            throw new \Exception(__('messages.Email already verified'));
        }

        if ($channel === 'phone' && $user->phone_verified_at) {
            throw new \Exception(__('messages.Phone already verified'));
        }

        $token = Str::random(64);

        $verification = Verification::create([
            'user_id'    => $user->id,
            'channel'    => $channel,
            'token'      => $token,
            'expires_at' => Carbon::now()->addMinutes(30),
            'used'       => false,
        ]);

        if ($channel === 'email') {
            SendVerifyEmailJob::dispatch($user, $token);
        }

        // يمكنك إضافة SMS أو أي قناة أخرى هنا لاحقًا
        return $verification;
    }

    public function verify(string $token): bool
    {
        $verification = Verification::where('token', $token)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$verification) {
            return false;
        }

        $user = $verification->user;

        if ($verification->channel === 'email') {
            $user->update([
                'email_verified_at' => Carbon::now(),
            ]);
        } elseif ($verification->channel === 'phone') {
            $user->update([
                'phone_verified_at' => Carbon::now(),
            ]);
        }

        $verification->update(['used' => true]);

        return true;
    }
}
