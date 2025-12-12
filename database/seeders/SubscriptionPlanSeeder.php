<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['plan_type' => 'basic', 'name' => 'Basic Plan', 'name_ar' => 'خطة أساسية', 'description' => 'Unlimited ads, no priority', 'default_cost' => 0.00, 'billing_cycle' => 'monthly', 'features' => json_encode(['ad_free' => false, 'priority_search' => false]), 'max_ads' => 0, 'priority_level' => 0],
            ['plan_type' => 'supergrok', 'name' => 'SuperGrok Plan', 'name_ar' => 'خطة سوبر غروك', 'description' => 'All features + unlimited featured', 'default_cost' => 199.99, 'billing_cycle' => 'yearly', 'features' => json_encode(['ad_free' => true, 'priority_search' => true, 'featured_ads' => 999]), 'max_ads' => 0, 'priority_level' => 10],
        ];

        foreach ($data as $item) {
            SubscriptionPlan::create($item);
        }
    }
}