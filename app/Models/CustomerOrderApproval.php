<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'stockout_by',
        'stock_out_quantity',
        'image',
        'reference_no',
        'status',
        'date_stockout',
        'weeks'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'stockout_by'); 
    }
  
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Correct foreign key
    }
}
