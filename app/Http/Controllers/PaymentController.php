<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\PaymentMethod;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class PaymentController extends Controller
{
    private PaymentMethod $paymentMethod;

    public function makePayment(Request $request, $code)
    {
        $request->validate([
            'address' => 'required|min:3',
            'name' => 'required|max:50',
            'phone_one' => 'required|phone:CM',
            'phone_two' => 'nullable|phone:CM',
            'city' => 'required',
        ]);
        Session::forget('save_shipping_information');
        Session::put('save_shipping_information', $request->all());
        $this->paymentMethod = PaymentMethod::where('code', $code)->first();
        if ($this->paymentMethod) {
            $cartItems = (new CartService())->cartContent();
            $shipping = Session::get('save_shipping_information');
            if (!$shipping) {
                return back()->with(['error' => 'Please add your shipping information']);
            }
            foreach ($cartItems as $cartItem) {
                $cartItem = (object)$cartItem;
                if ($cartItem->is_out_stock) {
                    return back()->with(['error' => $cartItem->name . ' is out of stock please remove from your before place your order']);
                } else {
                    if ($this->paymentMethod->code == 'CASH') {
                        return $this->onDelivery($shipping);
                    } else {
                        $request->validate([
                            'mtn_phone_number' => 'required|phone:CM',
                        ]);
                        if ($this->paymentMethod->code == 'MOMO') {
                            $result = initializeMoMoPayment($shipping, $request->get('mtn_phone_number'));
                            return back()->with(['payment_initialize_result' => $result]);
                        } elseif ($this->paymentMethod->code == 'MONETBIL') {
                            $result = monetbil($shipping, $request->get('mtn_phone_number'));
                            return back()->with(['payment_initialize_result' => $result]);
                        }
                        return back()->with(['error' => 'Payment method not available']);
                    }
                }
            }
            return back()->with(['error' => 'Please add your shipping information']);
        } else {
            return back()->with(['error' => 'Payment method not available']);
        }
    }

    public function checkPaymentStatus($method, $paymentId) {
        if ($method == 'MONETBIL') {
            $result = monetbilHook($paymentId);
            return response($result);
        } elseif ($method == 'MOMO') {
            $result = momoTransactionStatus($paymentId);
            return response($result);
        }
        return abort(404);
    }


    private function onDelivery($detail)
    {
        $order = (new CartService())->saveOrder($detail, $this->paymentMethod);
        return Inertia::location(route('payment.success', $order->ref_id));
    }

    public function receipt($refId) {
        if ($order = Order::whereRefId($refId)->first()) {
            $data = formatOrder($order);
            $data['company'] = [
                'logo' => asset('img/logo.png'),
                'name' => getSettingsOf('site_title'),
                'address' => getSettingsOf('address'),
                'phone_number' => getSettingsOf('phone_number'),
                'slogan' => getSettingsOf('site_slogan')
            ];
            return view('layouts.invoice', $data);
        } else {
            return back()->with(['error' => 'Order not found']);
        }
    }


    /**
     * @param $refId
     * @return RedirectResponse|\Inertia\Response
     */
    public function successPayment($refId)
    {
        $order = Order::whereRefId($refId)->first();
        if (!$order) {
            return back()->with(['error' => 'No such order']);
        }
        return Inertia::render('Cart/successCheckout', [
            'order' =>$order
        ]);
    }
}
