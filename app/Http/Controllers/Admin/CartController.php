<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    protected $cart;
    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        return view('admin.carts.customer', [
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'customers' => $this->cart->getCustomer()
        ]);
    }

    public function show(Customer $customer)
    {
        $carts = $this->cart->getProductForCart($customer);

        return view('admin.carts.detail', [
            'title' => 'Chi Tiết Đơn Hàng: ' . $customer->name,
            'customer' => $customer,
            'carts' => $carts
        ]);
    }

    public function cancel($id)
    {
        // Lấy đơn hàng từ cơ sở dữ liệu
        $cart = Cart::findOrFail($id);

        // Kiểm tra xem đơn hàng đã được hủy hay chưa
        if ($cart->status == 'pending' || $cart->status == 'approved') {
            // Cập nhật trạng thái đơn hàng thành 'canceled'
            $cart->update(['status' => 'canceled']);
            // Thực hiện các bước khác nếu cần
            Session::flash('success', 'Đơn hàng #' . $cart->id . ' đã được hủy.');
        } else {
            Session::flash('error', 'Không thể hủy đơn hàng #' . $cart->id . ' do đã có trạng thái khác.');
        }

        return redirect()->route('carts.index');
    }
}