<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    use ImageUploadTrait;

    public function login(): View
    {
        return view('backend.login');
    }

    public function forgotPassword(): View
    {
        return view('backend.forgot-password');
    }

    public function accountSetting(): View
    {
        return view('backend.account_setting');
    }

    public function updateAccount(Request $request): RedirectResponse
    {
        $adminImage = null;
        if ($request->hasFile('user_image')) {
            if (auth()->user()->user_image) (new ImageService())->unlinkImage(auth()->user()->user_image, 'users');
            $adminImage = (new ImageService())->storeUserImages(auth()->user()->username, $request->user_image);
        }

        if ($request->password){
            $password = bcrypt($request->password);
        }
        auth()->user()->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'user_image' => $adminImage ?? auth()->user()->user_image,
            'password' => $password ?? auth()->user()->password
        ]);

        return redirect()->back()->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }
}
