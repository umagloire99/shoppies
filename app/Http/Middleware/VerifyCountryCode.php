<?php

namespace App\Http\Middleware;

use App\Models\Country;
use Closure;
use Illuminate\Http\Request;

class VerifyCountryCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $countryCode = $request->route()->parameter('country_code');

        if (!Country::whereShortName(strtolower($countryCode))->exists()) {
            if ($countryCode) {
                return redirect(route('home'));
            }

            $countryCode = 'cm';
        }

        $request->session()->put('country_code', $countryCode);
        $request->session()->save();

        $request->route()->forgetParameter('country_code');
        return $next($request);
    }
}
