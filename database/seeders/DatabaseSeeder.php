<?php

namespace Database\Seeders;

use App\Models\OrderProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PagesSeeder::class);
        $this->call(LinkSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ShippingAgencySeeder::class);
        $this->call(AdminSeeder::class);
        if (app()->environment('local')) {
            $this->call(EventTableSeeder::class);
            $this->call(ProductsTableSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(ReviewSeeder::class);
            $this->call(ProductMediaTableSeeder::class);
            $this->call(EventMediaTableSeeder::class);
        }
//        $this->call(OrderSeeder::class);
//        $this->call(ProductMediaTableSeeder::class);
    }
}
