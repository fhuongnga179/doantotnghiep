<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;

class AdminCartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function approve($id)
    {
        $cart = Customer::findOrFail($id);

        // Loại bỏ điều kiện kiểm tra trạng thái
        $cart->update(['status' => 'đã xác nhận']);
        Session::flash('success', 'Đơn hàng #' . $cart->id . ' đã được duyệt.');

        return redirect()->route('carts.index');
    }
    public function refuse($id)
    {
        $cart = Customer::findOrFail($id);

        // Loại bỏ điều kiện kiểm tra trạng thái
        $cart->update(['status' => 'đã từ chối']);
        Session::flash('success', 'Đã từ chối đơn hàng #' . $cart->id);

        return redirect()->route('carts.index');
    }



    // Các hàm xử lý khác...
}
