<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds to populate the products table with initial data.
     * This method creates several product records with various attributes,
     * including name, description, price, stock, and active status.
     * It also includes a discontinued product to demonstrate
     * how to handle inactive products.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Smartphone X',
                'description' => 'Latest smartphone with advanced features',
                'price' => 999.99,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Laptop Pro',
                'description' => 'High-performance laptop for professionals',
                'price' => 1499.99,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium noise-cancelling wireless headphones',
                'price' => 249.99,
                'stock' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness and health tracking smartwatch',
                'price' => 199.99,
                'stock' => 75,
                'is_active' => true,
            ],
            [
                'name' => 'Tablet Mini',
                'description' => 'Compact tablet for entertainment and productivity',
                'price' => 349.99,
                'stock' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Discontinued Product',
                'description' => 'This product is no longer available',
                'price' => 99.99,
                'stock' => 0,
                'is_active' => false,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
