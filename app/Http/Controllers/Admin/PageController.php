<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PageRequest;
use App\Models\Page;

class PageController extends Controller
{

    public $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function index()
    {
        $pages = $this->page->all();

        return view('backend.pages.index', compact('pages'));
    }

    public function show(Page $page)
    {
        return view('backend.pages.show', compact('page'));
    }

    public function create()
    {
        $this->authorize('create_page');

        return view('backend.pages.create');
    }

    public function store(PageRequest $request)
    {

        $this->page->create($request->validated());

        return redirect()->route('admin.pages.index')->with(['message' => 'Page added successfully', 'alert-type' => 'success',]);


    }

    public function edit(Page $page)
    {
        return view('backend.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page)
    {
        $page->update($request->validated());

        return redirect()->route('admin.pages.index')->with(['message' => 'Page updated successfully', 'alert-type' => 'success',]);
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->back()->with(['message' => 'Page deleted successfully', 'alert-type' => 'success',]);
    }

}
