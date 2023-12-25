<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
use App\Models\ListSupplier;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return view('admin.product.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => $this->productService->get(),
        ]);
    }

    public function create()
    {
        $menus = $this->productService->getMenu(); // Lấy danh sách menu (nếu có)
        $list_suppliers = ListSupplier::all(); // Lấy danh sách nhà cung cấp

        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm Mới',
            'menus' => $menus,
            'list_suppliers' => $list_suppliers, // Truyền danh sách nhà cung cấp vào view
        ]);
    }

    public function store(ProductRequest $request)
    {
        try {
            // Lấy dữ liệu từ request
            $data = $request->validated();
            $file = $request->file('thumb');

            $data['name'] = $request->input('name');
            $data['description'] = $request->input('description', ''); // Provide a default value for description if not present in the request

            $data['content'] = $request->input('content');
            $data['menu_id'] = $request->input('menu_id');
            $data['price'] = $request->input('price');
            $data['active'] = $request->input('active');
            if ($file) {
                $path = $file->store('uploads/image', 'public');
                $data['thumb'] = $path;
            }
            $data['supplier_id'] = $request->input('supplier_id', '');
            $data['warranty_period'] = $request->input('warranty_period');
            $data['quantity'] = $request->input('quantity');

            // Gọi service để lưu sản phẩm
            $this->productService->insert($data);

            // Redirect hoặc thực hiện các hành động khác sau khi thêm sản phẩm
            return redirect()->back();
        } catch (\Exception $e) {
            // Log the exception
            Log::info('Validated Data:', $data);
            Log::info('Request Data:', $request->all());


            // Return to the form with an error message
            return redirect()->back()->with('error', 'There was an error while adding the product.');
        }
    }




    public function show(Product $product)
    {
        $list_suppliers = ListSupplier::all(); // Lấy danh sách nhà cung cấp

        return view('admin.product.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm',
            'product' => $product,
            'menus' => $this->productService->getMenu(),
            'listsup' => $list_suppliers,
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $result = $this->productService->update($request, $product);

        if ($result) {
            return redirect('/admin/products/list');
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->productService->delete($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công sản phẩm'
            ]);
        }

        return response()->json(['error' => true]);
    }
}
