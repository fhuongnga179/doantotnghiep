<link rel="icon" type="image/png" href="/template/images/icons/favicon.png" />
<!--=====================================/==========================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/animate/animate.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/select2/select2.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/slick/slick.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/css/util.css">
<link rel="stylesheet" type="text/css" href="/template/css/main.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/css/style.css">



<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">


<header>
    <!-- Header desktop -->
    <div class="container-menu-desktop">

        <div class="wrap-menu-desktop" style="background: #8ff38f">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="#" class="logo">
                    <img src="/template/images/icons/logo-01.png" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu"><a href="/">Trang Chủ</a> </li>


                        <li>
                            <a href="contact">Liên Hệ</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>



                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile" style="background: #8ff38f">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="/template/images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li class="active-menu"><a href="/">Trang Chủ</a> </li>


            <li>
                <a href="contact">Liên Hệ</a>
            </li>

        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="/template/images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>

<form class="bg0 p-t-130 p-b-85" method="post">
    @include('admin.alert')
    @if (count($products) != 0)
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            @php $total = 0; @endphp
                            <table class="table-shopping-cart">
                                <tbody>
                                    <tr class="table_head">
                                        <th class="column-1">Product</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Price</th>
                                        <th class="column-4">Quantity</th>
                                        <th class="column-5">Total</th>
                                        <th class="column-6">&nbsp;</th>
                                    </tr>

                                    @foreach ($products as $key => $product)
                                        @php
                                            $price = $product->price;
                                            $priceEnd = $price * $carts[$product->id];
                                            $total += $priceEnd;
                                        @endphp
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <input type="checkbox" class="checkbox-product"
                                                    name="selected_products[]" value="{{ $product->id }}">
                                                <div class="how-itemcart1">
                                                    <img src="{{ $product->thumb }}" alt="IMG">
                                                </div>
                                            </td>
                                            <td class="column-2">{{ $product->name }}</td>
                                            <td class="column-3">{{ number_format($price, 0, '', '.') }}</td>
                                            <td class="column-4">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">

                                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                                        onclick="decreaseQuantity('{{ $product->id }}')">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div>
                                                    <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                        name="num_product[{{ $product->id }}]"
                                                        value="{{ $carts[$product->id] }}">
                                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                                        onclick="increaseQuantity('{{ $product->id }}')">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div>

                                                </div>
                                            </td>

                                            <td class="column-5">{{ number_format($priceEnd, 0, '', '.') }}</td>
                                            <td class="p-r-15">
                                                <a href="/carts/delete/{{ $product->id }}">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <input type="submit" value="Update Cart" formaction="/update-cart"
                                class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            @csrf
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Cart Totals
                        </h4>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    {{ number_format($total, 0, '', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">

                            <div class="size-100 p-r-18 p-r-0-sm w-full-ssm">

                                <div class="p-t-15">
                                    <span class="stext-112 cl8">
                                        Thông Tin Khách Hàng
                                    </span>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
                                            name="name" placeholder="Tên khách Hàng"
                                            value="{{ Session::get('name') }}">
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
                                            name="phone"
                                            placeholder="Số Điện Thoại"value="{{ Session::get('phone') }}">

                                    </div>

                                    <div class="bor8 bg0    m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
                                            name="address" placeholder="Địa Chỉ Giao Hàng"
                                            value="{{ Session::get('address') }}">
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
                                            name="email" placeholder="Email Liên Hệ">
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <textarea class="cl8 plh3 size-111 p-lr-15" placeholder="Ghi chú" name="content"></textarea>
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <label for="cash_payment">
                                            <input type="radio" id="cash_payment" name="payment_method"
                                                value="cash" checked>
                                            Thanh toán tiền mặt
                                        </label>
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <label for="card_payment">
                                            <input type="radio" id="card_payment" name="payment_method"
                                                value="card">
                                            Thanh toán thẻ
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
</form>
<div style="display: flex; justify-content: space-between; align-items: center; margin-right: 450px">
    <div style="margin-right: 10px;">
        <img src="/template/images/payment.png" alt="Image Description" style="max-width: auto; height: auto;">
    </div>
    <div style="display: flex; flex-direction: column;">
        <form action="/checkout" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button style="margin-bottom: 10px;"
                class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                type="submit">Thanh Toán Online Stripe</button>
        </form>
        <form action="/paypal/checkout" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                type="submit">Thanh Toán Online PayPal</button>
        </form>
    </div>
</div>
@else
<div class="text-center">
    <h2>Giỏ hàng trống</h2>
</div>

@endif
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var cashPaymentRadio = document.getElementById("cash_payment");
        var onlinePaymentRadio = document.getElementById("online_payment");
        var qrCodeImage = document.getElementById("qrCodeImage");
        var paymentImage = document.getElementById("paymentImage");

        cashPaymentRadio.addEventListener("change", function() {
            qrCodeImage.style.display = "none";
            paymentImage.style.display = "none";
        });

        onlinePaymentRadio.addEventListener("change", function() {
            qrCodeImage.style.display = "block";
            paymentImage.style.display = "block";
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var cashPaymentRadio = document.getElementById("cash_payment");
        var cardPaymentRadio = document.getElementById("card_payment");
        var cardPaymentSection = document.getElementById("card_payment_section");

        cashPaymentRadio.addEventListener("change", function() {
            cardPaymentSection.style.display = "none";
        });

        cardPaymentRadio.addEventListener("change", function() {
            cardPaymentSection.style.display = "flex";
        });
    });
</script>
<script>
    function decreaseQuantity(productId) {
        var inputElement = document.querySelector(`input[name="num_product[${productId}]"]`);
        var currentValue = parseInt(inputElement.value);
        if (currentValue > 1) {
            inputElement.value = currentValue - 1;
        }
    }

    function increaseQuantity(productId) {
        var inputElement = document.querySelector(`input[name="num_product[${productId}]"]`);
        var currentValue = parseInt(inputElement.value);
        inputElement.value = currentValue + 1;
    }
</script>
