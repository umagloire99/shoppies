<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Category;
use App\Models\Event;
use App\Models\Product;
use App\Services\CacheDataManager;
use Illuminate\Support\Facades\Cache;
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
        $cacheData = new CacheDataManager(static::class);

        setMetaInfo();

        $events = $cacheData->getData(
            Event::class,
            Event::limit(5)->get()->transform(function (Event $event) {
                return (new EventResource($event));
            })
        );

        $categories = $cacheData->getData(
            Category::class,
            Category::active()
                ->whereParentId(null)
                ->limit(10)
                ->get()->transform(function ($category) {
                    return formatCategory($category, 2);
                })
        );

        $products = $cacheData->getData(
            Product::class,
            getCurrentCountry()->products()
                ->with(['discount', 'firstMedia'])
                ->withCount(['approvedReviews'])
                ->inRandomOrder()
                ->active()
                ->activeCategory()
                ->take(20)
                ->select(['products.id', 'name', 'slug', 'status', 'featured', 'review_able'])
                ->get()->transform(function (Product $product) {
                    return formatProduct($product);
                })

        );

        return Inertia::render('Index', [
            'events' => $events,
            'allCategories' => $categories,
            'products' => $products,
        ]);
    }
}
