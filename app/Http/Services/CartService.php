<?php


namespace App\Http\Services;


use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }

        $carts = Session::get('carts');
        if (is_null($carts)) {
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }

        $exists = Arr::exists($carts, $product_id);
        if ($exists) {
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts', $carts);
            return true;
        }

        $carts[$product_id] = $qty;
        Session::put('carts', $carts);

        return true;
    }


    public function getProduct()
    {
        $carts = Session::get('carts');
        if (is_null($carts)) return [];

        $productId = array_keys($carts);
        return Product::select('id', 'name', 'price', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }

    public function update($request)
    {
        Session::put('carts', $request->input('num_product'));

        return true;
    }

    public function remove($id)
    {
        $carts = Session::get('carts');
        unset($carts[$id]);

        Session::put('carts', $carts);
        return true;
    }

    public function addCart($request)
    {
        try {
            DB::beginTransaction();

            $carts = Session::get('carts');

            if (is_null($carts)) {
                Session::flash('error', 'Giỏ hàng trống');
                return false;
            }

            $name = $request->input('name');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $email = $request->input('email');
            $content = $request->input('content');
            $payment_image = null;

            // Kiểm tra và lưu hình ảnh thanh toán nếu có
            if ($request->hasFile('payment_image')) {
                $paymentImage = $request->file('payment_image');
                $payment_image = $paymentImage->store('payment_images', 'public');
            }

            if (empty($name) || empty($phone) || empty($address) || empty($email) || empty($content)) {
                Session::flash('error', 'Vui lòng nhập đầy đủ thông tin khách hàng và chọn phương thức thanh toán');
                return false;
            }

            // Create a new customer with total initially set to 0
            $customer = Customer::create([
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'email' => $email,
                'content' => $content,
                'payment_image' => $payment_image,
                'total' => 0,
            ]);

            // Update the customer's information and calculate the total
            $productsInCart = $this->infoProductCart($carts, $customer->id, $payment_image);

            DB::commit();
            Session::flash('success', 'Đơn hàng của bạn đã được gửi đi');

            #Queue
            SendMail::dispatch($email, $name, $phone, $address, $content, $payment_image, $productsInCart)->delay(now()->addSeconds(2));

            Session::forget('carts');
        } catch (\Exception $err) {
            dd($err->getMessage());
            DB::rollBack();
            Session::flash('error', 'Đặt Hàng Lỗi, Vui lòng thử lại sau');
            return false;
        }

        return true;
    }

    protected function infoProductCart($carts, $customer_id,  $payment_image)
    {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'thumb', 'quantity')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];
        $total = 0;

        foreach ($products as $product) {
            $quantity = $carts[$product->id];
            $price = $product->price;
            $total += $price * $quantity;

            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'pty' => $quantity,
                'price' => $price,
            ];
            Product::where('id', $productId)->update([
                'quantity' => $product->quantity - $quantity,
            ]);
        }
        // Update the customer's information, including the total
        Customer::where('id', $customer_id)->update([
            'total' => $total,
            'payment_image' => $payment_image,
        ]);

        // Xóa các sản phẩm cũ trong giỏ hàng của khách hàng
        Cart::where('customer_id', $customer_id)->delete();

        // Thêm các sản phẩm mới vào giỏ hàng của khách hàng
        Cart::insert($data);

        return $products;
    }




    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(15);
    }

    public function getProductForCart($customer)
    {
        return $customer->carts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }
}
