<?php

namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    public function get()
    {
        return Product::with('menu')
            ->orderByDesc('id')->paginate(15);
    }


    public function insert($request)
    {
        try {
            $data = $request;
            unset($data['_token']);  // Loại bỏ khóa '_token' từ mảng dữ liệu

            Product::create($data);

            Session::flash('success', 'Thêm Sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Sản phẩm lỗi');
            Log::info($err->getMessage());
            return  false;
        }

        return  true;
    }

    public function update($request, $product)
    {
        try {
            $data = $request->input();
            unset($data['_token']);  // Loại bỏ khóa '_token' từ mảng dữ liệu
            $product->fill($data);
            $product->save();
            Session::flash('success', 'Cập nhật thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Có lỗi vui lòng thử lại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)

    {
        $product = Product::find($request->input('id'));
        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }
}
