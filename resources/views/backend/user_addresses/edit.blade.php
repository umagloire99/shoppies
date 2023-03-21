@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Address ({{ $userAddress->address_title }})
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.user_addresses.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                    </span>
                    <span class="text">Back to addresses</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user_addresses.update', $userAddress->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="user_name">Customer</label>
                            <input class="form-control" id="user_name" type="text" name="user_name" value="{{ $userAddress->user->full_name }}" readonly>
                            <input class="form-control" id="user_id" type="hidden" name="user_id" value="{{ $userAddress->user_id }}" readonly>
                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="address_title">Address title</label>

                            <input class="form-control" id="address_title" type="text" name="address_title" value="{{ old('address_title', $userAddress->address_title) }}">
                            @error('address_title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="first_name">Name</label>
                            <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $userAddress->name) }}">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $userAddress->email) }}">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="phone">Phone One</label>
                            <input class="form-control" id="phone" type="text" name="phone_one" value="{{ old('phone_one', $userAddress->phone_one) }}">
                            @error('phone_one')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="phone">Phone Two</label>
                            <input class="form-control" id="phone" type="text" name="phone_two" value="{{ old('phone_two', $userAddress->phone_two) }}">
                            @error('phone_two')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="city_id">city</label>
                            <select name="city_id" id="city_id" class="form-control">
                                <option value="">---</option>
                                @forelse( $cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $userAddress->city_id) == $city->id ? 'selected' : null }}>
                                        {{ $city->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('city_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="zip_code">ZIP Code</label>
                            <input class="form-control" id="zip_code" type="text" name="zip_code" value="{{ old('zip_code', $userAddress->zip_code) }}">
                            @error('zip_code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="po_box">PO Box</label>
                            <input class="form-control" id="po_box" type="text" name="po_box" value="{{ old('po_box', $userAddress->po_box) }}">
                            @error('po_box')<span class="text-danger">{{ $message }}</span>@enderror
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
@section('scripts')
    <script src="{{ asset('backend/vendor/typeahead/bootstrap3-typeahead.min.js') }}"></script>

    <script>
        $(function () {
            populateStates();
            populateCities();
        });
    </script>
@endsection
