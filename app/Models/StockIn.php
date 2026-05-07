<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'added_stock',
        'update_by',
        'weeks',
        'total_recent_stock'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'update_by');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Correct foreign key
    }
}
