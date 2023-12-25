
<h1>Danh sách đơn hàng</h1>

<ul>
    @foreach($orders as $order)
        <li>{{ $order->customer_name }} - {{ $order->total_amount }}</li>
    @endforeach
</ul>
