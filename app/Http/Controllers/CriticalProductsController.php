<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CriticalProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::join('items', 'products.item_id', '=', 'items.id')
            ->select(
                'products.*',
                'items.item_name'
            );

        // SEARCH
        if ($request->has('search') && $request->search != '') {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('items.item_name', 'LIKE', "%{$search}%");

            });
        }

        // CRITICAL PRODUCTS
        $query->where('products.beginning_inventory', '>', 0)
            ->whereColumn('products.beginning_inventory', '<=', 'products.reorder_point');

        $totalCriticalProducts = $query->count();

        $criticalProducts = $query
            ->orderBy('products.beginning_inventory', 'asc')
            ->paginate(10);

        return view(
            'critical_products.index',
            compact('criticalProducts', 'totalCriticalProducts')
        );
    }
}
