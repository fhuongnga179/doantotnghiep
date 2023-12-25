<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'content',
        'payment_image',
        'total',
        'status',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id', 'id');
    }
    public function showCustomers()
    {
        $customers = Customer::paginate(10); // You can adjust the number of items per page (e.g., 10)

        return view('admin.carts.detail', ['customers' => $customers]);
    }
    public function index()
{
    $orders = Cart::all();
    return view('orders.index', compact('orders'));
}
}