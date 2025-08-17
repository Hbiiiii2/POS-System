<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Makanan
            ['product_code' => 'M001', 'name' => 'Nasi Goreng', 'category_name' => 'Makanan', 'stock' => 50, 'price' => 15000, 'unit' => 'porsi'],
            ['product_code' => 'M002', 'name' => 'Mie Goreng', 'category_name' => 'Makanan', 'stock' => 30, 'price' => 12000, 'unit' => 'porsi'],
            ['product_code' => 'M003', 'name' => 'Ayam Goreng', 'category_name' => 'Makanan', 'stock' => 25, 'price' => 18000, 'unit' => 'porsi'],
            
            // Minuman
            ['product_code' => 'MN001', 'name' => 'Es Teh Manis', 'category_name' => 'Minuman', 'stock' => 100, 'price' => 3000, 'unit' => 'gelas'],
            ['product_code' => 'MN002', 'name' => 'Es Jeruk', 'category_name' => 'Minuman', 'stock' => 80, 'price' => 5000, 'unit' => 'gelas'],
            ['product_code' => 'MN003', 'name' => 'Kopi Hitam', 'category_name' => 'Minuman', 'stock' => 60, 'price' => 8000, 'unit' => 'gelas'],
            
            // Snack
            ['product_code' => 'S001', 'name' => 'Keripik Kentang', 'category_name' => 'Snack', 'stock' => 200, 'price' => 5000, 'unit' => 'pack'],
            ['product_code' => 'S002', 'name' => 'Biskuit', 'category_name' => 'Snack', 'stock' => 150, 'price' => 3000, 'unit' => 'pack'],
            ['product_code' => 'S003', 'name' => 'Permen', 'category_name' => 'Snack', 'stock' => 300, 'price' => 1000, 'unit' => 'buah'],
            
            // Rokok
            ['product_code' => 'R001', 'name' => 'Marlboro Red', 'category_name' => 'Rokok', 'stock' => 50, 'price' => 25000, 'unit' => 'pack'],
            ['product_code' => 'R002', 'name' => 'Sampoerna Mild', 'category_name' => 'Rokok', 'stock' => 45, 'price' => 22000, 'unit' => 'pack'],
            
            // Pulsa
            ['product_code' => 'P001', 'name' => 'Pulsa 10K', 'category_name' => 'Pulsa', 'stock' => 999, 'price' => 10000, 'unit' => 'kartu'],
            ['product_code' => 'P002', 'name' => 'Pulsa 25K', 'category_name' => 'Pulsa', 'stock' => 999, 'price' => 25000, 'unit' => 'kartu'],
            ['product_code' => 'P003', 'name' => 'Pulsa 50K', 'category_name' => 'Pulsa', 'stock' => 999, 'price' => 50000, 'unit' => 'kartu'],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category_name'])->first();
            if ($category) {
                Product::create([
                    'product_code' => $product['product_code'],
                    'name' => $product['name'],
                    'category_id' => $category->id,
                    'stock' => $product['stock'],
                    'price' => $product['price'],
                    'unit' => $product['unit'],
                ]);
            }
        }
    }
}
