<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'unit',
        'weeks',
        'selling_price',
        'beginning_inventory',
        'beginning_inventory_fixed',
        'profit',
        'reorder_point',
        'status',
    ];  
    public function stockin()
    {
        return $this->hasMany(StockIn::class, 'product_id');
    }
    public function customerorder()
    {
        return $this->hasMany(CustomerOrder::class, 'product_id');
    }
    public function customerOrders()
    {
        return $this->hasMany(CustomerOrder::class);
    }
}
