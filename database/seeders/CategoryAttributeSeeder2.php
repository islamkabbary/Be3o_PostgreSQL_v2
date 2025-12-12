<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryAttribute;

class CategoryAttributeSeeder2 extends Seeder
{
    public function run(): void
    {
        /** ===== VEHICLES ===== **/
        $carsForSale = Category::where('slug', 'cars-for-sale')->first();

        // كل ماركة مرتبطة بالموديلات الخاصة بها
        $vehicleBrands = [
            'BMW' => ['3 Series', '5 Series', '7 Series', 'X5', 'X6'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLS'],
            'Toyota' => ['Corolla', 'Camry', 'Hilux', 'Land Cruiser', 'RAV4'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Palisade', 'Kona'],
            'Nissan' => ['Altima', 'Maxima', '370Z', 'Rogue', 'Pathfinder'],
            'Chevrolet' => ['Malibu', 'Cruze', 'Tahoe', 'Traverse', 'Equinox'],
            'Chery' => ['Tiggo 2', 'Tiggo 3', 'Tiggo 7', 'Arrizo 5', 'Arrizo 7'],
            'Kia' => ['Cerato', 'Optima', 'Sportage', 'Seltos', 'Sorento'],
            'MG' => ['MG3', 'MG5', 'MG6', 'ZS', 'HS'],
            'BYD' => ['F3', 'F6', 'Tang', 'Song', 'Qin'],
            'Fiat' => ['Punto', 'Tipo', '500', 'Panda', 'Doblo'],
            'Renault' => ['Clio', 'Megane', 'Captur', 'Koleos', 'Talisman'],
            'Peugeot' => ['208', '308', '3008', '5008', '508'],
            'Mazda' => ['Mazda2', 'Mazda3', 'Mazda6', 'CX-5', 'CX-9'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'HR-V'],
            'Suzuki' => ['Swift', 'Baleno', 'Vitara', 'S-Cross', 'Jimny'],
            'Jeep' => ['Cherokee', 'Grand Cherokee', 'Wrangler', 'Renegade', 'Compass'],
            'Land Rover' => ['Range Rover', 'Discovery', 'Defender', 'Evoque', 'Velar'],
            'Porsche' => ['911', 'Cayenne', 'Macan', 'Panamera', 'Taycan'],
            'Audi' => ['A3', 'A4', 'A6', 'Q5', 'Q7'],
            'Volkswagen' => ['Golf', 'Passat', 'Tiguan', 'Touareg', 'Arteon'],
            'Ford' => ['Fiesta', 'Focus', 'Mondeo', 'Kuga', 'Explorer'],
            'Changan' => ['CS35', 'CS55', 'CS75', 'Eado', 'Raeton'],
            'Opel' => ['Astra', 'Insignia', 'Grandland', 'Corsa', 'Mokka'],
            'Mitsubishi' => ['Outlander', 'Lancer', 'Pajero', 'ASX', 'Eclipse Cross'],
            'Citroën' => ['C3', 'C4', 'C5', 'C3 Aircross', 'C5 Aircross'],
            'Dacia' => ['Sandero', 'Logan', 'Lodgy', 'Dokker', 'Spring'],
            'Lexus' => ['IS', 'ES', 'RX', 'NX', 'LX'],
            'Mini' => ['Mini Cooper', 'Clubman', 'Countryman', 'Convertible', 'Paceman'],
            'Jaguar' => ['XE', 'XF', 'XJ', 'F-Pace', 'E-Pace'],
            'Volvo' => ['S60', 'S90', 'XC60', 'XC90', 'V60'],
            'Subaru' => ['Impreza', 'Outback', 'Forester', 'XV', 'Legacy'],
            'Great Wall' => ['Haval H2', 'Haval H6', 'Haval H9', 'Wingle', 'Steed'],
            'GAC' => ['GS4', 'GS5', 'GS8', 'Trumpchi', 'Enverge'],
            'Foton' => ['Tunland', 'Auman', 'View', 'Sauvana', 'Forland'],
            'Dongfeng' => ['AX7', 'AX5', 'Rich', 'Forthing', 'Joyear'],
            'Geely' => ['Emgrand', 'Atlas', 'Coolray', 'Binyue', 'Geometry'],
            'SAIC' => ['MG', 'Roewe', 'Baojun', 'Maxus', 'Wuling'],
            'Tata' => ['Indica', 'Indigo', 'Nexon', 'Harrier', 'Safari'],
            'Mahindra' => ['Thar', 'XUV700', 'Scorpio', 'Bolero', 'KUV100'],
            'Proton' => ['Saga', 'Persona', 'Iriz', 'X70', 'X50'],
            'Haval' => ['H2', 'H6', 'H9', 'F5', 'F7'],
            'Jetour' => ['X70', 'X90', 'X95', 'X70S', 'X90S'],
            'Omoda' => ['Omoda 5', 'Omoda 7'],
            'Jaecoo' => ['Jaecoo 7', 'Jaecoo 9']
        ];

        $this->createAttributes($carsForSale, [
            [
                'name' => ['en' => 'Brand', 'ar' => 'الماركة'],
                'type' => 'select',
                'required' => true,
                'options' => array_keys($vehicleBrands),
            ],
            [
                'name' => ['en' => 'Model', 'ar' => 'الموديل'],
                'type' => 'select',
                'required' => true,
                'options' => $vehicleBrands, 
                'depends_on' => 'Brand',
            ],
            [
                'name' => ['en' => 'Condition', 'ar' => 'الحالة'],
                'type' => 'checkbox',
                'required' => true,
                'options' => ['New', 'Used'],
            ],
            [
                'name' => ['en' => 'Year', 'ar' => 'السنة'],
                'type' => 'number',
                'required' => true,
            ],
        ]);
    }

    private function createAttributes(?Category $category, array $attributes): void
    {
        if (!$category) return;

        foreach ($attributes as $index => $attr) {
            $existing = CategoryAttribute::where('category_id', $category->id)->get()
                ->first(fn($a) => $a->getTranslation('name', 'en') === $attr['name']['en']);

            $data = [
                'name' => $attr['name'],
                'attribute_type' => $attr['type'],
                'is_required' => $attr['required'] ?? false,
                'is_searchable' => true,
                'is_filterable' => true,
                'options' => $attr['options'] ?? null,
                'sort_order' => $index + 1,
            ];

            if (isset($attr['depends_on'])) {
                $data['depends_on'] = $attr['depends_on'];
            }

            if ($existing) {
                $existing->update($data);
            } else {
                CategoryAttribute::create(array_merge($data, [
                    'category_id' => $category->id,
                ]));
            }
        }
    }
}
