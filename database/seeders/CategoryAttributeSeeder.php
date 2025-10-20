<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryAttribute;

class CategoryAttributeSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Vehicles =====
        $vehicles = Category::where('slug', 'vehicles')->first();
        $cars = Category::where('slug', 'cars')->first();
        $motorcycles = Category::where('slug', 'motorcycles')->first();
        $trucks = Category::where('slug', 'trucks-buses')->first();

        // Cars Attributes
        $carAttributes = [
            ['name' => 'Brand', 'name_ar' => 'الماركة', 'attribute_type' => 'select', 'options' => ['Toyota','BMW','Mercedes','Ford'], 'is_required' => true],
            ['name' => 'Model', 'name_ar' => 'الموديل', 'attribute_type' => 'text', 'is_required' => true],
            ['name' => 'Year', 'name_ar' => 'السنة', 'attribute_type' => 'number', 'is_required' => true],
            ['name' => 'Mileage', 'name_ar' => 'الممشى', 'attribute_type' => 'number'],
            ['name' => 'Fuel Type', 'name_ar' => 'نوع الوقود', 'attribute_type' => 'select', 'options' => ['Petrol','Diesel','Electric','Hybrid']],
            ['name' => 'Transmission', 'name_ar' => 'نوع ناقل الحركة', 'attribute_type' => 'select', 'options' => ['Manual','Automatic']],
            ['name' => 'Color', 'name_ar' => 'اللون', 'attribute_type' => 'text'],
            ['name' => 'Number of Doors', 'name_ar' => 'عدد الأبواب', 'attribute_type' => 'number'],
            ['name' => 'Condition', 'name_ar' => 'الحالة', 'attribute_type' => 'select', 'options' => ['New','Used','Refurbished']],
        ];

        foreach ($carAttributes as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $cars->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $cars->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }

        // Motorcycles Attributes
        $motorcycleAttributes = [
            ['name' => 'Brand', 'name_ar' => 'الماركة', 'attribute_type' => 'select', 'options' => ['Yamaha','Honda','Suzuki'], 'is_required' => true],
            ['name' => 'Model', 'name_ar' => 'الموديل', 'attribute_type' => 'text', 'is_required' => true],
            ['name' => 'Year', 'name_ar' => 'السنة', 'attribute_type' => 'number'],
            ['name' => 'Mileage', 'name_ar' => 'الممشى', 'attribute_type' => 'number'],
            ['name' => 'Engine Capacity', 'name_ar' => 'سعة المحرك', 'attribute_type' => 'number'],
            ['name' => 'Type', 'name_ar' => 'النوع', 'attribute_type' => 'select', 'options' => ['Sport','Cruiser','Scooter','Off-road']],
        ];

        foreach ($motorcycleAttributes as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $motorcycles->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $motorcycles->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }

        // Trucks & Buses Attributes
        $truckAttributes = [
            ['name' => 'Brand', 'name_ar' => 'الماركة', 'attribute_type' => 'text'],
            ['name' => 'Model', 'name_ar' => 'الموديل', 'attribute_type' => 'text'],
            ['name' => 'Year', 'name_ar' => 'السنة', 'attribute_type' => 'number'],
            ['name' => 'Mileage', 'name_ar' => 'الممشى', 'attribute_type' => 'number'],
            ['name' => 'Load Capacity', 'name_ar' => 'سعة التحميل', 'attribute_type' => 'number'],
            ['name' => 'Fuel Type', 'name_ar' => 'نوع الوقود', 'attribute_type' => 'select', 'options' => ['Petrol','Diesel','Electric','Hybrid']],
            ['name' => 'Condition', 'name_ar' => 'الحالة', 'attribute_type' => 'select', 'options' => ['New','Used','Refurbished']],
        ];

        foreach ($truckAttributes as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $trucks->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $trucks->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }

        // ===== Real Estate =====
        $apartments = Category::where('slug', 'apartments')->first();
        $villas = Category::where('slug', 'villas')->first();
        $offices = Category::where('slug', 'offices-shops')->first();

        $apartmentAttrs = [
            ['name' => 'Bedrooms', 'name_ar' => 'عدد الغرف', 'attribute_type' => 'number'],
            ['name' => 'Bathrooms', 'name_ar' => 'عدد الحمامات', 'attribute_type' => 'number'],
            ['name' => 'Area', 'name_ar' => 'المساحة', 'attribute_type' => 'number'],
            ['name' => 'Furnished', 'name_ar' => 'مفروشة', 'attribute_type' => 'boolean'],
            ['name' => 'Floor', 'name_ar' => 'الدور', 'attribute_type' => 'number'],
            ['name' => 'Elevator', 'name_ar' => 'مصعد', 'attribute_type' => 'boolean'],
            ['name' => 'Parking', 'name_ar' => 'موقف سيارات', 'attribute_type' => 'boolean'],
            ['name' => 'Type', 'name_ar' => 'النوع', 'attribute_type' => 'select', 'options' => ['Studio','1-Bedroom','2-Bedroom']],
        ];

        foreach ($apartmentAttrs as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $apartments->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $apartments->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }

        // Villas Attributes
        $villaAttrs = [
            ['name' => 'Bedrooms', 'name_ar' => 'عدد الغرف', 'attribute_type' => 'number'],
            ['name' => 'Bathrooms', 'name_ar' => 'عدد الحمامات', 'attribute_type' => 'number'],
            ['name' => 'Area', 'name_ar' => 'المساحة', 'attribute_type' => 'number'],
            ['name' => 'Furnished', 'name_ar' => 'مفروشة', 'attribute_type' => 'boolean'],
            ['name' => 'Garden', 'name_ar' => 'حديقة', 'attribute_type' => 'boolean'],
            ['name' => 'Pool', 'name_ar' => 'حمام سباحة', 'attribute_type' => 'boolean'],
            ['name' => 'Parking', 'name_ar' => 'موقف سيارات', 'attribute_type' => 'number'],
            ['name' => 'Type', 'name_ar' => 'النوع', 'attribute_type' => 'select', 'options' => ['Detached','Semi-detached','Luxury']],
        ];

        foreach ($villaAttrs as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $villas->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $villas->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }

        // Offices & Shops Attributes
        $officeAttrs = [
            ['name' => 'Area', 'name_ar' => 'المساحة', 'attribute_type' => 'number'],
            ['name' => 'Furnished', 'name_ar' => 'مفروشة', 'attribute_type' => 'boolean'],
            ['name' => 'Parking', 'name_ar' => 'موقف سيارات', 'attribute_type' => 'number'],
            ['name' => 'Floor', 'name_ar' => 'الدور', 'attribute_type' => 'number'],
            ['name' => 'Type', 'name_ar' => 'النوع', 'attribute_type' => 'select', 'options' => ['Office','Shop','Commercial Space']],
        ];

        foreach ($officeAttrs as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $offices->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $offices->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }

        // ===== Electronics =====
        $phones = Category::where('slug', 'phones')->first();
        $laptops = Category::where('slug', 'laptops')->first();
        $tablets = Category::where('slug', 'tablets-accessories')->first();

        // Phones Attributes
        $phoneAttrs = [
            ['name' => 'Brand', 'name_ar' => 'الماركة', 'attribute_type' => 'select', 'options' => ['Apple','Samsung','Xiaomi','Huawei'], 'is_required' => true],
            ['name' => 'Model', 'name_ar' => 'الموديل', 'attribute_type' => 'text', 'is_required' => true],
            ['name' => 'Condition', 'name_ar' => 'الحالة', 'attribute_type' => 'select', 'options' => ['New','Used','Refurbished']],
            ['name' => 'Storage', 'name_ar' => 'سعة التخزين', 'attribute_type' => 'number'],
            ['name' => 'Color', 'name_ar' => 'اللون', 'attribute_type' => 'text'],
            ['name' => 'OS', 'name_ar' => 'نظام التشغيل', 'attribute_type' => 'select', 'options' => ['Android','iOS']],
        ];

        foreach ($phoneAttrs as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $phones->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $phones->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }

        // Laptops Attributes
        $laptopAttrs = [
            ['name' => 'Brand', 'name_ar' => 'الماركة', 'attribute_type' => 'text'],
            ['name' => 'Model', 'name_ar' => 'الموديل', 'attribute_type' => 'text'],
            ['name' => 'Condition', 'name_ar' => 'الحالة', 'attribute_type' => 'select', 'options' => ['New','Used','Refurbished']],
            ['name' => 'RAM', 'name_ar' => 'الرام', 'attribute_type' => 'number'],
            ['name' => 'Storage', 'name_ar' => 'سعة التخزين', 'attribute_type' => 'number'],
            ['name' => 'Processor', 'name_ar' => 'المعالج', 'attribute_type' => 'text'],
            ['name' => 'Screen Size', 'name_ar' => 'حجم الشاشة', 'attribute_type' => 'number'],
            ['name' => 'OS', 'name_ar' => 'نظام التشغيل', 'attribute_type' => 'select', 'options' => ['Windows','Linux','macOS']],
        ];

        foreach ($laptopAttrs as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $laptops->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $laptops->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }

        // Tablets & Accessories Attributes
        $tabletAttrs = [
            ['name' => 'Brand', 'name_ar' => 'الماركة', 'attribute_type' => 'text'],
            ['name' => 'Model', 'name_ar' => 'الموديل', 'attribute_type' => 'text'],
            ['name' => 'Condition', 'name_ar' => 'الحالة', 'attribute_type' => 'select', 'options' => ['New','Used','Refurbished']],
            ['name' => 'Type', 'name_ar' => 'النوع', 'attribute_type' => 'select', 'options' => ['Tablet','Charger','Case','Other']],
        ];

        foreach ($tabletAttrs as $attr) {
            CategoryAttribute::updateOrCreate(
                ['category_id' => $tablets->id, 'name' => $attr['name']],
                array_merge($attr, [
                    'category_id' => $tablets->id,
                    'options' => isset($attr['options']) ? json_encode($attr['options']) : null
                ])
            );
        }
    }
}