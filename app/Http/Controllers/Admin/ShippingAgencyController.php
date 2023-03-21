<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ShippingAgencyRequest;
use App\Models\City;
use App\Models\ShippingAgency;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ShippingAgencyController extends Controller
{
    public function index(): View
    {

        $shippingAgencies = ShippingAgency::when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'id', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 10);

        return view('backend.shipping_agencies.index', compact('shippingAgencies'));
    }

    public function create(): View
    {
        $cities = City::whereDoesntHave('agency')->orderBy('id', 'asc')->get(['id', 'name']);

        return view('backend.shipping_agencies.create', compact('cities'));
    }

    public function store(ShippingAgencyRequest $request): RedirectResponse
    {
        if ($request->validated()) {
            ShippingAgency::create($request->all());
            return redirect()->route('admin.shipping_agencies.index')->with([
                'message' => 'Created successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong, please try again late',
            'alert-type' => 'danger'
        ]);

    }

    public function show(ShippingAgency $shippingAgency): View
    {
        return view('backend.shipping_agencies.show', compact('shippingAgency'));
    }

    public function edit(ShippingAgency $shippingAgency): View
    {
        $cities = City::orderBy('id', 'asc')->get(['id', 'name']);

        return view('backend.shipping_agencies.edit', compact('shippingAgency', 'cities'));
    }

    public function update(ShippingAgencyRequest $request, ShippingAgency $shippingAgency): RedirectResponse
    {
        if ($request->validated()) {
            $shippingAgency->update($request->all());
            return redirect()->route('admin.shipping_agencies.index')->with([
                'message' => 'Updated successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong, please try again late',
            'alert-type' => 'danger'
        ]);
    }

    public function destroy(ShippingAgency $shippingAgency): RedirectResponse
    {

        $shippingAgency->delete();

        return redirect()->route('admin.shipping_agencies.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
