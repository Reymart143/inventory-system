<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
class DailyUsageController extends Controller
{
 public function index()
{
    $daily = DB::table('daily_usages')
        ->join('items', 'daily_usages.item_id', '=', 'items.id')
        ->select(
            'daily_usages.*',
            'items.item_name'
        )
        ->latest('daily_usages.created_at')
        ->paginate(10);

    return view('daily_usage.index', compact('daily'));
}
    public function create(){
         $items = DB::table('items')->get();
        return view('daily_usage.create',compact('items'));
    }
    public function getProductInfo($id)
    {
        $product = DB::table('products')
            ->where('item_id', $id)
            ->first();

        return response()->json($product);
    }
public function store(Request $request)
{
    // get product
    $product = DB::table('products')
        ->where('item_id', $request->item_id)
        ->first();

    if (!$product) {
    
        return back()->with('error', 'Product not found.');
    }

    $beginning = $product->beginning_inventory;
    $usage = $request->daily_usage;
    $remaining = $beginning - $usage;

    if ($remaining < 0) {
        
        return back()->with('error', 'Daily usage exceeds beginning inventory.');
    }

    // 1. insert daily usage
    DB::table('daily_usages')->insert([
        'item_id' => $request->item_id,
        'daily_usage' => $usage,
        'total_recent_stock' => $remaining,
        'update_by' => Auth::user()->name,
        'date' => $request->date,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 2. update product inventory
    DB::table('products')
        ->where('item_id', $request->item_id)
        ->update([
            'beginning_inventory' => $remaining,
            'updated_at' => now(),
        ]);

    return redirect()
        ->route('dailyusage.index')
        ->with('success', 'Daily Usage Added successfully.');
}
    public function edit($id)
    {
        $daily = DB::table('daily_usages')
            ->where('id', $id)
            ->first();

        $items = DB::table('items')->get();

        return view('daily_usage.edit', compact('daily', 'items'));
    }
    public function update(Request $request)
    {
        $product = DB::table('products')
            ->where('item_id', $request->item_id)
            ->first();

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        $beginning = $product->beginning_inventory;
        $usage = $request->daily_usage;

        $remaining = $beginning - $usage;

        if ($remaining < 0) {
            return back()->with('error', 'Daily usage exceeds beginning inventory.');
        }

        DB::table('daily_usages')
            ->where('id', $request->id)
            ->update([
                'item_id' => $request->item_id,
                'daily_usage' => $usage,
                'total_recent_stock' => $remaining,
                'date' => $request->date,
                'updated_at' => now(),
            ]);

        // update product inventory too
        DB::table('products')
            ->where('id', $request->item_id)
            ->update([
                'beginning_inventory' => $remaining,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('dailyusage.index')
            ->with('success', 'Daily Usage Updated Successfully.');
    }
}
