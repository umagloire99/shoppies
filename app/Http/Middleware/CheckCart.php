<?php

namespace App\Http\Middleware;

use App\Services\CartService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class CheckCart
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ((new CartService())->getCartItemTotal() > 0) {
            return $next($request);
        } else {
            return Redirect::route('home');
        }
    }
}
