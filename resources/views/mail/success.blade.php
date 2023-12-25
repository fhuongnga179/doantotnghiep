<!-- mail.success.blade.php -->

<h1>Có một đơn đặt hàng</h1>
<p>Thông tin khách hàng:</p>
<ul>
    <li><strong>Tên:</strong> {{ $data['customerName'] }}</li>
    <li><strong>Số điện thoại:</strong> {{ $data['customerPhone'] }}</li>
    <li><strong>Địa chỉ:</strong> {{ $data['customerAddress'] }}</li>
    <li><strong>Email:</strong> {{ $data['customerEmail'] }}</li>
    <li><strong>Nội dung đặt hàng:</strong> {{ $data['customerContent'] }}</li>
</ul>

<p>Sản phẩm đã mua:</p>
<ul>
    @if (isset($data['products']) && is_array($data['products']))
        @foreach ($data['products'] as $product)
            <li>
                <strong>{{ $product['name'] }}</strong>
                <p>Giá: {{ $product['price'] }}</p>
                <p>Số lượng: {{ $product['quantity'] }}</p>
            </li>
        @endforeach
    @else
        <li>Không có sản phẩm đặt hàng</li>
    @endif
</ul>

<p>Tổng số tiền: {{ $data['totalAmount'] }}</p>
