<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Vehicles', 'name_ar' => 'المركبات', 'slug' => 'vehicles', 'sort_order' => 1],
            // باقي البيانات من السكيما
            ['name' => 'Everything Else', 'name_ar' => 'أشياء أخرى', 'slug' => 'everything-else', 'sort_order' => 13],
        ];

        foreach ($data as $item) {
            Category::create($item);
        }
    }
}