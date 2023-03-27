<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Link::whereStatus(true)->create([
            'title' => 'Orders',
            'as' => 'Order',
            'to' => 'admin.orders.index',
            'icon' => 'fas fa-shopping-basket',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Users',
            'as' => 'User',
            'to' => 'admin.users.index',
            'icon' => 'fas fa-users',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Categories',
            'as' => 'Category',
            'to' => 'admin.categories.index',
            'icon' => 'fas fa-bars',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Products',
            'as' => 'Product',
            'to' => 'admin.products.index',
            'icon' => 'fas fa-tshirt',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Product Reviews',
            'as' => 'Review',
            'to' => 'admin.reviews.index',
            'icon' => 'fas fa-comment',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Countries',
            'as' => 'Country',
            'to' => 'admin.countries.index',
            'icon' => 'far fa-flag',
            'status' => 1,
        ]);

        Link::whereStatus(true)->create([
            'title' => 'Cities',
            'as' => 'City',
            'to' => 'admin.cities.index',
            'icon' => 'fas fa-city',
            'status' => 1,
        ]);


        Link::whereStatus(true)->create([
            'title' => 'User Addresses',
            'as' => 'Address',
            'to' => 'admin.user_addresses.index',
            'icon' => 'fas fa-address-book',
            'status' => 1,
        ]);


        Link::whereStatus(true)->create([
            'title' => 'Pages',
            'as' => 'Page',
            'to' => 'admin.pages.index',
            'icon' => 'far fa-file',
            'status' => 1,
        ]);

    }
}
