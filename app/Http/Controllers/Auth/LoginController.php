<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as protected originalLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username(): string
    {
        return 'username';
    }

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        if (Auth::user()->hasRole('admin')) {
            return $this->redirectTo = '/admin';
        } else {
            return $this->redirectTo = '/';
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function logout(Request $request)
    {
        $cart = collect($request->session()->get('cart'));

        /* Call Original Logout Method */
        $response = $this->originalLogout($request);
        /* Repopulate Session With Cart */

        if (!config('cart.destroy_on_logout')) {
            $cart->each(function ($rows, $identifier) use ($request) {
                $request->session()->put('cart.' . $identifier, $rows);
            });
        }
        /* Repopulate Original Response  */
        return $response;
    }

    /* Actions After Logged Out  */
    protected function loggedOut(Request $request)
    {
        Cache::forget('admin_side_menu');
        Cache::forget('shop_categories_menu');
        Cache::forget('shop_tags_menu');
    }

}
