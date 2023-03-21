<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductCountry;
use Faker\Factory;
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
        $faker = Factory::create();

        $categories = Category::all()->pluck('id');

        for ($i = 1; $i <= 20; $i++) {
            $product = new Product();
            $product->name = ['en' => $faker->sentence(2, true), 'fr' => $faker->sentence(2, true)];
            $product->details = ['en' => $faker->paragraph, 'fr' => $faker->paragraph];
            $product->description = ['en' => $faker->paragraph, 'fr' => $faker->paragraph];
            $product->features = ['en' => $faker->paragraph, 'fr' => $faker->paragraph];
            $product->usages = ['en' => $faker->paragraph, 'fr' => $faker->paragraph];
            $product->price = $faker->numberBetween(5, 200);
            $product->quantity = $faker->numberBetween(10, 100);
            $product->category_id = $categories->random();
            $product->status = true;
            $product->quantity = $faker->numberBetween(10, 100);
            $product->featured = rand(0, 1);
            $product->save();

            foreach (Country::all() as $country) {
                $productCountry = new ProductCountry();
                $productCountry->product_id = $product->id;
                $productCountry->country_id = $country->id;
                $productCountry->price = $faker->numberBetween(5, 100000);
                $productCountry->save();
            }

            if ($i >= 10) {
                $product->discount()->create([
                    'value' => $faker->randomFloat(1, 0, 0.9)
                ]);
            }
        }
    }
}
