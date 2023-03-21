<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name'                    => 'AkivasPay',
            'code'                    => 'APAY',
        ]);
        PaymentMethod::create([
            'name'                    => 'MTN Mobile Money',
            'code'                    => 'MOMO',
            'status'                  => true,
        ]);
        PaymentMethod::create([
            'name'                    => 'Payment on delivery',
            'code'                    => 'CASH',
            'status'                  => true,
        ]);
        PaymentMethod::create([
            'name'                    => 'Orange Money',
            'code'                    => 'MONETBIL',
            'status'                  => true,
        ]);
    }
}
