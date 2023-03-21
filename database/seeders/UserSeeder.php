<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'user', 'display_name' => 'User', 'description' => 'Regular/Default User of the system']);
        $user = User::create([
            'name' => 'Ulrich Magloire',
            'username' => 'umagloire99',
            'email' => 'umagloire99@gmail.com',
            'phone' => '+237682322978',
            'address' => 'Simbock',
            'password' => bcrypt('ulrich'),
            'email_verified_at' => Carbon::now(),
        ]);
        $user->attachRole('user');
//        $userPermissions = [
//            'create_review',
//            'edit_review',
//            'show_review',
//            'delete_review',
//        ];
//        foreach ($userPermissions as $permission) {
//            $userRole->givePermissionTo($permission);
//        }

        /*
         * Create 1000 fake users with their addresses (each user has one address).
         */
        User::factory()->count(100)->hasAddresses(1)->create();
    }
}
