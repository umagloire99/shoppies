<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class EventMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::all()->each(function ($event) {
            $event->media()->create(['file_name' => 'happycute'.$event->id.'.jpeg', 'file_type' => 'image/jpeg', 'file_size' => rand(100, 900), 'file_status' => true, 'file_sort' => 0]);
        });
    }
}
