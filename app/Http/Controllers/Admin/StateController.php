<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StateRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(): View
    {
        $states = State::with('country', 'cities')
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'id', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 10);

        return view('backend.states.index', compact('states'));
    }

    public function create(): View
    {
        $countries = Country::get(['id', 'name']);

        return view('backend.states.create', compact('countries'));
    }

    public function store(StateRequest $request): RedirectResponse
    {
        State::create($request->validated());

        return redirect()->route('admin.states.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show(State $state): View
    {

        return view('backend.states.show', compact('state'));
    }

    public function edit(State $state): View
    {

        $countries = Country::get(['id', 'name']);

        return view('backend.states.edit', compact('state', 'countries'));
    }

    public function update(StateRequest $request, State $state): RedirectResponse
    {
        $state->update($request->validated());

        return redirect()->route('admin.states.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(State $state): RedirectResponse
    {

        $state->delete();

        return redirect()->route('admin.states.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }

    public function get_states(Request $request): JsonResponse
    {
        $states = State::whereCountryId($request->country_id)
            ->whereStatus(true)
            ->get(['id', 'name'])
            ->toArray();

        return response()->json($states);
    }

}
