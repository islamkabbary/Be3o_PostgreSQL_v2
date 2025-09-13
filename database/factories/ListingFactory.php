<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
            'subcategory_id' => \App\Models\Subcategory::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'currency' => 'EGP',
            'price_negotiable' => $this->faker->boolean,
            'condition' => $this->faker->randomElement(['new', 'used', 'refurbished']),
            'country' => 'Egypt',
            'governorate' => $this->faker->city,
            'city' => $this->faker->city,
            'area' => $this->faker->streetName,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'status' => $this->faker->randomElement(['draft', 'active', 'sold', 'expired', 'removed', 'suspended']),
            'listing_type' => $this->faker->randomElement(['sell', 'rent', 'exchange', 'wanted']),
            'is_featured' => $this->faker->boolean,
            'is_urgent' => $this->faker->boolean,
            'is_premium' => $this->faker->boolean,
            'auto_renew' => $this->faker->boolean,
            'priority_score' => $this->faker->randomNumber(2),
            'contact_count' => $this->faker->randomNumber(2),
            'favorite_count' => $this->faker->randomNumber(2),
            'slug' => $this->faker->unique()->slug,
            'meta_title' => $this->faker->sentence,
            'meta_description' => $this->faker->paragraph,
            'published_at' => $this->faker->dateTimeThisYear,
            'expires_at' => $this->faker->dateTimeThisYear,
        ];
    }
}