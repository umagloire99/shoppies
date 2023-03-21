<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\ShippingAgency;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShippingAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // truncate all shipping agencies
        Schema::disableForeignKeyConstraints();
        DB::table('shipping_agencies')->truncate();
        Schema::enableForeignKeyConstraints();

        // save countries, cities and shipping agency
        $json = file_get_contents('resources/json/countries.json');
        $obj = json_decode($json, true);
        foreach($obj['countries'] as $country) {
            Country::create([
                'id' => $country['id'],
               'short_name' => $country['short_name'],
               'name' => $country['name'],
               'phone_code' => $country['phone_code']
            ]);
        }

        $json = file_get_contents('resources/json/cities.json');
        $obj = json_decode($json, true);
        foreach($obj['cities'] as $city) {
            $c = City::create([
                'name' => $city['name'],
                'country_id' => $city['country_id']
            ]);
            ShippingAgency::create([
                'cost' => 0,
                'city_id' => $c->id,
                'name' => $city['name'].' Agence'
            ]);
        }

    }
}
