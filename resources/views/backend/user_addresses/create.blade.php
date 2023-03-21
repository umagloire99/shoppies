@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Create Address
            </h6>
            <div class="ml-auto">
                <a href="{{ route('admin.user_addresses.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Back to addresses</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user_addresses.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="user_name">Customer</label>
                            <input class="form-control typeahead" id="user_name" type="text"
                                   name="user_name"
                                   placeholder="Start typing to search customer..."
                                   autocomplete="off"
                                   value="{{ old('user_name', request()->input('user_name')) }}">
                            <input class="form-control" id="user_id" type="hidden" name="user_id"
                                   value="{{ old('user_id', request()->input('user_id')) }}" readonly>
                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="address_title">Address title</label>
                            <input class="form-control" id="address_title" type="text" name="address_title" value="{{ old('address_title') }}">
                            @error('address_title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="phone">Phone One</label>
                            <input class="form-control" id="phone" type="text" name="phone_one" value="{{ old('phone_one') }}">
                            @error('phone_one')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="phone">Phone Two</label>
                            <input class="form-control" id="phone" type="text" name="phone_two" value="{{ old('phone_two') }}">
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
                                    <option value="{{ $city->id }}" {{ old('city_id') }}>
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
                            <input class="form-control" id="zip_code" type="text" name="zip_code" value="{{ old('zip_code') }}">
                            @error('zip_code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="po_box">PO Box</label>
                            <input class="form-control" id="po_box" type="text" name="po_box" value="{{ old('po_box') }}">
                            @error('po_box')<span class="text-danger">{{ $message }}</span>@enderror
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
@section('scripts')
    <script src="{{ asset('backend/vendor/typeahead/bootstrap3-typeahead.min.js') }}"></script>
    <script>
        $(function () {
            // On change country field
            $("#country_id").change(function () {
                populateStates();
                populateCities();
                return false
            });

            $("#state_id").change(function () {
                populateCities();
                return false
            });

            function populateStates()
            {
                let countryId = $('#country_id').val() != null ? $('#country_id').val() : "{{ old('country_id') }}";
                $.get("{{ route('admin.states.get_states') }}", { country_id: countryId }, function (data) {
                    $('option', $("#state_id")).remove();
                    $("#state_id").append($('<option><option>').val('').html(' --- '));
                    $.each(data, function (val, text) {
                        let selectedVal = text.id == "{{ old('state_id') }}" ? "selected" : "";
                        $("#state_id").append($(`<option value="${text.id}" ${selectedVal}>${text.name}<option>`));
                    });

                }, "json");
            }

            function populateCities()
            {
                let stateId = $('#state_id').val() != null ? $('#state_id').val() : "{{ old('state_id') }}";
                $.get("{{ route('admin.cities.get_cities') }}", { state_id: stateId }, function (data) {
                    $("option", $("#city_id")).remove();
                    $("#city_id").append($("<option><option>").val('').html(' --- '));
                    $.each(data, function (val, text) {
                        let selectedVal = text.id == "{{ old('city_id') }}" ? "selected" : "";
                        $("#city_id").append($(`<option value="${text.id}" ${selectedVal}>${text.name}<option>`));
                    });
                }, "json");
            }

            // Search customers by typeahead jQuery package
            $(".typeahead").typeahead({
                autoSelect: true,
                minLength: 3,
                delay: 400,
                displayText: function (item) { return item.full_name + ' - ' + item.email; },
                source: function (query, process) {
                    return $.get("{{ route('admin.users.get_users') }}", { 'query': query }, function (data) {
                        return process(data);
                    });
                },
                afterSelect: function (data) {
                    $("#user_id").val(data.id);
                }
            });
        });
    </script>
@endsection
