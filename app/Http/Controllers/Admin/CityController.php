<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CityRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CityController extends Controller
{
    public function index(): View
    {
        $cities = City::with('country')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'id', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 20);

        return view('backend.cities.index', compact('cities'));
    }

    public function create(): View
    {
        $countries = Country::get(['id', 'name']);

        return view('backend.cities.create', compact('countries'));
    }

    public function store(CityRequest $request): RedirectResponse
    {

        City::create($request->validated());

        return redirect()->route('admin.cities.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show(City $city): View
    {

        return view('backend.cities.show', compact('city'));
    }

    public function edit(City $city): View
    {

        $countries = Country::get(['id', 'name']);

        return view('backend.cities.edit', compact('city', 'countries'));
    }

    public function update(CityRequest $request, City $city): RedirectResponse
    {

        $city->update($request->validated());

        return redirect()->route('admin.cities.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(City $city): RedirectResponse
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function get_cities(Request $request): JsonResponse
    {
        $cities = City::whereStateId($request->state_id)
            ->whereStatus(true)
            ->get(['id', 'name'])
            ->toArray();

        return response()->json($cities);
    }
}
