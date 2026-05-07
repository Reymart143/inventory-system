<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CriticalProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search; 
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'LIKE', "%{$search}%");
            });
        }

        $query->where('beginning_inventory', '>', 0) 
        ->whereColumn('beginning_inventory', '<=', 'reorder_point');

        $totalCriticalProducts = $query->count();

        $criticalProducts = $query->orderBy('beginning_inventory', 'asc')->paginate(10);

        return view('critical_products.index', compact('criticalProducts', 'totalCriticalProducts'));
    }

    
}
