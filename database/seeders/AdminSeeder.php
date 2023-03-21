<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        Role::create(['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Administrator of the system']);

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '0505050505',
            'address' =>'Lasvegas',
            'password' => bcrypt('admin'),
            'email_verified_at' => Carbon::now(),
        ]);

        $admin->attachRole('admin');
    }
}
