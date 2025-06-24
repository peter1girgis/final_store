<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $categories = [
            'Smart Home Devices',
            'Drones & Accessories',
            'Wearable Tech',
            'Virtual Reality',
            'Car Electronics',
            'Travel & Luggage',
            'Jewelry & Accessories',
            'Hijabs & Abayas',
            'Perfumes & Fragrances',
            'Makeup & Cosmetics',
            'Hair Care',
            'Skincare',
            'Bath & Body',
            'Mother & Maternity',
            'Diapers & Wipes',
            'School Supplies',
            'Art & Crafts',
            'Outdoor & Camping',
            'Bicycles & Scooters',
            'Safety & Security',
            'Lighting & Lamps',
            'Wall Art & Posters',
            'Bakery & Sweets',
            'Meat & Seafood',
            'Frozen Foods',
            'Organic Products',
            'Seasonal Offers',
            'Daily Deals',
            'Gift Cards',
            'Flash Sale Items',
            'Electronics',
            'Mobiles & Tablets',
            'Laptops & Computers',
            'Cameras & Photography',
            'TVs & Home Theater',
            'Home Appliances',
            'Fashion - Men',
            'Fashion - Women',
            'Fashion - Kids',
            'Shoes & Bags',
            'Beauty & Personal Care',
            'Health & Wellness',
            'Baby & Kids',
            'Toys & Games',
            'Furniture',
            'Kitchen & Dining',
            'Home Decor',
            'Sports & Fitness',
            'Books',
            'Stationery & Office Supplies',
            'Automotive Accessories',
            'Pet Supplies',
            'Groceries & Food',
            'Cleaning & Household',
            'Gardening Tools',
            'Tools & Hardware',
            'Musical Instruments',
            'Watches & Accessories',
            'Gaming & Consoles',
            'Software & Subscriptions',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert([
                'name' => $category
            ], [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}

