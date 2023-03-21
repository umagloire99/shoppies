<?php


namespace App\Services;


use App\Models\ShippingAgency;
use App\Models\User;
use App\Models\UserAddress;
use Exception;

class Shipping
{
    /**
     * @var mixed
     */
    public  $name;

    public $city_id;

    public $phone_one;

    public $phone_two;

    public $address;

    public  $user;

    public  $userAddress;

    public $email;

    public $shippingAgency;

    public $username;

    public function __construct($shippingDetail)
    {

        try {
            if (!$shippingDetail['email']) {
                $email = generateFakeEmail();
            } else {
                $email = $shippingDetail['email'];
            }
        }catch (Exception $exception) {
            $email = generateFakeEmail();
        }

        $this->name = $shippingDetail['name'];
        $this->city_id = $shippingDetail['city']['city_id'];
        $this->phone_one = $shippingDetail['phone_one'];
        $this->phone_two = $shippingDetail['phone_two']?: $shippingDetail['phone_one'];
        $this->address = $shippingDetail['address'];
        $this->email = $email;
        $this->shippingAgency = ShippingAgency::whereId($shippingDetail['city']['id'])->first();
    }

    public function saveUserShippingAddress() {
        $user = User::whereEmail($this->email)->first();

        if (!$user) {
            $user = new User();
            $user->email = $this->email;
            $this->username = generateUsername($this->email);
            $user->username = $this->username;
        }
        $this->username = $user->username;
        $user->name = $this->name;
        $user->phone = $this->phone_one;
        $user->address = $this->address;
        $user->save();

        $address = new UserAddress();
        $address->user()->associate($user);
        $address->name = $this->name;
        $address->email = $this->email;
        $address->phone_one = $this->phone_one;
        $address->phone_two = $this->phone_two;
        $address->address_title = $this->address;
        $address->city_id = $this->city_id;
        $address->save();
        $this->userAddress = $address;
        $this->user = $user;
    }

}
