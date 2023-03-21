<?php

use App\Models\Category;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;

function formatCategory(Category $category, $level = 1): array
{
    $array = [
        'id' => $category->id,
        'name' => $category->name,
        'slug' => $category->slug,
    ];
    if ($level == 2) {
        return array_merge($array, [
            'products_count' => $category->products()->count(),
            'img' => asset('storage/images/categories/' . $category->media->file_name)
        ]);
    }
    if ($level == 3) {
        return array_merge($array, [
            'children' => $category->children()->get()->transform(function (Category $category) {
                return formatCategory($category, 3);
            })]);
    }
    return $array;
}

function formatReview(Review $review): array
{
    return [
        'user' => [
            'name' => $review->user->name,
            'address' => $review->user->address,
            'avatar' => asset('images/avatar.png')
        ],
        'title' => $review->title,
        'content' => $review->content,
        'rating' => $review->rating,
        'media' => $review->media()->get()->transform(function (Media $media) {
            return asset('storage/images/reviews/' . $media->file_name);
        }),
        'created_at' => $review->created_at,
    ];
}

/**
 * @return string
 */
function generateRef(): string
{
    $order = Order::orderByDesc('id')->first();
    return  $order ? 'SHO-' . ($order->id + 1) :'HYC-1';
}

/**
 * @param $cartItem
 * @return array
 */
function formatCartItem($cartItem): array
{
    $product = $cartItem->model;
    return ($cartItem && $cartItem->model) ? [
        'id' => $cartItem->id,
        'rowId' => $cartItem->rowId,
        'name' => $cartItem->name,
        'quantity' => $cartItem->qty,
        'price' => $cartItem->price,
        'slug' => $product->slug,
        'is_out_stock' => $cartItem->qty > $product->quantity,
        'total_discount_price' => $cartItem->qty * ($product->discount ? (int)($product->price - $product->discount->value * $product->price) : $product->price),
        'product_quantity' => $product->quantity,
        'discount_price' => $product->discount ? (int)($product->price - $product->discount->value * $product->price) : $product->price,
        'discount' => $product->discount ? $product->discount->value : null,
        'img' => $product->firstMedia ?asset('storage/images/products/' . $product->firstMedia->file_name):null,
    ] : [];
}

/**
 * @param Order $order
 * @return array
 */
function formatOrder(Order $order): array
{
    return [
        'ref_id' => $order->ref_id,
        'created_at' => $order->created_at,
        'currency_symbol' => 'XAF',
        'payment_method' => $order->paymentMethod->name,
        'address' => [
            'name' => $order->userAddress->name,
            'email' => $order->userAddress->email,
            'city' => $order->userAddress->city->name,
            'title' => $order->userAddress->address_title,
            'phone' => $order->userAddress->phone_one
        ],
        'shipping' => $order->shipping,
        'discount' => $order->discount,
        'subtotal' => $order->subtotal,
        'total' => $order->total,
        'products' => $order->orderProducts()->get()->transform(function (OrderProduct $orderProduct) {
            return [
                'id' => $orderProduct->product_id,
                'quantity' => $orderProduct->quantity,
                'name' => $orderProduct->product->name,
                'price' => $orderProduct->product->price,
                'discount' => $orderProduct->discount,
                'product_discount' => $orderProduct->product->price - ($orderProduct->discount * $orderProduct->product->price)
            ];
        })
    ];
}

function formatProduct(Product $product, $level = 1): array
{
    $label = null;
    if ($product->discount && (int)$product->discount->value !== 0) {
        $label = 'sale';
    } elseif (Carbon::now()->diffInDays($product->created_at) <= 7) {
        $label = 'new';
    }
    $array = [
        'id' => $product->id,
        'name' => $product->name,
        'slug' => $product->slug,
        'price' => $product->price,
        'quantity' => $product->quantity,
        'label' => $label,
        'discount_price' => $label == 'sale' ? (int)($product->price - $product->discount->value * $product->price) : $product->price,
        'discount' => $label == 'sale' ? $product->discount->value : null,
        'rate' => (int)$product->approvedReviews()->avg('rating'),
        'reviews_count' => $product->approvedReviews()->count(),
        'img' => $product->firstMedia ? asset('storage/images/products/' . $product->firstMedia->file_name) : null,
    ];
    if ($level == 2) {
        return array_merge($array, [
            'details' => $product->details,
            'description' => $product->description,
            'usages' => $product->usages,
            'features' => $product->features,
            'category' => formatCategory($product->category),
            'media' => $product->media->transform(function (Media $media) {
                return [
                    'type' => array_search(strtolower($media->file_type), videoFormat()) ? 'video' : 'image',
                    'path' => asset('storage/images/products/' . $media->file_name)
                ];
            }),
            'reviews' => $product->approvedReviews()->take(20)->get()->transform(function (Review $review) {
                return formatReview($review);
            })
        ]);
    }
    return $array;
}


function videoFormat()
{
    return [
        'video/x-flv',
        'video/mp4',
        'application/x-mpegURL',
        'video/MP2T',
        'video/3gpp',
        'video/quicktime',
        'video/x-msvideo',
        'video/x-ms-wmv'
    ];
}
