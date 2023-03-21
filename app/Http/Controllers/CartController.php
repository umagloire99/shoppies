<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingAgency;
use App\Models\State;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    private $cart;

    public function __construct()
    {
        $this->cart = new CartService();
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Cart/Shopping-cart');
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function addToCart(Request $request, $id): RedirectResponse
    {
        $quantity = $request->get('quantity', 1);
        if ($product = Product::whereId($id)->first()) {
            $validator = Validator::make($request->all(), [
                'quantity' => "required|max:" . $product->quantity
            ]);
            if ($validator->fails()) {
                return back()->with(['error' => $validator->errors()->first()]);
            }
            $status = $this->cart->addToList($product, $quantity);

            if ($status) {
                return back()->with(['success' => __('general.product-add-to-cart')]);
            } else {
                return back()->with(['success' => __('general.product-exist')]);
            }
        } else {
            return back()->with('warning', __('general.resource-not-found'));
        }
    }

    /**
     * @param Request $request
     * @param $rowId
     * @return RedirectResponse
     */
    public function updateCart(Request $request, $rowId): RedirectResponse
    {
        $cartItem = $this->cart->getItem($rowId);
        if (!$cartItem) {
            return back()->with('warning', __('general.resource-not-found'));
        }
        $validator = Validator::make($request->all(), [
            'quantity' => "required|max:" . $cartItem->model->quantity
        ]);
        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()->first()]);
        }
        $this->cart->updateList($rowId, $request->get('quantity'));
        return back()->with(['success' => __('general.cart-item-update')]);
    }

    /**
     * @return RedirectResponse
     */
    public function clearCart(): RedirectResponse
    {
        $this->cart->clear();
        return back()->with(['success' => __('general.cart-clear')]);
    }

    /**
     * @param $rowId
     * @return RedirectResponse
     */
    public function removeFromCart($rowId): RedirectResponse
    {
        $this->cart->removeFromList($rowId);
        return back()->with('success', __('general.product-remove'));
    }

    /**
     * @return Response
     */
    public function checkout(): Response
    {
        $states = State::all()->transform(function (State $state) {
            return [
                'id' => $state->id,
                'name' => $state,
            ];
        });
        $agencies = ShippingAgency::whereStatus(true)->get()
            ->transform(function (ShippingAgency $shippingAgency) {
                return [
                    'id' => $shippingAgency->id,
                    'name' => $shippingAgency->name,
                    'city_id' => $shippingAgency->city->id,
                    'city_name' => $shippingAgency->city->name,
                    'cost' => (int)$shippingAgency->cost,
                    'can_pay_on_delivery' => $shippingAgency->can_pay_on_delivery,
                    'mode' => !$shippingAgency->out_of_town ? __('general.shipping') : __('general.expedition')
                ];
            });
        $paymentMethods = PaymentMethod::whereStatus(true)->get()->transform(function (PaymentMethod $paymentMethod) {
            return [
                'id' => $paymentMethod->id,
                'code' => $paymentMethod->code,
                'name' => $paymentMethod->name
            ];
        });
        return Inertia::render('Cart/checkout', [
            'agencies' => $agencies,
            'states' => $states,
            'paymentMethods' => $paymentMethods
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addShipping(Request $request): RedirectResponse
    {
        $request->validate([
            'address' => 'required|min:3',
            'name' => 'required|max:50',
            'phone_one' => 'required|phone:CM',
            'phone_two' => 'required|phone:CM',
            'city' => 'required',
            'email' => 'required|email|max:60',
        ]);
        Session::forget('save_shipping_information');
        Session::put('save_shipping_information' , $request->all());
        return back()->with(['success' => 'Shipping address successfully added']);
    }

}
