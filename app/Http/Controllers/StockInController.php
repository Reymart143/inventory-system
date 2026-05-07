<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;

class StockInController extends Controller
{

    public function index(Request $request)
    {
        $Pname = Product::selectRaw('MIN(id) as id, product_name')
        ->groupBy('product_name') 
        ->orderBy('product_name')
        ->get();
        if ($request->ajax()) {
            $stockinData = StockIn::with(['product', 'user'])
                ->orderBy('created_at', 'asc')
                ->select('id', 'added_stock', 'update_by', 'product_id','created_at','total_recent_stock','weeks')
                ->get();
        
            return datatables()->of($stockinData)->addIndexColumn()
                ->addColumn('product_name', function ($data) {
                    return $data->product->product_name;
                })
                ->addColumn('updated_by_name', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('position', function ($data) {
                    return $data->user->role;
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('F j, Y \a\t g:i A') : 'N/A'; // Format the date
                })
                ->make(true);
        }
    
        return view('stock_in.index', compact('Pname'));
    }
    
    public function getProductDetails($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'unit' => $product->unit,
                'selling_price' => $product->selling_price,
                'beginning_inventory' => $product->beginning_inventory,
                'profit' => $product->profit,
                'reorder_point' => $product->reorder_point
            ]);
        }
    
        return response()->json(['error' => 'Product not found'], 404);
    }
    public function stockin_product(Request $request)
    {
   
        $data = $request->input('stockinProductform');
        $userId = auth()->id();
   
        foreach ($data as $item) {
            $product = Product::find($item['product_id']);
            
            if ($product) {
                $product->beginning_inventory_fixed += $item['stock'];
                $product->save(); 
                
                StockIn::create([
                    'product_id' => $item['product_id'],
                    'added_stock' => $item['stock'],
                    'weeks' => $item['weeks'],
                    'total_recent_stock' => $product->beginning_inventory_fixed, 
                    'update_by' => $userId, 
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Stocks added successfully.']);
    }

}


