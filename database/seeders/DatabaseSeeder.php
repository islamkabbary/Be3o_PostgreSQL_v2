<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(SubscriptionPlanSeeder::class);
        $this->call(CategoryAttributeSeeder::class);
    }
}