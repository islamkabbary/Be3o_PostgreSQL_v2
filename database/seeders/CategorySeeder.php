<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $mainCategories = [
            [
                'name' => ['en' => 'Vehicles', 'ar' => 'عربيات واكسسواراتها'],
                'slug' => 'vehicles',
                'description' => [
                    'en' => 'Cars, motorcycles, and other vehicles for sale or rent.',
                    'ar' => 'بيع وشراء وتأجير السيارات والدراجات وجميع وسائل النقل.'
                ],
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/743/743131.png',
                'image_url' => 'https://images.unsplash.com/photo-1502877338535-766e1452684a',
                'sort_order' => 1,
            ],
            [
                'name' => ['en' => 'Properties', 'ar' => 'العقارات'],
                'slug' => 'properties',
                'description' => [
                    'en' => 'Apartments, villas, and lands for sale or rent.',
                    'ar' => 'شقق وفلل وأراضي للبيع أو الإيجار.'
                ],
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/235/235861.png',
                'image_url' => 'https://images.unsplash.com/photo-1560184897-67f4f60f0e8b',
                'sort_order' => 2,
            ],
            [
                'name' => ['en' => 'Electronics', 'ar' => 'الإلكترونيات'],
                'slug' => 'electronics',
                'description' => [
                    'en' => 'Phones, laptops, and other electronic devices.',
                    'ar' => 'هواتف، لابتوبات، وأجهزة إلكترونية أخرى.'
                ],
                'icon_url' => 'https://cdn-icons-png.flaticon.com/512/1041/1041916.png',
                'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9',
                'sort_order' => 3,
            ],
        ];

        foreach ($mainCategories as $item) {
            Category::updateOrCreate(['slug' => $item['slug']], $item);
        }

        // Fetch parents
        $vehicles = Category::where('slug', 'vehicles')->first();
        $properties = Category::where('slug', 'properties')->first();
        $electronics = Category::where('slug', 'electronics')->first();

        $childCategories = [
            [
                'parent_id' => $vehicles->id,
                'name' => ['en' => 'Cars for Sale', 'ar' => 'سيارات للبيع'],
                'slug' => 'cars-for-sale',
                'description' => ['en' => 'Cars available for purchase.', 'ar' => 'سيارات معروضة للبيع.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $vehicles->id,
                'name' => ['en' => 'Cars for Rent', 'ar' => 'سيارات للإيجار'],
                'slug' => 'cars-for-rent',
                'description' => ['en' => 'Cars available for rent.', 'ar' => 'سيارات للإيجار.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $vehicles->id,
                'name' => ['en' => 'Spare Parts', 'ar' => 'قطع غيار'],
                'slug' => 'spare-parts',
                'description' => ['en' => 'Vehicle spare parts and accessories.', 'ar' => 'قطع غيار وإكسسوارات السيارات.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $electronics->id,
                'name' => ['en' => 'Phones', 'ar' => 'هواتف'],
                'slug' => 'phones',
                'description' => ['en' => 'Mobile phones and smartphones.', 'ar' => 'هواتف ذكية ومحمولة.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $properties->id,
                'name' => ['en' => 'Apartments for Sale', 'ar' => 'شقق للبيع'],
                'slug' => 'apartments-for-sale',
                'description' => ['en' => 'Apartments for sale.', 'ar' => 'شقق متاحة للبيع.'],
                'sort_order' => 1,
            ],
        ];

        foreach ($childCategories as $item) {
            Category::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
