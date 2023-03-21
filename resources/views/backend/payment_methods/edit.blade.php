@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Payment method ({{ $paymentMethod->name }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Payment methods</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.payment_methods.update', $paymentMethod->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="code">code</label>
                            <input type="text" name="code" value="{{ old('code', $paymentMethod->code) }}" class="form-control">
                            @error('code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $paymentMethod->status) == '1' ? 'selected' : null }}>Active</option>
                                <option value="0" {{ old('status', $paymentMethod->status) == '0' ? 'selected' : null }}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Update Payment method</button>
                </div>
            </form>
        </div>
    </div>

@endsection
