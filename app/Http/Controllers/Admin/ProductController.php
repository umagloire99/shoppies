<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductCountry;
use App\Models\Tag;
use App\Services\ImageService;
use App\Traits\ImageUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ImageUploadTrait;

    /**
     * @return View
     */
    public function index(): View
    {
        $products = Product::with('category', 'tags', 'firstMedia')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'id', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 10);

        return view('backend.products.index', compact('products'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = Category::active()->get(['id', 'name']);
        $tags = Tag::active()->get(['id', 'name']);
        $countries = Country::all();

        return view('backend.products.create', compact('categories', 'tags', 'countries'));
    }

    /**
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        if ($request->validated()){

            $product = Product::create($request->only('name', 'description', 'details', 'features', 'usages',
                'quantity', 'category_id', 'status'));

            foreach (Country::all() as $country) {
                $price = $request->get($country->short_name.'_price');
                $quantity = $request->get($country->short_name.'_quantity');
                if ($price){
                    $productProduct =new ProductCountry();
                    $productProduct->country()->associate($country);
                    $productProduct->product()->associate($product);
                    $productProduct->price = $price;
                    $productProduct->quantity = $quantity;
                    $productProduct->save();
                }
            }

            if ($request->images && count($request->images) > 0) {
                (new ImageService())->storeProductImages($request->images, $product);
            }

            clear_cache();

            return redirect()->route('admin.products.index')->with([
                'message' => 'Create product successfully',
                'alert-type' => 'success'
            ]);
        }

        return back()->with([
            'message' => 'Something was wrong, please try again late',
            'alert-type' => 'error'
        ]);
    }

    /**
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        return view('backend.products.show', compact('product'));
    }

    /**
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $categories = Category::whereStatus(true)->get(['id', 'name']);
        $countries = Country::all()->transform(function (Country $country) use($product) {
            $productCountry = $product->productCountries->where('country_id', $country->id)->first();
            return [
                'id' => $country->id,
                'name' => $country->name,
                'short_name' => $country->short_name,
                'price' => $productCountry?->price,
                'quantity' => $productCountry?->quantity
            ];
        });
        return view('backend.products.edit', compact('product', 'categories', 'countries'));
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        if ($request->validated()) {
            $product->update(($request->only('name', 'description', 'details', 'features', 'usages',
                'quantity', 'category_id', 'status')));

            $i = $product->media()->count() + 1;

            foreach (Country::all() as $country) {
                $price = $request->get($country->short_name.'_price');
                $quantity = $request->get($country->short_name.'_quantity');
                if ($price && $quantity) {
                    ProductCountry::updateOrCreate(
                        ['product_id' => $product->id, 'country_id' => $country->id],
                        ['price' => $price, 'quantity' => $quantity]
                    );
                }
            }

            if ($request->images && count($request->images) > 0) {
                (new ImageService())->storeProductImages($request->images, $product, $i);
            }

            clear_cache();
            return redirect()->route('admin.products.index')->with([
                'message' => 'Updated product successfully',
                'alert-type' => 'success'
            ]);
        }
        return back()->with([
            'message' => 'Something was wrong, please try again late',
            'alert-type' => 'error'
        ]);
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->media->count() > 0) {
            foreach ($product->media as $media) {
                (new ImageService())->unlinkImage($media->file_name, 'products');
                $media->delete();
                foreach($product->productCountries as $value) {
                    $value->delete();
                }
            }
        }

        $product->delete();

        clear_cache();
        return redirect()->route('admin.products.index')->with([
            'message' => 'Deleted product successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function removeImage(Request $request): bool
    {
        $product = Product::findOrFail($request->product_id);
        $image = $product->media()->whereId($request->image_id)->first();

        (new ImageService())->unlinkImage($image->file_name, 'products');
        $image->delete();
        clear_cache();

        return true;
    }
}
