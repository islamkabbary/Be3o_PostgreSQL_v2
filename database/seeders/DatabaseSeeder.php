<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(SubscriptionPlanSeeder::class);

        // للبيانات الوهمية, مثلاً:
        // \App\Models\User::factory(10)->create();
        // أضف factory calls للباقي إذا عايز
    }
}