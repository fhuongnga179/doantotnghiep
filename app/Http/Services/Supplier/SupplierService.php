<?php


namespace App\Http\Services\Supplier;


use App\Models\ListSupplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SupplierService
{
    public function getParent()
    {
        return ListSupplier::where('parent_id', 0)->get();
    }

    public function show()
    {
        return ListSupplier::
            where('parent_id', 0)
            ->orderbyDesc('id')
            ->get();
    }

    public function getAll()
    {
        return ListSupplier::orderbyDesc('id')->paginate(20);
    }

    public function create($request)
    {
        try {
            ListSupplier::create([
                'name' => (string)$request->input('name'),
                'parent_id' => (int)$request->input('parent_id'),
                'description' => (string)$request->input('description'),
                'content' => (string)$request->input('content'),
                'active' => (string)$request->input('active')
            ]);

            Session::flash('success', 'Tạo Nhà Cung Cấp Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }

        return true;
    }

    public function update($request, $menu): bool
    {
        if ($request->input('parent_id') != $menu->id) {
            $menu->parent_id = (int)$request->input('parent_id');
        }

        $menu->name = (string)$request->input('name');
        $menu->description = (string)$request->input('description');
        $menu->content = (string)$request->input('content');
        $menu->active = (string)$request->input('active');
        $menu->save();

        Session::flash('success', 'Cập nhật thành công Nhà Cung Cấp');
        return true;
    }

    public function destroy($request)
    {
        $id = (int)$request->input('id');
        $menu = ListSupplier::where('id', $id)->first();
        if ($menu) {
            return ListSupplier::where('id', $id)->orWhere('parent_id', $id)->delete();
        }

        return false;
    }



    public function getProduct($supplier, $request)
    {
        $query = $supplier->produlicts()
            ->select('id', 'name', 'price', 'thumb')
            ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
}