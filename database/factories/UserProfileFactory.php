<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'about_me' => $this->faker->paragraph,
            'business_name' => $this->faker->company,
            'business_type' => $this->faker->word,
            'company_size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'website_url' => $this->faker->url,
            'social_facebook' => $this->faker->url,
            'social_instagram' => $this->faker->url,
            'social_twitter' => $this->faker->url,
            'trade_license' => $this->faker->randomNumber,
            'tax_number' => $this->faker->randomNumber,
            'notification_email' => $this->faker->boolean,
            'notification_sms' => $this->faker->boolean,
            'notification_push' => $this->faker->boolean,
            'privacy_show_phone' => $this->faker->boolean,
            'privacy_show_email' => $this->faker->boolean,
        ];
    }
}