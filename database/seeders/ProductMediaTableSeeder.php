<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images[] = ['file_name' => 'product-01.jpg', 'file_type' => 'image/jpg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0];
        $images[] = ['file_name' => 'product-02.jpg', 'file_type' => 'image/jpg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0];
        $images[] = ['file_name' => 'product-03.jpg', 'file_type' => 'image/jpg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0];
        $images[] = ['file_name' => 'product-04.jpg', 'file_type' => 'image/jpg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0];
        $images[] = ['file_name' => 'product-05.jpg', 'file_type' => 'image/jpg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0];
        $images[] = ['file_name' => 'product-06.jpg', 'file_type' => 'image/jpg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0];
        $images[] = ['file_name' => 'product-07.jpg', 'file_type' => 'image/jpg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0];
        $images[] = ['file_name' => 'product-08.jpg', 'file_type' => 'image/jpg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0];

        Product::all()->each(function ($product) use ($images) {
            $product->media()->createMany(Arr::random($images, rand(2, 3)));
        });
    }
}
