<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. تعريف الفئات الرئيسية (Categories Parents)
        $mainCategoriesData = [
            [
                'name' => ['en' => 'Vehicles', 'ar' => 'عربيات واكسسواراتها'],
                'slug' => 'vehicles',
                'description' => ['en' => 'Cars, motorcycles, and other vehicles for sale or rent.', 'ar' => 'بيع وشراء وتأجير السيارات والدراجات وجميع وسائل النقل.'],
                'icon_url' => 'icon/vehicles.svg',
                'image_url' => 'image/vehicles.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => ['en' => 'Properties', 'ar' => 'العقارات'],
                'slug' => 'properties',
                'description' => ['en' => 'Apartments, villas, and lands for sale or rent.', 'ar' => 'شقق وفلل وأراضي للبيع أو الإيجار.'],
                'icon_url' => 'icon/properties.svg',
                'image_url' => 'image/properties.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => ['en' => 'Electronics', 'ar' => 'الإلكترونيات'],
                'slug' => 'electronics',
                'description' => ['en' => 'Mobiles, Laptops, TVs, Cameras, and other electronic devices.', 'ar' => 'هواتف محمولة، لابتوبات، تلفزيونات، كاميرات، وأجهزة إلكترونية أخرى.'],
                'icon_url' => 'icon/electronics.svg',
                'image_url' => 'image/electronics.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => ['en' => 'Home & Furniture', 'ar' => 'أثاث ومفروشات'],
                'slug' => 'home-furniture',
                'description' => ['en' => 'Indoor and outdoor furniture, home appliances, and decor.', 'ar' => 'أثاث داخلي وخارجي، أجهزة منزلية، وديكور.'],
                'icon_url' => 'icon/home-furniture.svg',
                'image_url' => 'image/home-furniture.jpg',
                'sort_order' => 4,
            ],
            [
                'name' => ['en' => 'Fashion & Clothing', 'ar' => 'أزياء وملابس'],
                'slug' => 'fashion-clothing',
                'description' => ['en' => 'Men\'s, women\'s, and kids\' apparel, shoes, and accessories.', 'ar' => 'ملابس رجالية ونسائية وأطفال، أحذية وإكسسوارات.'],
                'icon_url' => 'icon/fashion-clothing.svg',
                'image_url' => 'image/fashion-clothing.jpg',
                'sort_order' => 5,
            ],
            [
                'name' => ['en' => 'Jobs', 'ar' => 'وظائف'],
                'slug' => 'jobs',
                'description' => ['en' => 'Job postings for various fields.', 'ar' => 'فرص عمل بدوام كامل وجزئي وحر.'],
                'icon_url' => 'icon/jobs.svg',
                'image_url' => 'image/jobs.jpg',
                'sort_order' => 6,
            ],
            [
                'name' => ['en' => 'Services', 'ar' => 'خدمات'],
                'slug' => 'services',
                'description' => ['en' => 'Maintenance, cleaning, education, and various other services.', 'ar' => 'خدمات صيانة، نظافة، تعليم، وخدمات أخرى متنوعة.'],
                'icon_url' => 'icon/services.svg',
                'image_url' => 'image/services.jpg',
                'sort_order' => 7,
            ],
            [
                'name' => ['en' => 'Miscellaneous', 'ar' => 'متفرقات'],
                'slug' => 'miscellaneous',
                'description' => ['en' => 'Books, sports, pets, and other various items.', 'ar' => 'كتب، رياضة، حيوانات أليفة، وقطع متنوعة أخرى.'],
                'icon_url' => 'icon/miscellaneous.svg',
                'image_url' => 'image/miscellaneous.jpg',
                'sort_order' => 8,
            ],
        ];

        $mainCategories = [];
        foreach ($mainCategoriesData as $data) {
            $category = Category::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
            $mainCategories[$data['name']['en']] = $category;
        }
        
        // استرجاع معرّفات الفئات الرئيسية لربط الفئات الفرعية
        $vehicles = $mainCategories['Vehicles']->id;
        $properties = $mainCategories['Properties']->id;
        $electronics = $mainCategories['Electronics']->id;
        $homeFurniture = $mainCategories['Home & Furniture']->id;
        $fashionClothing = $mainCategories['Fashion & Clothing']->id;
        $jobs = $mainCategories['Jobs']->id;
        $services = $mainCategories['Services']->id;
        $miscellaneous = $mainCategories['Miscellaneous']->id;

        // 2. تعريف الفئات الفرعية المستوى الثاني (Level 2 Children)
        $childCategoriesData = [
            // --- Vehicles Children ---
            [
                'parent_id' => $vehicles,
                'name' => ['en' => 'Cars for Sale', 'ar' => 'سيارات للبيع'],
                'slug' => 'cars-for-sale',
                'description' => ['en' => 'New and used cars for sale.', 'ar' => 'سيارات جديدة ومستعملة للبيع.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $vehicles,
                'name' => ['en' => 'Cars for Rent', 'ar' => 'سيارات للإيجار'],
                'slug' => 'cars-for-rent',
                'description' => ['en' => 'Cars available for rental.', 'ar' => 'سيارات متاحة للإيجار.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $vehicles,
                'name' => ['en' => 'Motorcycles', 'ar' => 'دراجات نارية'],
                'slug' => 'motorcycles',
                'description' => ['en' => 'Motorcycles, scooters, and bikes.', 'ar' => 'دراجات نارية وسكوتر ودراجات هوائية.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $vehicles,
                'name' => ['en' => 'Spare Parts', 'ar' => 'قطع غيار'],
                'slug' => 'spare-parts',
                'description' => ['en' => 'Vehicle spare parts and accessories.', 'ar' => 'قطع غيار وإكسسوارات المركبات.'],
                'sort_order' => 4,
            ],

            // --- Properties Children ---
            [
                'parent_id' => $properties,
                'name' => ['en' => 'Apartments for Sale', 'ar' => 'شقق للبيع'],
                'slug' => 'apartments-for-sale',
                'description' => ['en' => 'Residential apartments available for purchase.', 'ar' => 'شقق سكنية متاحة للشراء.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $properties,
                'name' => ['en' => 'Apartments for Rent', 'ar' => 'شقق للإيجار'],
                'slug' => 'apartments-for-rent',
                'description' => ['en' => 'Residential apartments available for rent.', 'ar' => 'شقق سكنية متاحة للإيجار.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $properties,
                'name' => ['en' => 'Villas', 'ar' => 'فلل ومنازل'],
                'slug' => 'villas',
                'description' => ['en' => 'Villas, houses, and detached homes.', 'ar' => 'فلل، منازل، وبيوت مستقلة.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $properties,
                'name' => ['en' => 'Commercial Properties', 'ar' => 'عقارات تجارية'],
                'slug' => 'commercial-properties',
                'description' => ['en' => 'Offices, shops, and commercial buildings.', 'ar' => 'مكاتب، محلات تجارية، ومباني تجارية.'],
                'sort_order' => 4,
            ],
            [
                'parent_id' => $properties,
                'name' => ['en' => 'Lands', 'ar' => 'أراضي'],
                'slug' => 'lands',
                'description' => ['en' => 'Residential and commercial lands.', 'ar' => 'أراضي سكنية وتجارية.'],
                'sort_order' => 5,
            ],

            // --- Electronics Children ---
            [
                'parent_id' => $electronics,
                'name' => ['en' => 'Mobile Phones', 'ar' => 'هواتف محمولة'],
                'slug' => 'mobile-phones',
                'description' => ['en' => 'Smartphones and mobile devices.', 'ar' => 'هواتف ذكية وأجهزة محمولة.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $electronics,
                'name' => ['en' => 'Tablets', 'ar' => 'أجهزة لوحية'],
                'slug' => 'tablets',
                'description' => ['en' => 'Tablets and e-readers.', 'ar' => 'أجهزة لوحية وقارئات إلكترونية.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $electronics,
                'name' => ['en' => 'Laptops', 'ar' => 'حواسيب محمولة'],
                'slug' => 'laptops',
                'description' => ['en' => 'Notebooks and desktop computers.', 'ar' => 'حواسيب محمولة وأجهزة حاسوب مكتبية.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $electronics,
                'name' => ['en' => 'TVs', 'ar' => 'تلفزيونات'],
                'slug' => 'tvs',
                'description' => ['en' => 'Smart TVs and displays.', 'ar' => 'تلفزيونات ذكية وشاشات عرض.'],
                'sort_order' => 4,
            ],
            [
                'parent_id' => $electronics,
                'name' => ['en' => 'Cameras', 'ar' => 'كاميرات'],
                'slug' => 'cameras',
                'description' => ['en' => 'Digital cameras, lenses, and accessories.', 'ar' => 'كاميرات رقمية، عدسات، وإكسسوارات.'],
                'sort_order' => 5,
            ],
            [
                'parent_id' => $electronics,
                'name' => ['en' => 'Audio', 'ar' => 'صوتيات'],
                'slug' => 'audio',
                'description' => ['en' => 'Headphones, speakers, and audio systems.', 'ar' => 'سماعات رأس، مكبرات صوت وأنظمة صوت.'],
                'sort_order' => 6,
            ],

            // --- Home & Furniture Children ---
            [
                'parent_id' => $homeFurniture,
                'name' => ['en' => 'Indoor Furniture', 'ar' => 'أثاث داخلي'],
                'slug' => 'indoor-furniture',
                'description' => ['en' => 'Sofas, beds, cabinets, tables.', 'ar' => 'كنب، أسرّة، خزائن، طاولات.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $homeFurniture,
                'name' => ['en' => 'Outdoor Furniture', 'ar' => 'أثاث خارجي'],
                'slug' => 'outdoor-furniture',
                'description' => ['en' => 'Patio sets, garden chairs, outdoor tables.', 'ar' => 'مجموعات فناء، كراسي حديقة، طاولات خارجية.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $homeFurniture,
                'name' => ['en' => 'Office Furniture', 'ar' => 'أثاث مكتبي'],
                'slug' => 'office-furniture',
                'description' => ['en' => 'Desks, office chairs, shelves.', 'ar' => 'مكاتب، كراسي مكتب، أرفف.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $homeFurniture,
                'name' => ['en' => 'Home Appliances', 'ar' => 'أجهزة منزلية'],
                'slug' => 'home-appliances',
                'description' => ['en' => 'Refrigerators, washing machines, ovens, and more.', 'ar' => 'ثلاجات، غسالات، أفران، والمزيد من الأجهزة.'],
                'sort_order' => 4,
            ],
            [
                'parent_id' => $homeFurniture,
                'name' => ['en' => 'Decor & Accessories', 'ar' => 'ديكور وإكسسوارات'],
                'slug' => 'decor-accessories',
                'description' => ['en' => 'Lighting, rugs, wall art, decoration pieces.', 'ar' => 'إضاءة، سجاد، لوحات فنية، قطع ديكور.'],
                'sort_order' => 5,
            ],
            [
                'parent_id' => $homeFurniture,
                'name' => ['en' => 'Garden Tools', 'ar' => 'أدوات حدائق'],
                'slug' => 'garden-tools',
                'description' => ['en' => 'Lawn mowers, trimmers, and gardening equipment.', 'ar' => 'جزازات العشب، أدوات التشذيب ومعدات الحدائق.'],
                'sort_order' => 6,
            ],
            
            // --- Fashion & Clothing Children (تم إضافة "Bags" هنا) ---
            [
                'parent_id' => $fashionClothing,
                'name' => ['en' => 'Men\'s Clothing', 'ar' => 'ملابس رجالية'],
                'slug' => 'mens-clothing',
                'description' => ['en' => 'Shirts, pants, suits, and jackets for men.', 'ar' => 'قمصان، بناطيل، بدل، وجاكيتات للرجال.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $fashionClothing,
                'name' => ['en' => 'Women\'s Clothing', 'ar' => 'ملابس نسائية'],
                'slug' => 'womens-clothing',
                'description' => ['en' => 'Dresses, skirts, tops, and outerwear for women.', 'ar' => 'فساتين، تنانير، بلايز، ومعاطف للنساء.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $fashionClothing,
                'name' => ['en' => 'Kids\' Clothing', 'ar' => 'ملابس أطفال'],
                'slug' => 'kids-clothing',
                'description' => ['en' => 'Apparel for infants, toddlers, and children.', 'ar' => 'ملابس للرضع، والأطفال الصغار والكبار.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $fashionClothing,
                'name' => ['en' => 'Shoes', 'ar' => 'أحذية'],
                'slug' => 'shoes',
                'description' => ['en' => 'Sneakers, boots, sandals, and formal shoes.', 'ar' => 'أحذية رياضية، جزم، صنادل، وأحذية رسمية.'],
                'sort_order' => 4,
            ],
            [
                'parent_id' => $fashionClothing,
                'name' => ['en' => 'Bags', 'ar' => 'حقائب'], // <-- الفئة التي كان يبحث عنها $bags
                'slug' => 'bags',
                'description' => ['en' => 'Handbags, backpacks, and wallets.', 'ar' => 'حقائب يد، حقائب ظهر، ومحافظ.'],
                'sort_order' => 5,
            ],
            [
                'parent_id' => $fashionClothing,
                'name' => ['en' => 'Accessories', 'ar' => 'إكسسوارات'], // تم تغيير الترتيب
                'slug' => 'accessories',
                'description' => ['en' => 'Belts, scarves, hats, and sunglasses.', 'ar' => 'أحزمة، أوشحة، قبعات، ونظارات شمسية.'],
                'sort_order' => 6,
            ],
            [
                'parent_id' => $fashionClothing,
                'name' => ['en' => 'Jewelry & Watches', 'ar' => 'مجوهرات وساعات'],
                'slug' => 'jewelry-watches',
                'description' => ['en' => 'Rings, necklaces, earrings, and watches.', 'ar' => 'خواتم، قلادات، أقراط، وساعات.'],
                'sort_order' => 7,
            ],

            // --- Jobs Children ---
            [
                'parent_id' => $jobs,
                'name' => ['en' => 'Full-Time', 'ar' => 'دوام كامل'],
                'slug' => 'full-time-jobs',
                'description' => ['en' => 'Full-time employment opportunities.', 'ar' => 'فرص عمل بدوام كامل.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $jobs,
                'name' => ['en' => 'Part-Time', 'ar' => 'دوام جزئي'],
                'slug' => 'part-time-jobs',
                'description' => ['en' => 'Part-time work and flexible hours.', 'ar' => 'عمل بدوام جزئي وساعات مرنة.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $jobs,
                'name' => ['en' => 'Freelance', 'ar' => 'عمل حر'],
                'slug' => 'freelance-jobs',
                'description' => ['en' => 'Freelancing projects and opportunities.', 'ar' => 'مشاريع وفرص عمل حر.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $jobs,
                'name' => ['en' => 'Internships', 'ar' => 'تدريب'],
                'slug' => 'internships',
                'description' => ['en' => 'Internship and training programs.', 'ar' => 'برامج تدريب وتأهيل.'],
                'sort_order' => 4,
            ],

            // --- Services Children ---
            [
                'parent_id' => $services,
                'name' => ['en' => 'Maintenance & Repairs', 'ar' => 'صيانة وإصلاحات'],
                'slug' => 'maintenance-repairs',
                'description' => ['en' => 'Home, auto, and appliance repair services.', 'ar' => 'خدمات إصلاح المنازل والسيارات والأجهزة.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $services,
                'name' => ['en' => 'Cleaning Services', 'ar' => 'خدمات نظافة'],
                'slug' => 'cleaning-services',
                'description' => ['en' => 'House, office, and commercial cleaning.', 'ar' => 'تنظيف المنازل والمكاتب والأماكن التجارية.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $services,
                'name' => ['en' => 'Education & Training', 'ar' => 'تعليم وتدريب'],
                'slug' => 'education-training',
                'description' => ['en' => 'Tutoring, courses, and educational services.', 'ar' => 'دروس خصوصية، دورات، وخدمات تعليمية.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $services,
                'name' => ['en' => 'Health & Beauty', 'ar' => 'صحة وجمال'],
                'slug' => 'health-beauty',
                'description' => ['en' => 'Salons, spas, and wellness services.', 'ar' => 'صالونات، منتجعات صحية، وخدمات العناية بالصحة والجمال.'],
                'sort_order' => 4,
            ],
            [
                'parent_id' => $services,
                'name' => ['en' => 'Event Services', 'ar' => 'تنظيم فعاليات'],
                'slug' => 'event-services',
                'description' => ['en' => 'Wedding planning, catering, and event equipment rental.', 'ar' => 'تخطيط حفلات الزفاف، خدمات تقديم الطعام، وتأجير معدات الفعاليات.'],
                'sort_order' => 5,
            ],

            // --- Miscellaneous Children ---
            [
                'parent_id' => $miscellaneous,
                'name' => ['en' => 'Books', 'ar' => 'كتب'],
                'slug' => 'books',
                'description' => ['en' => 'Novels, textbooks, and magazines.', 'ar' => 'روايات، كتب مدرسية، ومجلات.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $miscellaneous,
                'name' => ['en' => 'Sports & Fitness', 'ar' => 'رياضة ولياقة'],
                'slug' => 'sports-fitness',
                'description' => ['en' => 'Sports equipment and fitness gear.', 'ar' => 'معدات رياضية وأجهزة لياقة بدنية.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $miscellaneous,
                'name' => ['en' => 'Art & Collectibles', 'ar' => 'فنون ومقتنيات'],
                'slug' => 'art-collectibles',
                'description' => ['en' => 'Paintings, sculptures, and collectible items.', 'ar' => 'لوحات، منحوتات، وقطع قابلة للتحصيل.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $miscellaneous,
                'name' => ['en' => 'Pets', 'ar' => 'حيوانات أليفة'],
                'slug' => 'pets',
                'description' => ['en' => 'Pets, pet supplies, and accessories.', 'ar' => 'حيوانات أليفة، لوازم وإكسسوارات الحيوانات الأليفة.'],
                'sort_order' => 4,
            ],
        ];

        // مصفوفة لحفظ الفئات الفرعية المستوى الثاني التي تم إنشاؤها للربط اللاحق (للمستوى الثالث)
        $childCategoryObjects = [];
        
        // 3. إنشاء/تحديث الفئات الفرعية المستوى الثاني
        foreach ($childCategoriesData as $data) {
            $category = Category::updateOrCreate(
                [
                    'parent_id' => $data['parent_id'],
                    'slug' => $data['slug']
                ],
                $data
            );
            $childCategoryObjects[$data['name']['en']] = $category;
        }

        // 4. تحديد الفئة الأم (Home Appliances) لإنشاء المستوى الثالث (Appliance Fix)
        if (isset($childCategoryObjects['Home Appliances'])) {
            $homeAppliances = $childCategoryObjects['Home Appliances']->id;
        } else {
            // fallback if Home Appliances not found (should not happen if data is correct)
            return; 
        }

        // 5. تعريف الفئات الفرعية المستوى الثالث للأجهزة المنزلية (Level 3 Children)
        $applianceSubCategoriesData = [
            // --- Home Appliances Sub-Categories ---
            [
                'parent_id' => $homeAppliances,
                'name' => ['en' => 'Refrigerators', 'ar' => 'ثلاجات'],
                'slug' => 'refrigerators',
                'description' => ['en' => 'Fridges, freezers, and cooling units.', 'ar' => 'ثلاجات ووحدات تجميد وتبريد.'],
                'sort_order' => 1,
            ],
            [
                'parent_id' => $homeAppliances,
                'name' => ['en' => 'Washing Machines', 'ar' => 'غسالات'],
                'slug' => 'washing-machines',
                'description' => ['en' => 'Automatic and semi-automatic washing machines.', 'ar' => 'غسالات أوتوماتيكية وشبه أوتوماتيكية.'],
                'sort_order' => 2,
            ],
            [
                'parent_id' => $homeAppliances,
                'name' => ['en' => 'Air Conditioners', 'ar' => 'مكيفات'],
                'slug' => 'air-conditioners',
                'description' => ['en' => 'Split units, window ACs, and central cooling.', 'ar' => 'وحدات سبليت ومكيفات شباك وتبريد مركزي.'],
                'sort_order' => 3,
            ],
            [
                'parent_id' => $homeAppliances,
                'name' => ['en' => 'Ovens', 'ar' => 'أفران'],
                'slug' => 'ovens',
                'description' => ['en' => 'Electric, gas, and built-in ovens and stoves.', 'ar' => 'أفران كهربائية، غاز، ومواقد مدمجة.'],
                'sort_order' => 4,
            ],
            [
                'parent_id' => $homeAppliances,
                'name' => ['en' => 'Microwaves', 'ar' => 'ميكروويف'],
                'slug' => 'microwaves',
                'description' => ['en' => 'Microwave ovens and small kitchen appliances.', 'ar' => 'أفران ميكروويف وأجهزة المطبخ الصغيرة.'],
                'sort_order' => 5,
            ],
        ];

        // 6. إنشاء/تحديث الفئات الفرعية المستوى الثالث
        foreach ($applianceSubCategoriesData as $data) {
            Category::updateOrCreate(
                [
                    'parent_id' => $data['parent_id'],
                    'slug' => $data['slug']
                ],
                $data
            );
        }
    }
}