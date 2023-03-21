<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => ['fr' => 'defaut', 'en' => 'default'], 'status' => true]);
        Category::all()->each(function (Category $category) {
            $category->media()->create(['file_name' => $category->slug.'.jpeg', 'file_type' => 'image/jpeg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0]);
        });
    }
}
