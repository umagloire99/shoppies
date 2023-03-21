<?php

namespace App\Http\Controllers;

use App\Http\Requests\Backend\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\ImageService;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, $id) {

        if ($request->validated()) {
            $product = Product::whereId($id)->first();
            if (!$product) {
                return back()->with(['error' => __('general.product-not-found')]);
            }
            $user = User::whereEmail($request->get('email'))->first();
            if (!$user) {
                $user = new User();
                $user->email = $request->get('email');
                $user->username = generateUsername($request->get('email'));
            }
            $user->name = $request->get('name');
            $user->save();
            $review = new Review();
            $review->product()->associate($product);
            $review->title = $request->get('title');
            $review->content = $request->get('message');
            $review->rating = $request->get('star') ? $request->get('star') : 0;
            $review->user()->associate($user);
            $review->save();
            if ($request->hasFile('images')) {
                (new ImageService('reviews'))->storeProductImages($request->file('images'), $review);
            }
            return back()->with(['success' => 'Your Review ']);
        }
        return back()->with([
            'error' => 'Something was wrong, please try again late'
        ]);

    }
}
