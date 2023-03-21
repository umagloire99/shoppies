<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Event::create([
            'category_id' => 1,
            'title' => [
                'en' => 'Rejuvenates and brightens all skin types',
                'fr' => 'Rajeunis et Eclaircis tous types de peau'
            ],
            'description' => [
                'en' => 'Rejuvenates and brightens all skin types',
                'fr' => 'Rajeunis et Eclaircis tous types de peau'
            ]
        ]);
        Event::create([
            'category_id' => 1,
            'title' => [
                'en' => 'Ideal for all skin types',
                'fr' => 'Ideale pour tout type de peau'
            ],
            'description' => [
                'en' => 'Ideal for all skin types',
                'fr' => 'Ideale pour tout type de peau'
            ]
        ]);
        Event::create([
            'category_id' => 1,
            'title' => [
                'en' => 'Soft and fortified beard',
                'fr' => 'Barbe douce et fortifiée'
            ],
            'description' => [
                'en' => 'Soft and fortified beard',
                'fr' => 'Barbe douce et fortifiée'
            ]
        ]);
        Event::create([
            'category_id' => 1,
            'title' => [
                'en' => 'Nourishes the skin and makes it more radiant',
                'fr' => 'Nourrit la peau et la rend plus éclatante'
            ],
            'description' => [
                'en' => 'Nourishes the skin and makes it more radiant',
                'fr' => 'Nourrit la peau et la rend plus éclatante'
            ]
        ]);
        Event::create([
            'category_id' => 1,
            'title' => [
                'en' => 'Start an effortless healthy diet',
                'fr' => 'Commencez une cure saine sans efforts'
            ],
            'description' => [
                'en' => 'Start an effortless healthy diet',
                'fr' => 'Commencez une cure saine sans efforts'
            ]
        ]);
    }
}
