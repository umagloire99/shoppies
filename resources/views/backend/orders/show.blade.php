@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Order ({{ $order->ref_id }})</h6>
            <div class="ml-auto">
                <form action="{{ route('admin.orders.update', $order) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-row align-items-center">
                        <label class="sr-only" for="inlineFormInputGroupUsername">Order Status</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Order status</div>
                            </div>
                            <select class="form-control" name="order_status" style="outline-style: none;" onchange="this.form.submit()">
                                <option value=""> Choose Action </option>
                                @foreach($orderStatusArray as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex">
            <div class="col-8">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Ref. Id</th>
                            <td>{{ $order->ref_id }}</td>
                            <th>Customer</th>
                            <td><a href="{{ route('admin.users.show', $order->user_id) }}">{{ $order->user->full_name }}</a></td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td> {{ $order->userAddress->country?->name }} </td>
                            <th>Address</th>
                            <td>
                                <a href="{{ route('admin.user_addresses.show', $order->user_address_id) }}">
                                    {{ $order->userAddress->city?->name }}, {{ $order->userAddress->address_title }}
                                </a>
                            </td>
                           </tr>

                        <tr>
                            <th>Phone Number</th>
                            <td>
                                {{ $order->userAddress->phone_one }}
                            </td>
                            <th>Payment Method</th>
                            <td>{{ $order->paymentMethod->name }}</td>
                        </tr>
                        <tr>
                            <th>Created date</th>
                            <td>{{ $order->created_at->format('d-m-Y h:i a') }}</td>
                            <th>Order status</th>
                            <td>{!! $order->statusWithBadge() !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>{{ $order->currency().' ' .number_format($order->subtotal) }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>{{ $order->currency().' ' .number_format($order->discount) }}</td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td>{{ $order->currency().' ' .number_format($order->shipping) }}</td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>{{ $order->currency().' ' .number_format($order->total) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Details</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->orderproducts as $orderProduct)
                    <tr>
                        <td>
                            <a href="{{ route('admin.products.show', $orderProduct->product_id) }}">
                                {{ $orderProduct->product->name }}
                            </a>
                        </td>
                        <td>XAF {{ number_format($orderProduct->price) }}</td>
                        <td>{{ $orderProduct->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No products found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Transaction</th>
                    <th>Transaction number</th>
                    <th>External number</th>
                    <th>Payment result</th>
                    <th>Action date</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->status($transaction->transaction_status) }}</td>
                        <td>{{ $transaction->transaction_number }}</td>
                        <td>{{ $transaction->external_number }}</td>
                        <td>{{ $transaction->payment_result }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d h:i a') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No transactions found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
