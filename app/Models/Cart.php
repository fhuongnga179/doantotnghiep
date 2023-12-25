<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// $orderCount = Cart::count();
// echo "Tổng số đơn hàng: " . $orderCount;

class Cart extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'product_id',
        'pty',
        'price',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    public static function countOrders()
    {
        return self::count();
    }
    public function index()
    {
        $orders = Cart::all();
        return view('orders.index', compact('orders'));
    }
}
