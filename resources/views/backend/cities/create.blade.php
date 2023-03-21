@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Create City
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.cities.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                    </span>
                    <span class="text">Back to cities</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.cities.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">City</label>
                            <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="state_id">State</label>
                            <select name="state_id" id="country_id" class="form-control">
                                <option value="">---</option>
                                @forelse($states as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : null }}>
                                        {{ $state->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('state_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group pt-4">
                    <button class="btn btn-primary" type="submit" name="submit">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection
