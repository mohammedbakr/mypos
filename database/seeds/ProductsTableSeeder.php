<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['pro one', 'pro two'];

        foreach ($products as $product) {
            
            Product::create([
                
                'category_id' => 1,
                'ar' => ['name' => $product, 'description' => $product . ' وصف'],
                'en' => ['name' => $product, 'description' => $product . ' desc'],
                'purchase_price' => 120,
                'sale_price' => 150,
                'stock' => 100

            ]);

        }// end of foreach

    }// end of run

}// end of seeder
