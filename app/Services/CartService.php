<?php
namespace App\Services;

use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\PaymentMethod;
use App\Models\OrderTransaction;
use App\Notifications\Backend\User\OrderCreatedNotification;
use App\Notifications\Frontend\User\OrderThanksNotification;
use Gloudemans\Shoppingcart\Exceptions\CartAlreadyStoredException;

class CartService
{

    public function addToList(object $product, int $quantity = 1, string $instance = 'default'): bool
    {
        $duplicated = Cart::instance($instance)->search(function ($cartItem, $rowId) use ($product, $quantity) {
            if( $cartItem->id === $product->id) {
                $this->updateList($rowId, $quantity);
                return true;
            } else {
                return false;
            }
        });
        if (!$duplicated->isNotEmpty()) {
            Cart::instance($instance)->add(['id' => $product->id, 'name' => $product->name, 'qty' => $quantity, 'price' => $product->price])->associate(Product::class);
        }
        return true;
    }

    /**
     * @param $rowId
     * @param $quantity
     * @param string $instance
     * @return bool
     */
    public function updateList($rowId, $quantity, string $instance = 'default'): bool
    {
        Cart::instance($instance)->update($rowId, $quantity);
        return true;
    }

    /**
     * @param $rowId
     * @param string $instance
     * @return bool
     */
    public function removeFromList($rowId, string $instance = 'default'): bool
    {
        Cart::instance($instance)->remove($rowId);
        return true;
    }

    /**
     * @return mixed
     */
    public function cartContent()
    {
        return Cart::instance('default')->content()->map(function ($cartItem) {
            return formatCartItem($cartItem);
        });
    }

    public function getCartItemTotal($instance = 'default')
    {
        try {
            return Cart::instance($instance)->count();
        } catch (\Exception $exception) {
            $this->clear();
            return 0;
        }
    }

    public function clear($instance = 'default')
    {
        Cart::instance($instance)->destroy();
        return true;
    }

    public function save($username) {
        try {
            Cart::store($username);
        } catch (CartAlreadyStoredException $exception) {
            DB::table('shopping_cart')->where('identifier', $username)->delete();
            Cart::store($username);
        }
        return true;
    }

    public function restore($username) {
        Cart::restore($username);
        return Cart::instance('default')->content()->map(function ($cartItem) {
            return formatCartItem($cartItem);
        });
    }

    public function getItem($rowId, $instance = 'default')
    {
        return Cart::instance($instance)->get($rowId);
    }

    /**
     * @param $detail
     * @param PaymentMethod $paymentMethod
     * @param null $id
     * @param null $json
     * @return Order
     */
    public function saveOrder($detail, PaymentMethod $paymentMethod, $id = null, $json = null): Order
    {
        DB::beginTransaction();
        $shippingInfo = new Shipping($detail);
        $cart = collect($this->cartContent());
        $shippingInfo->saveUserShippingAddress();
        $order = new Order();
        $order->order_status = $paymentMethod->code == 'CASH' ? 0 : 1;
        $order->ref_id = generateRef();
        $order->user()->associate($shippingInfo->user);
        $order->userAddress()->associate($shippingInfo->userAddress);
        $order->paymentMethod()->associate($paymentMethod);
        $order->subtotal = $cart->sum('total_discount_price');
        $order->total = $cart->sum('total_discount_price');
        $order->save();

        foreach ($cart as $cartItem) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->price = $cartItem['price'];
            $orderProduct->product_id = $cartItem['id'];
            $orderProduct->discount = $cartItem['discount'] ?: 0;
            $orderProduct->quantity = $cartItem['quantity'];
            $orderProduct->save();
        }

        $transaction = new OrderTransaction();
        $transaction->order()->associate($order);
        $transaction->transaction_status = $paymentMethod->code == 'CASH' ? 0 : 1;
        $transaction->transaction_number = generateTransactionId();
        $transaction->external_number = $id ?: generateTransactionId();
        $transaction->payment_result = $json;
        $transaction->save();
        $data = formatOrder($order);
        $data['company'] = [
            'logo' => base_path('public/img/logo.png'),
            'name' => getSettingsOf('site_title'),
            'address' => getSettingsOf('address'),
            'phone_number' => getSettingsOf('phone_number'),
            'slogan' => getSettingsOf('site_slogan')
        ];
        DB::commit();
        Session::forget('save_shipping_information');
        $this->clear();
        $path = storage_path('app/pdf/files');
        File::isDirectory($path) or
        File::makeDirectory($path, 0777, true, true);
        $pdf = PDF::loadView('layouts.invoice', $data);
        $saved_file = $path.'/'. $data['ref_id'] . '.pdf';
        $pdf->save($saved_file);
        try {
//            $order->user->notify(new OrderThanksNotification($order, $saved_file));
            User::whereRoleIs('admin')->first()->notify(new OrderCreatedNotification($order));
        } catch (\Exception $exception) {}
        return $order;
    }

    public function savePaidOrder($id, $username, PaymentMethod $paymentMethod, $json) {
        $cart = collect($this->restore($username));
        $user = User::whereUsername($username)->first();
        $address = $user->addresses()->first();
        DB::beginTransaction();
        $order = new Order();
        $order->order_status =  1;
        $order->ref_id = generateRef();
        $order->user()->associate($user);
        $order->userAddress()->associate($address);
        $order->paymentMethod()->associate($paymentMethod);
        $order->subtotal = $cart->sum('total_discount_price');
        $order->total = $cart->sum('total_discount_price');
        $order->save();

        foreach ($cart as $cartItem) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $cartItem['id'];
            $orderProduct->discount = $cartItem['discount'] ?: 0;
            $orderProduct->quantity = $cartItem['quantity'];
            $orderProduct->save();
        }
        $transaction = new OrderTransaction();
        $transaction->order()->associate($order);
        $transaction->transaction_status =  1;
        $transaction->transaction_number = generateTransactionId();
        $transaction->external_number = $id ;
        $transaction->save();
        $data = formatOrder($order);
        $data['company'] = [
            'logo' => base_path('public/img/logo.png'),
            'name' => getSettingsOf('site_title'),
            'address' => getSettingsOf('address'),
            'phone_number' => getSettingsOf('phone_number'),
            'slogan' => getSettingsOf('site_slogan')
        ];
        DB::commit();
        Session::forget('save_shipping_information');
        $this->clear();
        $path = storage_path('app/pdf/files');
        File::isDirectory($path) or
        File::makeDirectory($path, 0777, true, true);
        $pdf = PDF::loadView('layouts.invoice', $data);
        $saved_file = $path.'/'. $data['ref_id'] . '.pdf';
        $pdf->save($saved_file);
        try {
            $order->user->notify(new OrderThanksNotification($order, $saved_file));
        } catch (\Exception $exception) {}
        return $order;
    }
}
