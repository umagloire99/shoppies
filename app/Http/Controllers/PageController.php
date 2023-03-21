<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Inertia\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PageController extends Controller
{
    /**
     * @return Response
     */
    public function privacyPolicy(): Response
    {
       $page = Page::whereSlug('privacy-policy')->first();
       return Inertia::render('Page', [
           'content' => $page ? $page->content : null,
           'name' => 'Privacy Policy'
       ]);
    }

    /**
     * @return Response
     */
    public function termsConditions(): Response
    {
        $page = Page::whereSlug('terms-and-conditions')->first();
        return Inertia::render('Page', [
            'content' => $page ? $page->content : null,
            'name' => 'Terms & Conditions'
        ]);
    }

    public function shippingFaqs(): Response
    {
        $page = Page::whereSlug('shipping-policy')->first();
        return Inertia::render('Page', [
            'content' => $page ? $page->content : null,
            'name' => 'Shipping & Expedition Policy'
        ]);
    }

    /**
     * @return Response
     */
    public function faqs(): Response
    {
        $page = Page::whereSlug('faqs')->first();
        return Inertia::render('Page', [
            'content' => $page ? $page->content : null,
            'name' => 'Customer Support & Faqs'
        ]);
    }

    /**
     * @return Response
     */
    public function shippingFee(): Response
    {
        $page = Page::whereSlug('shipping-expedition-fee')->first();
        return Inertia::render('Page', [
            'content' => $page ? $page->content : null,
            'name' => 'Shipping and Expedition Fee'
        ]);
    }

    /**
     * @return Response
     */
    public function ourStory(): Response
    {
        return Inertia::render('OurStory');
    }

    /**
     * @param Request $request
     * @param $locale
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setLocale(Request $request, $locale): RedirectResponse
    {
        if ((isset($locale) && $locale != null)) {
            // if it's a valid language, set as locale.
            if (in_array(strtolower($locale), config()->get('app.supported_locales'))) {
                App::setlocale($locale);
                session()->put('locale', strtolower($locale));
            }
        }
        return redirect()->back();
    }
}
