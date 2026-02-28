<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Dairy & Cheese
            [
                'name_ar' => 'حليب جهينة كامل الدسم 1 لتر',
                'name_en' => 'Juhayna Full Cream Milk 1L',
                'category' => 'Dairy & Cheese',
                'brand' => 'Juhayna',
                'unit' => 'Liter',
                'price' => 45.00,
                'stock' => 100,
                'description_ar' => 'حليب طبيعي 100% غني بالكالسيوم والبروتين.',
                'description_en' => '100% natural milk rich in calcium and protein.',
            ],
            [
                'name_ar' => 'زبادي المراعي طبيعي 105 جرام',
                'name_en' => 'Almarai Plain Yogurt 105g',
                'category' => 'Dairy & Cheese',
                'brand' => 'Almarai',
                'unit' => 'Gram',
                'price' => 7.50,
                'stock' => 200,
                'description_ar' => 'زبادي طازج ولذيذ من مزارع المراعي.',
                'description_en' => 'Fresh and delicious yogurt from Almarai farms.',
            ],
            // Beverages
            [
                'name_ar' => 'بيبسي 1.5 لتر',
                'name_en' => 'Pepsi 1.5L',
                'category' => 'Beverages',
                'brand' => 'Pepsi',
                'unit' => 'Liter',
                'price' => 20.00,
                'stock' => 150,
                'description_ar' => 'مشروب غازي منعش.',
                'description_en' => 'Refreshing carbonated soft drink.',
            ],
            [
                'name_ar' => 'كوكا كولا 330 مل',
                'name_en' => 'Coca-Cola 330ml Canary',
                'category' => 'Beverages',
                'brand' => 'Coca-Cola',
                'unit' => 'ML',
                'price' => 10.00,
                'stock' => 300,
                'description_ar' => 'المذاق الأصلي المنعش.',
                'description_en' => 'Original refreshing taste.',
            ],
            // Cleaning Supplies
            [
                'name_ar' => 'برسيل جيل لافندر 3 لتر',
                'name_en' => 'Persil Gel Lavender 3L',
                'category' => 'Cleaning Supplies',
                'brand' => 'Persil',
                'unit' => 'Liter',
                'price' => 180.00,
                'stock' => 50,
                'description_ar' => 'منظف غسيل عالي الجودة برائحة اللافندر.',
                'description_en' => 'High quality laundry detergent with lavender scent.',
            ],
            // Canned Food / Grains
            [
                'name_ar' => 'أرز الضحى 1 كيلو',
                'name_en' => 'El Doha Rice 1KG',
                'category' => 'Canned Food',
                'brand' => 'El Doha',
                'unit' => 'KG',
                'price' => 35.00,
                'stock' => 500,
                'description_ar' => 'أرز مصري نقي عالي الجودة.',
                'description_en' => 'Pure high quality Egyptian rice.',
            ],
            // Fruits & Vegetables
            [
                'name_ar' => 'طماطم بلدي',
                'name_en' => 'Local Tomatoes',
                'category' => 'Fruits & Vegetables',
                'brand' => 'Halwani Bros', // Placeholder or No Brand
                'unit' => 'KG',
                'price' => 15.00,
                'stock' => 50,
                'description_ar' => 'طماطم طازجة من المزرعة.',
                'description_en' => 'Fresh farm tomatoes.',
            ],
            [
                'name_ar' => 'موز بلدي',
                'name_en' => 'Local Banana',
                'category' => 'Fruits & Vegetables',
                'brand' => 'Halwani Bros',
                'unit' => 'KG',
                'price' => 20.00,
                'stock' => 40,
                'description_ar' => 'موز بلدي طازج وغني بالألياف.',
                'description_en' => 'Fresh and fiber-rich local banana.',
            ],
            // Snacks & Sweets
            [
                'name_ar' => 'شيبسي عائلي ملح خل',
                'name_en' => 'Chipsy Family Pack Salt & Vinegar',
                'category' => 'Snacks & Sweets',
                'brand' => 'Chipsy',
                'unit' => 'Piece',
                'price' => 10.00,
                'stock' => 100,
                'description_ar' => 'رقائق بطاطس مقرمشة.',
                'description_en' => 'Crispy potato chips.',
            ],
            [
                'name_ar' => 'شوكولاتة جالاكسي بالبندق',
                'name_en' => 'Galaxy Chocolate with Hazelnuts',
                'category' => 'Snacks & Sweets',
                'brand' => 'Galaxy',
                'unit' => 'Piece',
                'price' => 25.00,
                'stock' => 80,
                'description_ar' => 'سيمفونية من الشوكولاتة الناعمة والبندق.',
                'description_en' => 'A symphony of smooth chocolate and hazelnuts.',
            ],
        ];

        foreach ($products as $pData) {
            $category = Category::where('name_en', $pData['category'])->first();
            $brand = Brand::where('name_en', $pData['brand'])->first();
            $unit = Unit::where('name_en', $pData['unit'])->first();

            if ($category && $brand && $unit) {
                $product = Product::updateOrCreate(
                    ['name_en' => $pData['name_en']],
                    [
                        'name_ar' => $pData['name_ar'],
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'unit_id' => $unit->id,
                        'price' => $pData['price'],
                        'discount_price' => null, // No default discount, will be calculated from offers
                        'stock' => $pData['stock'],
                        'description_ar' => $pData['description_ar'],
                        'description_en' => $pData['description_en'],
                        'is_featured' => rand(0, 1),
                    ]
                );

                // Add images using the unified image
                ProductImage::updateOrCreate(
                    ['product_id' => $product->id],
                    ['image' => 'super-market.jpg']
                );
            }
        }
    }
}
