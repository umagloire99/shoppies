@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Link: ({{ $link->title }})
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.links.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Back to links</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.links.update', $link) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control" id="title" type="text" name="title" value="{{ old('title', $link->title) }}"
                                   placeholder="ex. Categories">
                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="as">As</label>
                            <input class="form-control" id="as" type="text" name="as" value="{{ old('as', $link->as) }}"
                                   placeholder="ex. Category">
                            @error('as')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="to">To</label>
                            <input class="form-control" id="to" type="text" name="to" value="{{ old('to', $link->to) }}"
                                   placeholder="ex. admin.categories.index">
                            @error('to')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input class="form-control" id="icon" type="text" name="icon" value="{{ old('icon', $link->icon) }}"
                                   placeholder="far fa-flag">
                            @error('icon')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">---</option>
                                <option value="1" {{ old('status', $link->status) == "Active" ? 'selected' : null }}>Active</option>
                                <option value="0" {{ old('status', $link->status) == "Inactive" ? 'selected' : null }}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group pt-4">
                    <button class="btn btn-primary" type="submit" name="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
