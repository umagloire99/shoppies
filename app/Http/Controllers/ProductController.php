<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use Illuminate\Http\Request;



class ProductController extends Controller
{

    /**
     * keyword to search a specific item
     * @var string
     */
    private string $keyword;

    /**
     * sorting order(Low-High, High-Low, Random)
     * @var string
     */
    private string $sortingBy;

    /**
     * highlight(best-seller, new-arrival, sale, hot-items)
     * @var string
     */
    private string $highlight;

    public function __construct(Request $request)
    {
        $this->keyword = $request->get('keyword', '');
        $this->highlight = $request->get('highlight', '');
        $this->sortingBy = $request->get('sortingBy', '');
    }

    /**
     * @param null $slug
     * @return Response
     */
    public function shop($slug = null): Response
    {
        $category = Category::whereSlug($slug)->first();
        $products = $this->getProducts($slug);
        Inertia::share([
            'slug' => $slug,
            'route' => route('shop.index', [$slug]),
            'name' => $category ? $category->name : 'all'
        ]);
        setMetaInfo(
            $category ? $category->name : null,
            null,
            $category ? asset('storage/images/categories/' . $category->media->file_name) : null
        );

        return Inertia::render('Product/Index', [
            'products' => $products,
        ]);
    }


    public function getProducts($slug = null)
    {
        switch ($this->sortingBy) {
            case 'low-high':
                $sortField = 'price';
                $sortType = 'asc';
                break;
            case 'high-low':
                $sortField = 'price';
                $sortType = 'desc';
                break;
            default:
                $sortField = 'id';
                $sortType = 'asc';
        }
        $products = getProducts()->withCount(['orders'])->select(['products.id', 'name', 'slug', 'category_id', 'status', 'featured', 'review_able']);
        $category = Category::whereSlug($slug)->whereStatus(true)->first();
        if (!$category) {
            $category = Category::whereStatus(true)->inRandomOrder()->first();
            $products = $products->activeCategory();
        } else {
            if (is_null($category->parent_id)) {
                $categoriesIds = Category::whereParentId($category->id)
                    ->whereStatus(true)->pluck('id')->toArray();
                $categoriesIds = array_merge($categoriesIds, [$category->id]);
                $products = $products->whereHas('category', function ($query) use ($categoriesIds) {
                    $query->whereIn('id', $categoriesIds);
                });
            } else {
                $products = $products->with('category')
                    ->whereHas('category', function ($query) use ($slug) {
                        $query->where([
                            'slug' => $slug,
                            'status' => true
                        ]);
                    });
            }
        }
        if ($this->keyword) {
            $products = $products->search($this->keyword);
        }
        switch ($this->highlight) {
            case 'best-seller':
                $products = $products->active()
                    ->orderByDesc('orders_count')
                    ->orderBy($sortField, $sortType)
                    ->paginate();
                break;
            case 'new-arrivals':
                $products = $products->active()
                    ->orderByDesc('created_at')
                    ->orderBy($sortField, $sortType)
                    ->paginate();
                break;
            case 'flash-sale':
                $products = $products->active()
                    ->with(['discount' => function ($query) {
                        $query->orderBy('value', 'desc');
                    }])
                    ->orderByDesc('created_at')
                    ->orderBy($sortField, $sortType)
                    ->paginate();
                break;
            default:
                $products = $products->active()
                    ->inRandomOrder()
                    ->orderBy($sortField, $sortType)
                    ->paginate();
        }

        $products =  $products->through(function ($product) {
            return formatProduct($product);
        });
        Inertia::share([
            'sortingBy' => $this->sortingBy,
            'total_products' => $products->total(),
            'highlight' => $this->highlight,
            'cover_image' =>  asset('storage/images/categories/' . $category->media->file_name)
        ]);
        return $products;
    }

    public function show($slug)
    {
        $product = getProducts()->with('media', 'category', 'approvedReviews')
            ->active()
            ->whereSlug($slug)
            ->activeCategory()
            ->first();
        if (!$product) {
            return back()->with(['warning' => __('general.resource-not-found')]);
        }
        setMetaInfo(
            $product->name,
            $product->description,
            $product->img
        );

        $relatedProducts = getProducts()->with('firstMedia')->whereHas('category', function ($query) use ($product) {
            $query->whereId($product->category_id);
            $query->whereStatus(1);
        })->where('products.id', '<>', $product->id)
            ->inRandomOrder()
            ->active()
            ->take(8)
            ->get()->transform(function (Product $product) {
                return formatProduct($product);
            });
        return Inertia::render('Product/Show', [
            'product' => formatProduct($product, 2),
            'relatedProducts' => $relatedProducts
        ]);
    }
}
