<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Country</th>
        <th>Address</th>
        <th> Products</th>
        <th>Status</th>
        <th> Total </th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->user->full_name }}</td>
            <td>{{ $order->userAddress?->phone_one }}</td>
            <td>{{ $order->userAddress?->country?->name  }}</td>
            <td>{{ $order->userAddress?->city?->name  }}, {{ $order->userAddress->address_title }}</td>
            <td>
                @foreach($order->orderproducts as $orderProduct)
                    {{ $orderProduct->product->name }}(*{{ $orderProduct->quantity }});
                @endforeach
            </td>
            <td>{{ $order->statusWithBadge()  }}</td>
            <td>{{ $order->currency() . number_format($order->total) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
