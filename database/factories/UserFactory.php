<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => Hash::make('password'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'avatar_url' => $this->faker->url,
            'date_of_birth' => $this->faker->date,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            // 'email_verified_at' => $this->faker->boolean,
            // 'phone_verified_at' => $this->faker->boolean,
            'account_type' => $this->faker->randomElement(['individual', 'business', 'dealer']),
            'account_status' => $this->faker->randomElement(['active', 'suspended', 'banned', 'deleted']),
            'preferred_language' => 'en',
            'last_login_at' => $this->faker->dateTimeThisYear,
        ];
    }
}