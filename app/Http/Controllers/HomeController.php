<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Category;
use App\Models\Event;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public $paginationLimit = 12;
    public $slug;
    public $sortingBy = 'default';
    /**
     * @return Response
     */
    public function index(): Response
    {
        setMetaInfo();
        $events = Event::limit(5)->get()->transform(function (Event $event) {
            return (new EventResource($event));
        });
        $categories = Category::active()
            ->whereParentId(null)
            ->limit(10)
            ->get()->transform(function ($category) {
                return formatCategory($category, 2);
            });

        $products = getCurrentCountry()->products()
            ->inRandomOrder()
            ->active()
            ->activeCategory()
            ->take(20)
            ->get()->transform(function (Product $product) {
                return formatProduct($product);
            });
        return Inertia::render('Index', [
            'events' => $events,
            'allCategories' => $categories,
            'products' => $products,
        ]);
    }


}
