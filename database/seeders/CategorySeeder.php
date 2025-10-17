<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // ===== Main Categories =====
        $mainCategories = [
            [
                'name' => 'Vehicles',
                'name_ar' => 'المركبات',
                'slug' => 'vehicles',
                'description' => 'Cars, motorcycles, and other vehicles for sale or rent.',
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/743/743131.png',
                'image_url' => 'https://images.unsplash.com/photo-1502877338535-766e1452684a',
                'sort_order' => 1,
            ],
            [
                'name' => 'Real Estate',
                'name_ar' => 'العقارات',
                'slug' => 'real-estate',
                'description' => 'Apartments, villas, offices, and lands for sale or rent.',
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/235/235861.png',
                'image_url' => 'https://images.unsplash.com/photo-1560184897-67f4f60f0e8b',
                'sort_order' => 2,
            ],
            [
                'name' => 'Electronics',
                'name_ar' => 'الإلكترونيات',
                'slug' => 'electronics',
                'description' => 'Phones, laptops, and other electronic devices.',
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/1041/1041916.png',
                'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9',
                'sort_order' => 3,
            ],
        ];

        // Insert Main Categories
        foreach ($mainCategories as $item) {
            Category::updateOrCreate(['slug' => $item['slug']], $item);
        }

        // ===== Child Categories =====
        $vehicles = Category::where('slug', 'vehicles')->first();
        $realEstate = Category::where('slug', 'real-estate')->first();
        $electronics = Category::where('slug', 'electronics')->first();

        $childCategories = [
            // Vehicles Children
            [
                'parent_id' => $vehicles->id,
                'name' => 'Cars',
                'name_ar' => 'سيارات',
                'slug' => 'cars',
                'description' => 'All kinds of cars for sale or rent.',
                'sort_order' => 1,
            ],
            [
                'parent_id' => $vehicles->id,
                'name' => 'Motorcycles',
                'name_ar' => 'دراجات نارية',
                'slug' => 'motorcycles',
                'description' => 'Motorcycles and scooters.',
                'sort_order' => 2,
            ],
            [
                'parent_id' => $vehicles->id,
                'name' => 'Trucks & Buses',
                'name_ar' => 'شاحنات وحافلات',
                'slug' => 'trucks-buses',
                'description' => 'Trucks, buses, and commercial vehicles.',
                'sort_order' => 3,
            ],

            // Real Estate Children
            [
                'parent_id' => $realEstate->id,
                'name' => 'Apartments',
                'name_ar' => 'شقق',
                'slug' => 'apartments',
                'description' => 'Apartments for sale or rent.',
                'sort_order' => 1,
            ],
            [
                'parent_id' => $realEstate->id,
                'name' => 'Villas',
                'name_ar' => 'فلل',
                'slug' => 'villas',
                'description' => 'Villas and luxury homes.',
                'sort_order' => 2,
            ],
            [
                'parent_id' => $realEstate->id,
                'name' => 'Offices & Shops',
                'name_ar' => 'مكاتب ومتاجر',
                'slug' => 'offices-shops',
                'description' => 'Offices, shops, and commercial spaces.',
                'sort_order' => 3,
            ],

            // Electronics Children
            [
                'parent_id' => $electronics->id,
                'name' => 'Phones',
                'name_ar' => 'هواتف',
                'slug' => 'phones',
                'description' => 'Smartphones and mobile phones.',
                'sort_order' => 1,
            ],
            [
                'parent_id' => $electronics->id,
                'name' => 'Laptops',
                'name_ar' => 'أجهزة لابتوب',
                'slug' => 'laptops',
                'description' => 'Laptops for work, gaming, and study.',
                'sort_order' => 2,
            ],
            [
                'parent_id' => $electronics->id,
                'name' => 'Tablets & Accessories',
                'name_ar' => 'أجهزة لوحية وملحقاتها',
                'slug' => 'tablets-accessories',
                'description' => 'Tablets, chargers, and accessories.',
                'sort_order' => 3,
            ],
        ];

        // Insert Child Categories
        foreach ($childCategories as $item) {
            Category::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}