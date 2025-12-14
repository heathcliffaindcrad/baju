<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::create([
            'username' => 'admin',
            'email' => 'admin@tokopakaian.com',
            'password' => Hash::make('password'),
            'full_name' => 'Administrator',
            'role' => 'admin'
        ]);

        // Regular User
        User::create([
            'username' => 'bambang',
            'email' => 'bambang@gmail.com',
            'password' => Hash::make('password'),
            'full_name' => 'Bambang Surya Prana',
            'phone' => '0895123456789',
            'address' => 'Perum PDL',
            'role' => 'user'
        ]);

        // Categories
        $categories = [
            ['name' => 'Pria', 'description' => 'Pakaian untuk pria'],
            ['name' => 'Wanita', 'description' => 'Pakaian untuk wanita'],
            ['name' => 'Anak - Anak', 'description' => 'Pakaian untuk anak - anak'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Products
        $products = [
            [
                'name' => 'Hoodie',
                'description' => 'Hoodie Jumper Dewasa Hitam POLOS Premium',
                'category_id' => 1,
                'size' => 'L',
                'color' => 'Hitam',
                'price' => 150000,
                'stock' => 10,
                'image' => 'hoodie.jpg',
                'is_active' => true
            ],
            [
                'name' => 'Kemeja Wispie',
                'description' => 'Kemeja kerja wanita fit garis stripe karet Lembut',
                'category_id' => 2,
                'size' => 'M',
                'color' => 'Merah Maaron',
                'price' => 120000,
                'stock' => 5,
                'image' => 'kemeja.jpg',
                'is_active' => true
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Settings
        Setting::create([
            'store_name' => 'Toko Pakaian Kita',
            'store_address' => 'Jl. Contoh No. 123, Jakarta',
            'store_phone' => '021-1234567',
            'store_email' => 'info@tokopakaian.com',
            'promo_text' => 'Diskon spesial untuk pembelian pertama!',
            'low_stock_threshold' => 10
        ]);
    }
}