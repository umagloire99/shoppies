@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Shipping Agencies
            </h6>
            <div class="ml-auto">
                    <a href="{{ route('admin.shipping_agencies.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                        <span class="text">New Agency</span>
                    </a>
            </div>
        </div>

        @include('partials.backend.filter', ['model' => route('admin.shipping_agencies.index')])

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>City</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>Out of town</th>
                    <th class="text-center" style="width: 30px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($shippingAgencies as $shippingAgency)
                    <tr>
                        <td><a href="#">{{ $shippingAgency->name }}</a></td>
                        <td>{{ $shippingAgency->city->name }}<br>
                        Can pay on delivery: {{$shippingAgency->can_pay_on_delivery ? 'yes' : 'no'}}
                        </td>
                        <td>{{ $shippingAgency->cost }}</td>
                        <td>{{ $shippingAgency->status }}</td>
                        <td>{{ $shippingAgency->out_of_town }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.shipping_agencies.edit', $shippingAgency) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);"
                                   onclick="if (confirm('Are you sure to delete this record?'))
                                       {document.getElementById('delete-shipping-company-{{ $shippingAgency->id }}').submit();} else {return false;}"
                                   class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                            <form action="{{ route('admin.shipping_agencies.destroy', $shippingAgency) }}"
                                  method="POST"
                                  id="delete-shipping-company-{{ $shippingAgency->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="8">No shipping Agency found.</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="8">
                        <div class="float-right">
                            {!! $shippingAgencies->appends(request()->all())->links() !!}
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
