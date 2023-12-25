<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Menu;
use App\Services\SalesService;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index(Request $request)
    {
        // thống kê
        $product_count = Product::count();
        $order_count = Cart::count();
        $order_sum = Cart::sum('price'); // Sửa đổi đây để tính tổng giá trị của cột 'price'
        $menu_count = Menu::count();

        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->subMonth())); // Default to one month ago
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()));

        $sales = Cart::whereBetween('created_at', [$startDate, $endDate])->sum('price');

        // vẽ biểu đồ
        $salesData = Cart::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(price) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();


        return view('admin.home', compact(
            'product_count',
            'order_count',
            'order_sum',
            'menu_count',
            'startDate',
            'endDate',
            'sales',
            'salesData'
        ), [
            'title' => 'Trang Quản Trị Admin'
        ]);
        dd($salesData);
    }
}