<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Database\Seeder;

class CategoryAttributeSeeder extends Seeder
{
    public function run()
    {
        $vehicles = Category::whereRaw("(name::json->>'en') = ?", ['Vehicles'])->first();

        $carsForSale = Category::whereRaw("(name::json->>'en') = ?", ['Cars for Sale'])
            ->where('parent_id', $vehicles->id)
            ->first();

        $carsForRent = Category::whereRaw("(name::json->>'en') = ?", ['Cars for Rent'])
            ->where('parent_id', $vehicles->id)
            ->first();

        $motorcycles = Category::whereRaw("(name::json->>'en') = ?", ['Motorcycles'])
            ->where('parent_id', $vehicles->id)
            ->first();

        $spareParts = Category::whereRaw("(name::json->>'en') = ?", ['Spare Parts'])
            ->where('parent_id', $vehicles->id)
            ->first();


        $carBrands = ['Toyota', 'Honda', 'Mercedes-Benz', 'BMW', 'Audi', 'Hyundai', 'Kia', 'Nissan', 'Chevrolet', 'Ford', 'Volkswagen', 'Mazda', 'Lexus', 'Mitsubishi', 'Peugeot', 'Renault', 'Suzuki', 'Skoda', 'Volvo', 'Jeep', 'Land Rover', 'Porsche', 'Tesla', 'Fiat', 'Subaru', 'Opel', 'Citroen', 'Other'];

        $brandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Brand'],
            [
                'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => $carBrands,
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $brandAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id]);

        $toyotaModels = ['Corolla', 'Camry', 'RAV4', 'Land Cruiser', 'Hilux', 'Prado', 'Yaris', 'Fortuner', 'Avalon', 'C-HR', 'Highlander', '4Runner', 'Sequoia', 'Tundra', 'Tacoma', 'Sienna', 'Prius', 'Supra', 'Other'];
        $hondaModels = ['Civic', 'Accord', 'CR-V', 'Pilot', 'HR-V', 'Odyssey', 'Fit', 'Passport', 'Ridgeline', 'Insight', 'Clarity', 'Other'];
        $mercedesModels = ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE', 'GLA', 'GLB', 'GLS', 'A-Class', 'CLA', 'CLS', 'G-Class', 'AMG GT', 'EQC', 'Other'];
        $bmwModels = ['3 Series', '5 Series', '7 Series', 'X1', 'X3', 'X5', 'X6', 'X7', 'Z4', 'i3', 'i8', 'iX', 'M3', 'M5', 'Other'];

        $modelAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Model'],
            [
                'name' => ['en' => 'Model', 'ar' => 'الموديل'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => [
                    'Toyota' => $toyotaModels,
                    'Honda' => $hondaModels,
                    'Mercedes-Benz' => $mercedesModels,
                    'BMW' => $bmwModels
                ],
                'depends_on' => $brandAttribute->id,
                'sort_order' => 2
            ]
        );

        $modelAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id]);

        $years = [];
        for ($year = date('Y') + 1; $year >= 1990; $year--) {
            $years[] = (string)$year;
        }

        $yearAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Year'],
            [
                'name' => ['en' => 'Year', 'ar' => 'السنة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => $years,
                'depends_on' => $modelAttribute->id,
                'sort_order' => 3
            ]
        );

        $yearAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id]);

        $variantAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Variant'],
            [
                'name' => ['en' => 'Variant', 'ar' => 'الفئة'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Base', 'Standard', 'Sport', 'Luxury', 'Premium', 'Limited', 'SE', 'LE', 'XLE', 'SEL', 'SL', 'EX', 'LX', 'Touring', 'Other'],
                'depends_on' => $yearAttribute->id,
                'sort_order' => 4
            ]
        );

        $variantAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id]);

        $fuelTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Fuel Type'],
            [
                'name' => ['en' => 'Fuel Type', 'ar' => 'نوع الوقود'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Petrol', 'Diesel', 'Hybrid', 'Electric', 'Natural Gas', 'Other'],
                'depends_on' => null,
                'sort_order' => 5
            ]
        );

        $fuelTypeAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id]);

        $transmissionAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Transmission'],
            [
                'name' => ['en' => 'Transmission', 'ar' => 'ناقل الحركة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Automatic', 'Manual', 'CVT', 'Semi-Automatic', 'Other'],
                'depends_on' => null,
                'sort_order' => 6
            ]
        );

        $transmissionAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id]);

        $colorAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Color'],
            [
                'name' => ['en' => 'Color', 'ar' => 'اللون'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'multiselect',
                'options' => ['White', 'Black', 'Silver', 'Gray', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Brown', 'Gold', 'Beige', 'Purple', 'Pink', 'Other'],
                'depends_on' => null,
                'sort_order' => 7
            ]
        );

        $colorAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id]);

        $mileageAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Mileage'],
            [
                'name' => ['en' => 'Mileage', 'ar' => 'الممشى'],
                'attribute_type' => 'number',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 8
            ]
        );

        $mileageAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id]);

        $conditionAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Condition'],
            [
                'name' => ['en' => 'Condition', 'ar' => 'الحالة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['New', 'Used', 'Certified Pre-Owned', 'Damaged', 'Other'],
                'depends_on' => null,
                'sort_order' => 9
            ]
        );

        $conditionAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id, $spareParts->id]);

        $priceAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Price'],
            [
                'name' => ['en' => 'Price', 'ar' => 'السعر'],
                'attribute_type' => 'number',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 10
            ]
        );

        $priceAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id, $spareParts->id]);

        $locationAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Location'],
            [
                'name' => ['en' => 'Location', 'ar' => 'الموقع'],
                'attribute_type' => 'text',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 11
            ]
        );

        $locationAttribute->categories()->syncWithoutDetaching([$carsForSale->id, $carsForRent->id, $motorcycles->id, $spareParts->id]);

        $motorcycleBrandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Motorcycle Brand'],
            [
                'name' => ['en' => 'Motorcycle Brand', 'ar' => 'ماركة الدراجة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Yamaha', 'Honda', 'Suzuki', 'Kawasaki', 'Harley-Davidson', 'Ducati', 'BMW', 'KTM', 'Triumph', 'Royal Enfield', 'Aprilia', 'Benelli', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $motorcycleBrandAttribute->categories()->syncWithoutDetaching([$motorcycles->id]);

        $engineCapacityAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Engine Capacity'],
            [
                'name' => ['en' => 'Engine Capacity (CC)', 'ar' => 'سعة المحرك'],
                'attribute_type' => 'number',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 12
            ]
        );

        $engineCapacityAttribute->categories()->syncWithoutDetaching([$motorcycles->id]);

        $sparePartTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Part Type'],
            [
                'name' => ['en' => 'Part Type', 'ar' => 'نوع القطعة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Engine Parts', 'Transmission Parts', 'Brake System', 'Suspension', 'Electrical', 'Body Parts', 'Interior', 'Wheels & Tires', 'Filters', 'Lighting', 'Exhaust', 'Cooling System', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $sparePartTypeAttribute->categories()->syncWithoutDetaching([$spareParts->id]);

        $compatibleBrandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Compatible Brand'],
            [
                'name' => ['en' => 'Compatible Brand', 'ar' => 'الماركة المتوافقة'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'multiselect',
                'options' => $carBrands,
                'depends_on' => null,
                'sort_order' => 2
            ]
        );

        $compatibleBrandAttribute->categories()->syncWithoutDetaching([$spareParts->id]);

        $electronics = Category::whereRaw("(name::json->>'en') = ?", ['Electronics'])->first();

        $mobilePhones = Category::whereRaw("(name::json->>'en') = ?", ['Mobile Phones'])
            ->where('parent_id', $electronics->id)
            ->first();

        $tablets = Category::whereRaw("(name::json->>'en') = ?", ['Tablets'])
            ->where('parent_id', $electronics->id)
            ->first();

        $laptops = Category::whereRaw("(name::json->>'en') = ?", ['Laptops'])
            ->where('parent_id', $electronics->id)
            ->first();

        $tvs = Category::whereRaw("(name::json->>'en') = ?", ['TVs'])
            ->where('parent_id', $electronics->id)
            ->first();

        $cameras = Category::whereRaw("(name::json->>'en') = ?", ['Cameras'])
            ->where('parent_id', $electronics->id)
            ->first();

        $audio = Category::whereRaw("(name::json->>'en') = ?", ['Audio'])
            ->where('parent_id', $electronics->id)
            ->first();

        $mobileBrands = ['Apple', 'Samsung', 'Huawei', 'Xiaomi', 'Oppo', 'Vivo', 'OnePlus', 'Realme', 'Nokia', 'Motorola', 'LG', 'Sony', 'Google', 'Asus', 'Honor', 'Infinix', 'Tecno', 'Other'];

        $mobileBrandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Mobile Brand'],
            [
                'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => $mobileBrands,
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $mobileBrandAttribute->categories()->syncWithoutDetaching([$mobilePhones->id, $tablets->id]);

        $appleModels = ['iPhone 16 Pro Max', 'iPhone 16 Pro', 'iPhone 16 Plus', 'iPhone 16', 'iPhone 15 Pro Max', 'iPhone 15 Pro', 'iPhone 15 Plus', 'iPhone 15', 'iPhone 14 Pro Max', 'iPhone 14 Pro', 'iPhone 14 Plus', 'iPhone 14', 'iPhone 13 Pro Max', 'iPhone 13 Pro', 'iPhone 13', 'iPhone 13 Mini', 'iPhone 12 Pro Max', 'iPhone 12 Pro', 'iPhone 12', 'iPhone 12 Mini', 'iPhone 11 Pro Max', 'iPhone 11 Pro', 'iPhone 11', 'iPhone XS Max', 'iPhone XS', 'iPhone XR', 'iPhone X', 'iPhone SE', 'Other'];
        $samsungModels = ['Galaxy S24 Ultra', 'Galaxy S24+', 'Galaxy S24', 'Galaxy S23 Ultra', 'Galaxy S23+', 'Galaxy S23', 'Galaxy S22 Ultra', 'Galaxy S22+', 'Galaxy S22', 'Galaxy Z Fold 6', 'Galaxy Z Fold 5', 'Galaxy Z Flip 6', 'Galaxy Z Flip 5', 'Galaxy A54', 'Galaxy A34', 'Galaxy A24', 'Galaxy A14', 'Galaxy M54', 'Galaxy M34', 'Other'];
        $huaweiModels = ['P60 Pro', 'P50 Pro', 'Mate 60 Pro', 'Mate 50 Pro', 'Nova 12', 'Nova 11', 'Y9', 'Other'];
        $xiaomiModels = ['14 Ultra', '14 Pro', '14', '13 Ultra', '13 Pro', '13', 'Redmi Note 13 Pro', 'Redmi Note 13', 'Redmi Note 12 Pro', 'Redmi 13', 'Poco X6 Pro', 'Poco X6', 'Poco F6', 'Other'];

        $mobileModelAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Mobile Model'],
            [
                'name' => ['en' => 'Model', 'ar' => 'الموديل'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => [
                    'Apple' => $appleModels,
                    'Samsung' => $samsungModels,
                    'Huawei' => $huaweiModels,
                    'Xiaomi' => $xiaomiModels
                ],
                'depends_on' => $mobileBrandAttribute->id,
                'sort_order' => 2
            ]
        );

        $mobileModelAttribute->categories()->syncWithoutDetaching([$mobilePhones->id, $tablets->id]);

        $storageAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Storage'],
            [
                'name' => ['en' => 'Storage', 'ar' => 'السعة التخزينية'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['16GB', '32GB', '64GB', '128GB', '256GB', '512GB', '1TB', '2TB', 'Other'],
                'depends_on' => $mobileModelAttribute->id,
                'sort_order' => 3
            ]
        );

        $storageAttribute->categories()->syncWithoutDetaching([$mobilePhones->id, $tablets->id, $laptops->id]);

        $ramAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'RAM'],
            [
                'name' => ['en' => 'RAM', 'ar' => 'الرام'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['2GB', '3GB', '4GB', '6GB', '8GB', '12GB', '16GB', '32GB', '64GB', 'Other'],
                'depends_on' => $storageAttribute->id,
                'sort_order' => 4
            ]
        );

        $ramAttribute->categories()->syncWithoutDetaching([$mobilePhones->id, $tablets->id, $laptops->id]);

        $mobileColorAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Mobile Color'],
            [
                'name' => ['en' => 'Color', 'ar' => 'اللون'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'multiselect',
                'options' => ['Black', 'White', 'Silver', 'Gold', 'Rose Gold', 'Blue', 'Green', 'Red', 'Purple', 'Yellow', 'Pink', 'Titanium', 'Graphite', 'Midnight', 'Starlight', 'Other'],
                'depends_on' => $ramAttribute->id,
                'sort_order' => 5
            ]
        );

        $mobileColorAttribute->categories()->syncWithoutDetaching([$mobilePhones->id, $tablets->id]);

        $mobileConditionAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Mobile Condition'],
            [
                'name' => ['en' => 'Condition', 'ar' => 'الحالة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['New', 'Used - Like New', 'Used - Good', 'Used - Fair', 'Refurbished', 'Other'],
                'depends_on' => null,
                'sort_order' => 6
            ]
        );

        $mobileConditionAttribute->categories()->syncWithoutDetaching([$mobilePhones->id, $tablets->id, $laptops->id, $cameras->id, $audio->id]);

        $warrantyAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Warranty'],
            [
                'name' => ['en' => 'Warranty', 'ar' => 'الضمان'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['No Warranty', 'Under Warranty', '6 Months', '1 Year', '2 Years', 'Extended Warranty', 'Other'],
                'depends_on' => null,
                'sort_order' => 7
            ]
        );

        $warrantyAttribute->categories()->syncWithoutDetaching([$mobilePhones->id, $tablets->id, $laptops->id, $tvs->id, $cameras->id, $audio->id]);

        $mobilePriceAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Mobile Price'],
            [
                'name' => ['en' => 'Price', 'ar' => 'السعر'],
                'attribute_type' => 'number',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 8
            ]
        );

        $mobilePriceAttribute->categories()->syncWithoutDetaching([$mobilePhones->id, $tablets->id, $laptops->id, $tvs->id, $cameras->id, $audio->id]);

        $laptopBrands = ['Apple', 'Dell', 'HP', 'Lenovo', 'Asus', 'Acer', 'MSI', 'Microsoft', 'Razer', 'Alienware', 'Samsung', 'Huawei', 'LG', 'Toshiba', 'Other'];

        $laptopBrandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Laptop Brand'],
            [
                'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => $laptopBrands,
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $laptopBrandAttribute->categories()->syncWithoutDetaching([$laptops->id]);

        $processorAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Processor'],
            [
                'name' => ['en' => 'Processor', 'ar' => 'المعالج'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9', 'AMD Ryzen 3', 'AMD Ryzen 5', 'AMD Ryzen 7', 'AMD Ryzen 9', 'Apple M1', 'Apple M2', 'Apple M3', 'Apple M4', 'Other'],
                'depends_on' => null,
                'sort_order' => 2
            ]
        );

        $processorAttribute->categories()->syncWithoutDetaching([$laptops->id]);

        $screenSizeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Screen Size'],
            [
                'name' => ['en' => 'Screen Size', 'ar' => 'حجم الشاشة'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['11 inch', '13 inch', '14 inch', '15 inch', '16 inch', '17 inch', 'Other'],
                'depends_on' => null,
                'sort_order' => 3
            ]
        );

        $screenSizeAttribute->categories()->syncWithoutDetaching([$laptops->id]);

        $graphicsCardAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Graphics Card'],
            [
                'name' => ['en' => 'Graphics Card', 'ar' => 'كرت الشاشة'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Integrated', 'NVIDIA GeForce GTX', 'NVIDIA GeForce RTX', 'AMD Radeon', 'Intel Iris', 'Other'],
                'depends_on' => null,
                'sort_order' => 4
            ]
        );

        $graphicsCardAttribute->categories()->syncWithoutDetaching([$laptops->id]);

        $tvBrands = ['Samsung', 'LG', 'Sony', 'TCL', 'Hisense', 'Panasonic', 'Philips', 'Sharp', 'Toshiba', 'Xiaomi', 'Other'];

        $tvBrandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'TV Brand'],
            [
                'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => $tvBrands,
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $tvBrandAttribute->categories()->syncWithoutDetaching([$tvs->id]);

        $tvSizeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'TV Size'],
            [
                'name' => ['en' => 'Size (inches)', 'ar' => 'الحجم'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['32', '40', '43', '50', '55', '60', '65', '70', '75', '80', '85', '90', 'Other'],
                'depends_on' => null,
                'sort_order' => 2
            ]
        );

        $tvSizeAttribute->categories()->syncWithoutDetaching([$tvs->id]);

        $resolutionAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Resolution'],
            [
                'name' => ['en' => 'Resolution', 'ar' => 'الدقة'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['HD', 'Full HD', '4K UHD', '8K UHD', 'Other'],
                'depends_on' => null,
                'sort_order' => 3
            ]
        );

        $resolutionAttribute->categories()->syncWithoutDetaching([$tvs->id, $cameras->id]);

        $smartTvAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Smart TV'],
            [
                'name' => ['en' => 'Smart TV', 'ar' => 'تلفاز ذكي'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'boolean',
                'options' => ['Yes', 'No'],
                'depends_on' => null,
                'sort_order' => 4
            ]
        );

        $smartTvAttribute->categories()->syncWithoutDetaching([$tvs->id]);

        $cameraBrands = ['Canon', 'Nikon', 'Sony', 'Fujifilm', 'Panasonic', 'Olympus', 'Leica', 'Pentax', 'GoPro', 'DJI', 'Other'];

        $cameraBrandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Camera Brand'],
            [
                'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => $cameraBrands,
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $cameraBrandAttribute->categories()->syncWithoutDetaching([$cameras->id]);

        $cameraTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Camera Type'],
            [
                'name' => ['en' => 'Camera Type', 'ar' => 'نوع الكاميرا'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['DSLR', 'Mirrorless', 'Compact', 'Action Camera', 'Drone Camera', 'Film Camera', 'Instant Camera', 'Other'],
                'depends_on' => null,
                'sort_order' => 2
            ]
        );

        $cameraTypeAttribute->categories()->syncWithoutDetaching([$cameras->id]);

        $megapixelsAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Megapixels'],
            [
                'name' => ['en' => 'Megapixels', 'ar' => 'الميجابكسل'],
                'attribute_type' => 'number',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 3
            ]
        );

        $megapixelsAttribute->categories()->syncWithoutDetaching([$cameras->id]);

        $audioBrands = ['Sony', 'Bose', 'JBL', 'Sennheiser', 'Audio-Technica', 'Beats', 'Harman Kardon', 'Marshall', 'Apple', 'Samsung', 'Anker', 'Other'];

        $audioBrandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Audio Brand'],
            [
                'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => $audioBrands,
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $audioBrandAttribute->categories()->syncWithoutDetaching([$audio->id]);

        $audioTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Audio Type'],
            [
                'name' => ['en' => 'Type', 'ar' => 'النوع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Headphones', 'Earbuds', 'Speakers', 'Soundbar', 'Home Theater', 'Portable Speaker', 'Microphone', 'Amplifier', 'Other'],
                'depends_on' => null,
                'sort_order' => 2
            ]
        );

        $audioTypeAttribute->categories()->syncWithoutDetaching([$audio->id]);

        $connectivityAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Connectivity'],
            [
                'name' => ['en' => 'Connectivity', 'ar' => 'الاتصال'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Wired', 'Wireless', 'Bluetooth', 'Wi-Fi', 'USB', 'AUX', 'Other'],
                'depends_on' => null,
                'sort_order' => 3
            ]
        );

        $connectivityAttribute->categories()->syncWithoutDetaching([$audio->id]);

        $properties = Category::whereRaw("(name::json->>'en') = ?", ['Properties'])->first();

        $apartmentsSale = Category::whereRaw("(name::json->>'en') = ?", ['Apartments for Sale'])
            ->where('parent_id', $properties->id)
            ->first();

        $apartmentsRent = Category::whereRaw("(name::json->>'en') = ?", ['Apartments for Rent'])
            ->where('parent_id', $properties->id)
            ->first();

        $villas = Category::whereRaw("(name::json->>'en') = ?", ['Villas'])
            ->where('parent_id', $properties->id)
            ->first();

        $commercial = Category::whereRaw("(name::json->>'en') = ?", ['Commercial Properties'])
            ->where('parent_id', $properties->id)
            ->first();

        $lands = Category::whereRaw("(name::json->>'en') = ?", ['Lands'])
            ->where('parent_id', $properties->id)
            ->first();

        $areaAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Area'],
            [
                'name' => ['en' => 'Area (m²)', 'ar' => 'المساحة'],
                'attribute_type' => 'number',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $areaAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $apartmentsRent->id, $villas->id, $commercial->id, $lands->id]);

        $roomsAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Rooms'],
            [
                'name' => ['en' => 'Rooms', 'ar' => 'الغرف'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Studio', '1', '2', '3', '4', '5', '6+', 'Other'],
                'depends_on' => null,
                'sort_order' => 2
            ]
        );

        $roomsAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $apartmentsRent->id, $villas->id]);

        $bathroomsAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Bathrooms'],
            [
                'name' => ['en' => 'Bathrooms', 'ar' => 'الحمامات'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['1', '2', '3', '4', '5', '6+', 'Other'],
                'depends_on' => null,
                'sort_order' => 3
            ]
        );

        $bathroomsAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $apartmentsRent->id, $villas->id]);

        $floorNumberAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Floor Number'],
            [
                'name' => ['en' => 'Floor Number', 'ar' => 'رقم الدور'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Ground', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10+', 'Other'],
                'depends_on' => null,
                'sort_order' => 4
            ]
        );

        $floorNumberAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $apartmentsRent->id]);

        $finishingTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Finishing Type'],
            [
                'name' => ['en' => 'Finishing Type', 'ar' => 'نوع التشطيب'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Without Finishing', 'Semi-Finished', 'Fully Finished', 'Lux', 'Super Lux', 'Ultra Lux', 'Other'],
                'depends_on' => null,
                'sort_order' => 5
            ]
        );

        $finishingTypeAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $apartmentsRent->id, $villas->id, $commercial->id]);

        $furnishedAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Furnished'],
            [
                'name' => ['en' => 'Furnished', 'ar' => 'مفروش'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Unfurnished', 'Semi-Furnished', 'Fully Furnished', 'Other'],
                'depends_on' => null,
                'sort_order' => 6
            ]
        );

        $furnishedAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $apartmentsRent->id, $villas->id, $commercial->id]);

        $paymentMethodAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Payment Method'],
            [
                'name' => ['en' => 'Payment Method', 'ar' => 'طريقة الدفع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Cash', 'Installments', 'Both', 'Other'],
                'depends_on' => null,
                'sort_order' => 7
            ]
        );

        $paymentMethodAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $villas->id, $commercial->id, $lands->id]);

        $deliveryDateAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Delivery Date'],
            [
                'name' => ['en' => 'Delivery Date', 'ar' => 'تاريخ التسليم'],
                'attribute_type' => 'date',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 8
            ]
        );

        $deliveryDateAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $villas->id, $commercial->id]);

        $propertyLocationAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Property Location'],
            [
                'name' => ['en' => 'Location', 'ar' => 'الموقع'],
                'attribute_type' => 'text',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 9
            ]
        );

        $propertyLocationAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $apartmentsRent->id, $villas->id, $commercial->id, $lands->id]);

        $propertyPriceAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Property Price'],
            [
                'name' => ['en' => 'Price', 'ar' => 'السعر'],
                'attribute_type' => 'number',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 10
            ]
        );

        $propertyPriceAttribute->categories()->syncWithoutDetaching([$apartmentsSale->id, $apartmentsRent->id, $villas->id, $commercial->id, $lands->id]);

        $commercialTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Commercial Type'],
            [
                'name' => ['en' => 'Type', 'ar' => 'النوع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Office', 'Shop', 'Warehouse', 'Showroom', 'Restaurant', 'Clinic', 'Pharmacy', 'Factory', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $commercialTypeAttribute->categories()->syncWithoutDetaching([$commercial->id]);

        $landTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Land Type'],
            [
                'name' => ['en' => 'Type', 'ar' => 'النوع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Residential', 'Commercial', 'Agricultural', 'Industrial', 'Mixed Use', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $landTypeAttribute->categories()->syncWithoutDetaching([$lands->id]);

        $homeAppliances = Category::whereRaw("(name::json->>'en') = ?", ['Home Appliances'])->first();

        $refrigerators = Category::whereRaw("(name::json->>'en') = ?", ['Refrigerators'])
            ->where('parent_id', $homeAppliances->id)
            ->first();

        $washingMachines = Category::whereRaw("(name::json->>'en') = ?", ['Washing Machines'])
            ->where('parent_id', $homeAppliances->id)
            ->first();

        $airConditioners = Category::whereRaw("(name::json->>'en') = ?", ['Air Conditioners'])
            ->where('parent_id', $homeAppliances->id)
            ->first();

        $ovens = Category::whereRaw("(name::json->>'en') = ?", ['Ovens'])
            ->where('parent_id', $homeAppliances->id)
            ->first();

        $microwaves = Category::whereRaw("(name::json->>'en') = ?", ['Microwaves'])
            ->where('parent_id', $homeAppliances->id)
            ->first();

        $applianceBrands = ['Samsung', 'LG', 'Whirlpool', 'Bosch', 'Siemens', 'Electrolux', 'Frigidaire', 'GE', 'Haier', 'Toshiba', 'Sharp', 'Panasonic', 'Ariston', 'Beko', 'Midea', 'Other'];

        $applianceBrandAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Appliance Brand'],
            [
                'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => $applianceBrands,
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $applianceBrandAttribute->categories()->syncWithoutDetaching([$refrigerators->id, $washingMachines->id, $airConditioners->id, $ovens->id, $microwaves->id]);

        $applianceModelAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Appliance Model'],
            [
                'name' => ['en' => 'Model', 'ar' => 'الموديل'],
                'attribute_type' => 'text',
                'is_required' => false,
                'is_filterable' => false,
                'filter_type' => 'exact',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 2
            ]
        );

        $applianceModelAttribute->categories()->syncWithoutDetaching([$refrigerators->id, $washingMachines->id, $airConditioners->id, $ovens->id, $microwaves->id]);

        $powerAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Power'],
            [
                'name' => ['en' => 'Power (Watt)', 'ar' => 'القوة'],
                'attribute_type' => 'number',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 3
            ]
        );

        $powerAttribute->categories()->syncWithoutDetaching([$refrigerators->id, $washingMachines->id, $airConditioners->id, $ovens->id, $microwaves->id]);

        $capacityAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Capacity'],
            [
                'name' => ['en' => 'Capacity', 'ar' => 'السعة'],
                'attribute_type' => 'text',
                'is_required' => false,
                'is_filterable' => false,
                'filter_type' => 'exact',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 4
            ]
        );

        $capacityAttribute->categories()->syncWithoutDetaching([$refrigerators->id, $washingMachines->id, $ovens->id, $microwaves->id]);

        $applianceConditionAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Appliance Condition'],
            [
                'name' => ['en' => 'Condition', 'ar' => 'الحالة'],
                'attribute_type' => 'select',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['New', 'Used - Like New', 'Used - Good', 'Used - Fair', 'Refurbished', 'Other'],
                'depends_on' => null,
                'sort_order' => 5
            ]
        );

        $applianceConditionAttribute->categories()->syncWithoutDetaching([$refrigerators->id, $washingMachines->id, $airConditioners->id, $ovens->id, $microwaves->id]);

        $applianceWarrantyAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Appliance Warranty'],
            [
                'name' => ['en' => 'Warranty', 'ar' => 'الضمان'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['No Warranty', 'Under Warranty', '6 Months', '1 Year', '2 Years', '5 Years', 'Extended Warranty', 'Other'],
                'depends_on' => null,
                'sort_order' => 6
            ]
        );

        $applianceWarrantyAttribute->categories()->syncWithoutDetaching([$refrigerators->id, $washingMachines->id, $airConditioners->id, $ovens->id, $microwaves->id]);

        $applianceColorAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Appliance Color'],
            [
                'name' => ['en' => 'Color', 'ar' => 'اللون'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'multiselect',
                'options' => ['White', 'Black', 'Silver', 'Stainless Steel', 'Gray', 'Red', 'Blue', 'Other'],
                'depends_on' => null,
                'sort_order' => 7
            ]
        );

        $applianceColorAttribute->categories()->syncWithoutDetaching([$refrigerators->id, $washingMachines->id, $airConditioners->id, $ovens->id, $microwaves->id]);

        $appliancePriceAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Appliance Price'],
            [
                'name' => ['en' => 'Price', 'ar' => 'السعر'],
                'attribute_type' => 'number',
                'is_required' => true,
                'is_filterable' => true,
                'filter_type' => 'range',
                'options' => null,
                'depends_on' => null,
                'sort_order' => 8
            ]
        );

        $appliancePriceAttribute->categories()->syncWithoutDetaching([$refrigerators->id, $washingMachines->id, $airConditioners->id, $ovens->id, $microwaves->id]);

        $refrigeratorTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Refrigerator Type'],
            [
                'name' => ['en' => 'Type', 'ar' => 'النوع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Top Freezer', 'Bottom Freezer', 'Side by Side', 'French Door', 'Mini Fridge', 'Built-in', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $refrigeratorTypeAttribute->categories()->syncWithoutDetaching([$refrigerators->id]);

        $washingMachineTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Washing Machine Type'],
            [
                'name' => ['en' => 'Type', 'ar' => 'النوع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Top Load', 'Front Load', 'Semi-Automatic', 'Fully Automatic', 'Washer-Dryer', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $washingMachineTypeAttribute->categories()->syncWithoutDetaching([$washingMachines->id]);

        $acTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'AC Type'],
            [
                'name' => ['en' => 'Type', 'ar' => 'النوع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Split', 'Window', 'Portable', 'Central', 'Cassette', 'Floor Standing', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $acTypeAttribute->categories()->syncWithoutDetaching([$airConditioners->id]);

        $coolingCapacityAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Cooling Capacity'],
            [
                'name' => ['en' => 'Cooling Capacity (BTU)', 'ar' => 'سعة التبريد'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['6000', '9000', '12000', '18000', '24000', '30000', '36000', '48000', 'Other'],
                'depends_on' => null,
                'sort_order' => 2
            ]
        );

        $coolingCapacityAttribute->categories()->syncWithoutDetaching([$airConditioners->id]);

        $ovenTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Oven Type'],
            [
                'name' => ['en' => 'Type', 'ar' => 'النوع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Electric', 'Gas', 'Built-in', 'Freestanding', 'Convection', 'Toaster Oven', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $ovenTypeAttribute->categories()->syncWithoutDetaching([$ovens->id]);

        $microwaveTypeAttribute = CategoryAttribute::updateOrCreate(
            ['name->en' => 'Microwave Type'],
            [
                'name' => ['en' => 'Type', 'ar' => 'النوع'],
                'attribute_type' => 'select',
                'is_required' => false,
                'is_filterable' => true,
                'filter_type' => 'exact',
                'options' => ['Solo', 'Grill', 'Convection', 'Built-in', 'Over-the-Range', 'Other'],
                'depends_on' => null,
                'sort_order' => 1
            ]
        );

        $microwaveTypeAttribute->categories()->syncWithoutDetaching([$microwaves->id]);

        $fashion = Category::whereRaw("(name::json->>'en') = ?", ['Fashion & Clothing'])->first();

        $men = Category::whereRaw("(name::json->>'en') = ?", ['Men\'s Clothing'])
            ->where('parent_id', $fashion->id)
            ->first();

        $women = Category::whereRaw("(name::json->>'en') = ?", ['Women\'s Clothing'])
            ->where('parent_id', $fashion->id)
            ->first();

        $kids = Category::whereRaw("(name::json->>'en') = ?", ['Kids\' Clothing'])
            ->where('parent_id', $fashion->id)
            ->first();

        $shoes = Category::whereRaw("(name::json->>'en') = ?", ['Shoes'])
            ->where('parent_id', $fashion->id)
            ->first();

        $bags = Category::whereRaw("(name::json->>'en') = ?", ['Bags'])
            ->where('parent_id', $fashion->id)
            ->first();

        $fashionBrands = ['Nike', 'Adidas', 'Zara', 'H&M', 'Gucci', 'Prada', 'Louis Vuitton', 'Chanel', 'Dior', 'Versace', 'Calvin Klein', 'Tommy Hilfiger', 'Polo Ralph Lauren', 'Lacoste', 'Puma', 'Reebok', 'Under Armour', 'The North Face', 'Levi\'s', 'Mango', 'Massimo Dutti', 'Pull & Bear', 'Bershka', 'Stradivarius', 'Other'];

        // $fashionBrandAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Fashion Brand'],
        //     [
        //         'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => $fashionBrands,
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $fashionBrandAttribute->categories()->syncWithoutDetaching([$men->id, $women->id, $kids->id, $shoes->id, $bags->id]);

        // $sizeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Size'],
        //     [
        //         'name' => ['en' => 'Size', 'ar' => 'المقاس'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'multiselect',
        //         'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Free Size', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 2
        //     ]
        // );

        // $sizeAttribute->categories()->syncWithoutDetaching([$men->id, $women->id, $kids->id]);

        // $fashionColorAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Fashion Color'],
        //     [
        //         'name' => ['en' => 'Color', 'ar' => 'اللون'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'multiselect',
        //         'options' => ['Black', 'White', 'Gray', 'Navy', 'Blue', 'Red', 'Green', 'Yellow', 'Orange', 'Pink', 'Purple', 'Brown', 'Beige', 'Khaki', 'Multi-color', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 3
        //     ]
        // );

        // $fashionColorAttribute->categories()->syncWithoutDetaching([$men->id, $women->id, $kids->id, $shoes->id, $bags->id]);

        // $fashionConditionAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Fashion Condition'],
        //     [
        //         'name' => ['en' => 'Condition', 'ar' => 'الحالة'],
        //         'attribute_type' => 'select',
        //         'is_required' => true,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['New with Tags', 'New without Tags', 'Used - Like New', 'Used - Good', 'Used - Fair', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 4
        //     ]
        // );

        // $fashionConditionAttribute->categories()->syncWithoutDetaching([$men->id, $women->id, $kids->id, $shoes->id, $bags->id]);

        // $materialAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Material'],
        //     [
        //         'name' => ['en' => 'Material', 'ar' => 'المادة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'multiselect',
        //         'options' => ['Cotton', 'Polyester', 'Wool', 'Silk', 'Leather', 'Denim', 'Linen', 'Nylon', 'Synthetic', 'Mixed', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 5
        //     ]
        // );

        // $materialAttribute->categories()->syncWithoutDetaching([$men->id, $women->id, $kids->id, $shoes->id, $bags->id]);

        // $genderAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Gender'],
        //     [
        //         'name' => ['en' => 'Gender', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Men', 'Women', 'Boys', 'Girls', 'Unisex', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 6
        //     ]
        // );

        // $genderAttribute->categories()->syncWithoutDetaching([$men->id, $women->id, $kids->id, $shoes->id, $bags->id]);

        // // $fashionPriceAttribute = CategoryAttribute::updateOrCreate(
        // //     ['name->en' => 'Fashion Price'],
        // //     [
        // //         'name' => ['en' => 'Price', 'ar' => 'السعر'],
        // //         'attribute_type' => 'number',
        // //         'is_required' => true,
        // //         'is_filterable' => true,
        // //         'filter_type' => 'range',
        // //         'options' => null,
        // //         'depends_on' => null,
        // //         'sort_order' => 7
        // //     ]
        // // );

        // // $fashionPriceAttribute->categories()->syncWithoutDetaching([$men->id, $women->id, $kids->id, $shoes->id, $bags->id]);

        // $shoeSizeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Shoe Size'],
        //     [
        //         'name' => ['en' => 'Shoe Size', 'ar' => 'مقاس الحذاء'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $shoeSizeAttribute->categories()->syncWithoutDetaching([$shoes->id]);

        // $bagTypeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Bag Type'],
        //     [
        //         'name' => ['en' => 'Type', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Handbag', 'Backpack', 'Shoulder Bag', 'Crossbody', 'Clutch', 'Tote', 'Messenger', 'Wallet', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $bagTypeAttribute->categories()->syncWithoutDetaching([$bags->id]);

        // $sports = Category::whereRaw("(name::json->>'en') = ?", ['Sports & Fitness'])->first();

        // $equipment = Category::whereRaw("(name::json->>'en') = ?", ['Equipment'])
        //     ->where('parent_id', $sports->id)
        //     ->first();

        // $bikes = Category::whereRaw("(name::json->>'en') = ?", ['Bikes'])
        //     ->where('parent_id', $sports->id)
        //     ->first();

        // $accessories = Category::whereRaw("(name::json->>'en') = ?", ['Accessories'])
        //     ->where('parent_id', $sports->id)
        //     ->first();

        // $sportsBrandAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Sports Brand'],
        //     [
        //         'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Nike', 'Adidas', 'Puma', 'Reebok', 'Under Armour', 'New Balance', 'Asics', 'Decathlon', 'Spalding', 'Wilson', 'Head', 'Yonex', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $sportsBrandAttribute->categories()->syncWithoutDetaching([$equipment->id, $bikes->id, $accessories->id]);

        // $sportsTypeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Sports Type'],
        //     [
        //         'name' => ['en' => 'Type', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Gym Equipment', 'Weights', 'Cardio', 'Yoga', 'Swimming', 'Football', 'Basketball', 'Tennis', 'Cycling', 'Running', 'Boxing', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 2
        //     ]
        // );

        // $sportsTypeAttribute->categories()->syncWithoutDetaching([$equipment->id, $accessories->id]);

        // $sportsConditionAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Sports Condition'],
        //     [
        //         'name' => ['en' => 'Condition', 'ar' => 'الحالة'],
        //         'attribute_type' => 'select',
        //         'is_required' => true,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['New', 'Used - Like New', 'Used - Good', 'Used - Fair', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 3
        //     ]
        // );

        // $sportsConditionAttribute->categories()->syncWithoutDetaching([$equipment->id, $bikes->id, $accessories->id]);

        // $sportsSizeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Sports Size'],
        //     [
        //         'name' => ['en' => 'Size', 'ar' => 'المقاس'],
        //         'attribute_type' => 'text',
        //         'is_required' => false,
        //         'is_filterable' => false,
        //         'filter_type' => 'exact',
        //         'options' => null,
        //         'depends_on' => null,
        //         'sort_order' => 4
        //     ]
        // );

        // $sportsSizeAttribute->categories()->syncWithoutDetaching([$equipment->id, $bikes->id, $accessories->id]);

        // $sportsMaterialAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Sports Material'],
        //     [
        //         'name' => ['en' => 'Material', 'ar' => 'المادة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'multiselect',
        //         'options' => ['Metal', 'Plastic', 'Rubber', 'Leather', 'Fabric', 'Carbon Fiber', 'Aluminum', 'Steel', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 5
        //     ]
        // );

        // $sportsMaterialAttribute->categories()->syncWithoutDetaching([$equipment->id, $bikes->id, $accessories->id]);

        // $sportsColorAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Sports Color'],
        //     [
        //         'name' => ['en' => 'Color', 'ar' => 'اللون'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'multiselect',
        //         'options' => ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Silver', 'Gray', 'Multi-color', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 6
        //     ]
        // );

        // $sportsColorAttribute->categories()->syncWithoutDetaching([$equipment->id, $bikes->id, $accessories->id]);

        // $sportsPriceAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Sports Price'],
        //     [
        //         'name' => ['en' => 'Price', 'ar' => 'السعر'],
        //         'attribute_type' => 'number',
        //         'is_required' => true,
        //         'is_filterable' => true,
        //         'filter_type' => 'range',
        //         'options' => null,
        //         'depends_on' => null,
        //         'sort_order' => 7
        //     ]
        // );

        // $sportsPriceAttribute->categories()->syncWithoutDetaching([$equipment->id, $bikes->id, $accessories->id]);

        // $bikeTypeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Bike Type'],
        //     [
        //         'name' => ['en' => 'Type', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Mountain Bike', 'Road Bike', 'Hybrid Bike', 'BMX', 'Electric Bike', 'Folding Bike', 'Cruiser', 'Kids Bike', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $bikeTypeAttribute->categories()->syncWithoutDetaching([$bikes->id]);

        // $wheelSizeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Wheel Size'],
        //     [
        //         'name' => ['en' => 'Wheel Size (inches)', 'ar' => 'حجم العجلة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['12', '14', '16', '18', '20', '24', '26', '27.5', '29', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 2
        //     ]
        // );

        // $wheelSizeAttribute->categories()->syncWithoutDetaching([$bikes->id]);

        // $hobbies = Category::whereRaw("(name::json->>'en') = ?", ['Hobbies & Leisure'])->first();

        // $books = Category::whereRaw("(name::json->>'en') = ?", ['Books'])
        //     ->where('parent_id', $hobbies->id)
        //     ->first();

        // $music = Category::whereRaw("(name::json->>'en') = ?", ['Music'])
        //     ->where('parent_id', $hobbies->id)
        //     ->first();

        // $instruments = Category::whereRaw("(name::json->>'en') = ?", ['Instruments'])
        //     ->where('parent_id', $hobbies->id)
        //     ->first();

        // $toys = Category::whereRaw("(name::json->>'en') = ?", ['Toys'])
        //     ->where('parent_id', $hobbies->id)
        //     ->first();

        // $games = Category::whereRaw("(name::json->>'en') = ?", ['Games'])
        //     ->where('parent_id', $hobbies->id)
        //     ->first();

        // $hobbyTypeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Hobby Type'],
        //     [
        //         'name' => ['en' => 'Type', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Fiction', 'Non-Fiction', 'Educational', 'Comics', 'Magazines', 'Reference', 'Biography', 'Self-Help', 'History', 'Science', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $hobbyTypeAttribute->categories()->syncWithoutDetaching([$books->id]);

        // $hobbyBrandAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Hobby Brand'],
        //     [
        //         'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
        //         'attribute_type' => 'text',
        //         'is_required' => false,
        //         'is_filterable' => false,
        //         'filter_type' => 'exact',
        //         'options' => null,
        //         'depends_on' => null,
        //         'sort_order' => 2
        //     ]
        // );

        // $hobbyBrandAttribute->categories()->syncWithoutDetaching([$music->id, $instruments->id, $toys->id, $games->id]);

        // $hobbyConditionAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Hobby Condition'],
        //     [
        //         'name' => ['en' => 'Condition', 'ar' => 'الحالة'],
        //         'attribute_type' => 'select',
        //         'is_required' => true,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['New', 'Used - Like New', 'Used - Good', 'Used - Fair', 'Collectible', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 3
        //     ]
        // );

        // $hobbyConditionAttribute->categories()->syncWithoutDetaching([$books->id, $music->id, $instruments->id, $toys->id, $games->id]);

        // $ageGroupAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Age Group'],
        //     [
        //         'name' => ['en' => 'Age Group', 'ar' => 'الفئة العمرية'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['0-2 years', '3-5 years', '6-8 years', '9-12 years', '13+ years', 'Adult', 'All Ages', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 4
        //     ]
        // );

        // $ageGroupAttribute->categories()->syncWithoutDetaching([$books->id, $toys->id, $games->id]);

        // $hobbyMaterialAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Hobby Material'],
        //     [
        //         'name' => ['en' => 'Material', 'ar' => 'المادة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'multiselect',
        //         'options' => ['Wood', 'Plastic', 'Metal', 'Fabric', 'Paper', 'Electronic', 'Mixed', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 5
        //     ]
        // );

        // $hobbyMaterialAttribute->categories()->syncWithoutDetaching([$instruments->id, $toys->id, $games->id]);

        // $hobbyPriceAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Hobby Price'],
        //     [
        //         'name' => ['en' => 'Price', 'ar' => 'السعر'],
        //         'attribute_type' => 'number',
        //         'is_required' => true,
        //         'is_filterable' => true,
        //         'filter_type' => 'range',
        //         'options' => null,
        //         'depends_on' => null,
        //         'sort_order' => 6
        //     ]
        // );

        // $hobbyPriceAttribute->categories()->syncWithoutDetaching([$books->id, $music->id, $instruments->id, $toys->id, $games->id]);

        // $instrumentTypeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Instrument Type'],
        //     [
        //         'name' => ['en' => 'Type', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Guitar', 'Piano', 'Keyboard', 'Drums', 'Violin', 'Flute', 'Saxophone', 'Trumpet', 'Oud', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $instrumentTypeAttribute->categories()->syncWithoutDetaching([$instruments->id]);

        // $gameTypeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Game Type'],
        //     [
        //         'name' => ['en' => 'Type', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Video Games', 'Board Games', 'Card Games', 'Puzzle', 'Educational', 'Party Games', 'Strategy', 'Action', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $gameTypeAttribute->categories()->syncWithoutDetaching([$games->id]);

        // $platformAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Platform'],
        //     [
        //         'name' => ['en' => 'Platform', 'ar' => 'المنصة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['PlayStation 5', 'PlayStation 4', 'Xbox Series X/S', 'Xbox One', 'Nintendo Switch', 'PC', 'Mobile', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 2
        //     ]
        // );

        // $platformAttribute->categories()->syncWithoutDetaching([$games->id]);

        // $furniture = Category::whereRaw("(name::json->>'en') = ?", ['Furniture & Garden'])->first();

        // $indoor = Category::whereRaw("(name::json->>'en') = ?", ['Indoor'])
        //     ->where('parent_id', $furniture->id)
        //     ->first();

        // $outdoor = Category::whereRaw("(name::json->>'en') = ?", ['Outdoor'])
        //     ->where('parent_id', $furniture->id)
        //     ->first();

        // $office = Category::whereRaw("(name::json->>'en') = ?", ['Office'])
        //     ->where('parent_id', $furniture->id)
        //     ->first();

        // $gardenTools = Category::whereRaw("(name::json->>'en') = ?", ['Garden Tools'])
        //     ->where('parent_id', $furniture->id)
        //     ->first();

        // $furnitureTypeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Furniture Type'],
        //     [
        //         'name' => ['en' => 'Type', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Sofa', 'Bed', 'Chair', 'Table', 'Cabinet', 'Wardrobe', 'Dresser', 'Shelf', 'Desk', 'Dining Set', 'Living Room Set', 'Bedroom Set', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $furnitureTypeAttribute->categories()->syncWithoutDetaching([$indoor->id, $outdoor->id, $office->id]);

        // $furnitureMaterialAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Furniture Material'],
        //     [
        //         'name' => ['en' => 'Material', 'ar' => 'المادة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'multiselect',
        //         'options' => ['Wood', 'Metal', 'Plastic', 'Glass', 'Leather', 'Fabric', 'Rattan', 'Wicker', 'Mixed', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 2
        //     ]
        // );

        // $furnitureMaterialAttribute->categories()->syncWithoutDetaching([$indoor->id, $outdoor->id, $office->id]);

        // $furnitureColorAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Furniture Color'],
        //     [
        //         'name' => ['en' => 'Color', 'ar' => 'اللون'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'multiselect',
        //         'options' => ['White', 'Black', 'Brown', 'Beige', 'Gray', 'Blue', 'Green', 'Red', 'Natural Wood', 'Multi-color', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 3
        //     ]
        // );

        // $furnitureColorAttribute->categories()->syncWithoutDetaching([$indoor->id, $outdoor->id, $office->id]);

        // $furnitureConditionAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Furniture Condition'],
        //     [
        //         'name' => ['en' => 'Condition', 'ar' => 'الحالة'],
        //         'attribute_type' => 'select',
        //         'is_required' => true,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['New', 'Used - Like New', 'Used - Good', 'Used - Fair', 'Antique', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 4
        //     ]
        // );

        // $furnitureConditionAttribute->categories()->syncWithoutDetaching([$indoor->id, $outdoor->id, $office->id, $gardenTools->id]);

        // $dimensionsAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Dimensions'],
        //     [
        //         'name' => ['en' => 'Dimensions', 'ar' => 'الأبعاد'],
        //         'attribute_type' => 'text',
        //         'is_required' => false,
        //         'is_filterable' => false,
        //         'filter_type' => 'exact',
        //         'options' => null,
        //         'depends_on' => null,
        //         'sort_order' => 5
        //     ]
        // );

        // $dimensionsAttribute->categories()->syncWithoutDetaching([$indoor->id, $outdoor->id, $office->id]);

        // $furniturePriceAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Furniture Price'],
        //     [
        //         'name' => ['en' => 'Price', 'ar' => 'السعر'],
        //         'attribute_type' => 'number',
        //         'is_required' => true,
        //         'is_filterable' => true,
        //         'filter_type' => 'range',
        //         'options' => null,
        //         'depends_on' => null,
        //         'sort_order' => 6
        //     ]
        // );

        // $furniturePriceAttribute->categories()->syncWithoutDetaching([$indoor->id, $outdoor->id, $office->id, $gardenTools->id]);

        // $gardenToolTypeAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Garden Tool Type'],
        //     [
        //         'name' => ['en' => 'Type', 'ar' => 'النوع'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Lawn Mower', 'Trimmer', 'Chainsaw', 'Hedge Trimmer', 'Pressure Washer', 'Garden Hose', 'Sprinkler', 'Hand Tools', 'Planter', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 1
        //     ]
        // );

        // $gardenToolTypeAttribute->categories()->syncWithoutDetaching([$gardenTools->id]);

        // $powerSourceAttribute = CategoryAttribute::updateOrCreate(
        //     ['name->en' => 'Power Source'],
        //     [
        //         'name' => ['en' => 'Power Source', 'ar' => 'مصدر الطاقة'],
        //         'attribute_type' => 'select',
        //         'is_required' => false,
        //         'is_filterable' => true,
        //         'filter_type' => 'exact',
        //         'options' => ['Manual', 'Electric', 'Battery', 'Gasoline', 'Solar', 'Other'],
        //         'depends_on' => null,
        //         'sort_order' => 2
        //     ]
        // );

        // $powerSourceAttribute->categories()->syncWithoutDetaching([$gardenTools->id]);
    }
}
