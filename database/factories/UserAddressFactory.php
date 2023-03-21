<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'user_id' => User::factory(),
            'address_title' => $this->faker->streetAddress,
            'default_address' => rand(0, 1),
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'phone_one' => $this->faker->phoneNumber,
            'phone_two' => $this->faker->phoneNumber,
            'city_id' => 1,
        ];
    }
}
