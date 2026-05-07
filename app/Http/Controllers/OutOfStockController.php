<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class OutOfStockController extends Controller
{

    public function index(Request $request)
{
    $query = Product::query();
    
    // Apply week filter if present
    if ($request->has('weeks') && $request->weeks != '') {
        $week = $request->weeks;
        $query->where('weeks', $week);
    }
    
    // Apply product name filter if present
    if ($request->has('product_name') && $request->product_name != '') {
        $product_name = $request->product_name;
        $query->where('product_name', $product_name);
    }

    // Ensure we only get out of stock products
    $query->where('beginning_inventory', '<=', 0);

    $totalOutstockProducts = $query->count();
    $outOfStockProducts = $query->orderBy('beginning_inventory', 'asc')->paginate(10);

    return view('out_of_stock.index', compact('outOfStockProducts', 'totalOutstockProducts'));
}

    
}
