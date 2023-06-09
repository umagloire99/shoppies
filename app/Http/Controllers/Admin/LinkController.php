<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LinkRequest;
use App\Models\Link;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class LinkController extends Controller
{
    public function index(): View
    {
        $links = Link::latest()->paginate(5);

        return view('backend.links.index', compact('links'));
    }

    public function create(): View
    {
        return view('backend.links.create');
    }

    public function store(LinkRequest $request): RedirectResponse
    {
        Link::create($request->validated());

        Cache::forget('admin_side_menu');

        return redirect()->route('admin.links.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Link $link): View
    {
        return view('backend.links.edit', compact('link'));
    }

    public function update(LinkRequest $request, Link $link): RedirectResponse
    {
        $link->update($request->validated());

        Cache::forget('admin_side_menu');

        return redirect()->route('admin.links.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(Link $link): RedirectResponse
    {
        $link->delete();

        Cache::forget('admin_side_menu');

        return redirect()->route('admin.links.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
