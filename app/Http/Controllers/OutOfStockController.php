<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class OutOfStockController extends Controller
{

    public function index(Request $request)
{
    $query = Product::join('items', 'products.item_id', '=', 'items.id')
        ->select(
            'products.*',
            'items.item_name'
        );



    // Ensure we only get out of stock products
    $query->where('beginning_inventory', '<=', 0);

    $totalOutstockProducts = $query->count();
    $outOfStockProducts = $query->orderBy('beginning_inventory', 'asc')->paginate(10);

    return view('out_of_stock.index', compact('outOfStockProducts', 'totalOutstockProducts'));
}

    
}
