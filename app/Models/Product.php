<?php

namespace App\Models;
use Illuminate\Http\Request; // Add this line
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'content',
        'menu_id',
        'price',
        'active',
        'thumb',
        'supplier_id',
        'warranty_period',
        'quantity',
    ];

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')
            ->withDefault(['name' => '']);
    }
    public function supplier()
    {
        return $this->belongsTo(ListSupplier::class);
    }
}