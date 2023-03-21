<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserAddressRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\UserAddress;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserAddressController extends Controller
{
    public function index(): View
    {
        $userAddresses = UserAddress::with(['user',  'city'])
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereDefaultAddress(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'id', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 10);
        return view('backend.user_addresses.index', compact('userAddresses'));
    }

    public function create(): View
    {
        $cities = City::whereHas('agency')->get();

        return view('backend.user_addresses.create', compact('cities'));
    }

    public function store(UserAddressRequest $request): RedirectResponse
    {
        UserAddress::create($request->validated());

        return redirect()->route('admin.user_addresses.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show(UserAddress $userAddress): View
    {

        return view('backend.user_addresses.show', compact('userAddress'));
    }

    public function edit(UserAddress $userAddress): View
    {
        $cities = City::whereHas('agency')->get();
        return view('backend.user_addresses.edit', compact('userAddress', 'cities'));
    }

    public function update(UserAddressRequest $request, UserAddress $userAddress): RedirectResponse
    {

        $userAddress->update($request->validated());

        return redirect()->route('admin.user_addresses.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(UserAddress $userAddress): RedirectResponse
    {
        $userAddress->delete();

        return redirect()->route('admin.user_addresses.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
