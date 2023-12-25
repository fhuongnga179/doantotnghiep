<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\CreateFormRequest;
use App\Http\Services\Supplier\SupplierService;
use App\Models\ListSupplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
    public $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }
    public function create(){
        return view('admin.supplier.add', [
            'title' => 'Thêm Danh Mục Mới',
            'supplier' => $this->supplierService->getParent()
        ]);
    }
    public function store(CreateFormRequest $request)
    {
        $this->supplierService->create($request);

        return redirect()->back();
    }
    public function show_index(){

        return view('admin.supplier.list', [
            'title' => 'Danh Sách Nhà Cung Cấp',
            'menus' => $this->supplierService->getAll()
        ]);
    }
    public function show(ListSupplier $menu)
    {
        return view('admin.supplier.edit', [
            'title' => 'Chỉnh Sửa Nhà Cung Cấp: ' . $menu->name,
            'menu' => $menu,
            'menus' => $this->supplierService->getParent()
        ]);
    }
    public function update(ListSupplier $menu, CreateFormRequest $request)
    {
        $this->supplierService->update($request, $menu);

        return Redirect::to('supplier/list');
    }

    public function destroy(Request $request): JsonResponse
    {
        $result = $this->supplierService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công danh mục'
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

}