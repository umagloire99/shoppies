<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request)
    {
        $cart = new CartService();
        return array_merge(parent::share($request), [
            'csrf_token' => csrf_token(),
            'contact' => [
                'site_facebook' => getSettingsOf('site_facebook'),
                'site_twitter' => getSettingsOf('site_twitter'),
                'site_instagram' => getSettingsOf('site_instagram'),
                'site_youtube' => getSettingsOf('site_youtube'),
                'site_email' => getSettingsOf('site_email'),
                'phone_number' => getSettingsOf('phone_number')
            ],
            'cart' => [
                'shipping' => Session::get('save_shipping_information'),
                'count' => $cart->getCartItemTotal(),
                'content' => $cart->cartContent(),
                'total_price' => collect($cart->cartContent())->sum('total_discount_price')
            ],
            'payment_initialize_result' => $request->session()->get('payment_initialize_result'),
            'flash' => function () use ($request) {
                return [
                    'error' => $request->session()->get('error'),
                    'success' => $request->session()->get('success'),
                    'info' => $request->session()->get('info'),
                    'warning' => $request->session()->get('warning')
                ];
            },
            'categories' => Category::active()
                ->whereParentId(null)
                ->limit(10)
                ->get()->transform(function ($category) {
                    return formatCategory($category, 3);
                }),
            'auth.user' => function () use ($request) {
                return $request->user() ? $request->user()->only('id', 'name', 'email') : null;
            }
        ]);
    }
}
