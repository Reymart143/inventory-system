<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function import(){

        Excel::Import(new ProductsImport, request()->file('file'));

        return redirect()->back();
    }
    // public function index(Request $request)
    // {  
        // if ($request->ajax()) {
        //         $query = DB::table('products')->with(['customerorder:id,product_id,weeks,stock_out_quantity'])
        //             ->select(
        //                 'id',
        //                 'item_id',
        //                 'item_name',
        //                 'unit',
        //                 'holding_cost',
        //                 'ordering_cost',
        //                 'beginning_inventory',
        //                 'daily_usage',
        //                 'reorder_point',
        //                 'status'
        //             );
        //         if ($request->has('product_name') && $request->product_name != '') {
        //             $query->where('product_name', 'like', "%{$request->product_name}%");
        //         }
        
        //         if ($request->has('weeks') && $request->weeks != '') {
        //             $query->where('weeks', $request->weeks);
        //         }
        
        //         $totalRecords = $query->count();
        //         $totalFiltered = $totalRecords;
        
        //         if ($request->has('search.value')) {
        //             $search = $request->get('search.value');
        //             $query->where(function ($subQuery) use ($search) {
        //                 $subQuery->where('product_name', 'like', "%{$search}%")
        //                         ->orWhere('unit', 'like', "%{$search}%");
        //             });
        //             $totalFiltered = $query->count();
        //         }
        
        //         $products = $query->skip($request->input('start'))
        //             ->take($request->input('length'))
        //             ->get();
        
        //         return response()->json([
        //             'draw' => intval($request->input('draw')),
        //             'recordsTotal' => $totalRecords,
        //             'recordsFiltered' => $totalFiltered,
        //             'data' => $products->map(function($product) {
        //                 $totalStockOutQuantity = (int) \DB::table('customer_orders')
        //                     ->where('product_id', $product->id)
        //                     ->where('weeks', $product->weeks)
        //                     ->sum('stock_out_quantity');
        
        //                 $beginningInventory = (int) $product->beginning_inventory_fixed;
        //                 $endingInventory = $beginningInventory - $totalStockOutQuantity;
        
        //                 $lossProfit = (float) $endingInventory * (float) $product->profit;
        //                 $potentialProfit = (float) $totalStockOutQuantity * (float) $product->profit;

        //                 if($lossProfit < 0){
        //                     if ($lossProfit < 0 || $potentialProfit < 0) {
                                
        //                         $actualProfit = $lossProfit + $potentialProfit;
        //                         $actualProfit = abs($actualProfit); 
        //                     } else {
                                
        //                         $actualProfit = $lossProfit -  $potentialProfit;
        //                     }
        //                 }else{
                         
        //                     $actualProfit = $potentialProfit;
        //                 }
        //                 return [
        //                     'id' => $product->id,
        //                     'product_name' => $product->product_name,
        //                     'unit' => $product->unit,
        //                     'selling_price' => $product->selling_price,
        //                     'profit' => number_format($product->profit, 2),
        //                     'beginning_inventory' => $product->beginning_inventory,
        //                     'beginning_inventory_fixed' => $product->beginning_inventory_fixed,
        //                     'weeks' => $product->weeks,
        //                     'reorder_point' => $product->reorder_point,
        //                     'status' => $product->status,
        //                     'supplier_cost' => number_format(abs($product->selling_price - $product->profit), 2),
        //                     'customer_order' => $totalStockOutQuantity > 0 ? $totalStockOutQuantity : '-- --',
        //                     'ending_inventory' => $endingInventory > 0 ? $endingInventory : $endingInventory,
        //                     'lossProfit' => $endingInventory ? number_format($lossProfit, 2) :number_format($lossProfit, 2),
        //                     'potentialProfit' => $totalStockOutQuantity ? number_format($potentialProfit, 2) :number_format($potentialProfit, 2),
        //                     'actualProfit' => number_format($actualProfit, 2),
        //                     'action' => '
        //                         <input type="hidden" id="account_' . $product->id . '" value="' . $product->unit . '" data-name="' . $product->product_name . '" />
        //                         <button type="button" name="edit" onclick="editProductDetails(' . $product->id . ')" class="action-button accept btn btn-info btn-sm" style="padding: 2mm 3mm; font-size: 10px;">
        //                             <i class="fa fa-edit"></i>
        //                             <span class="action-text" style="font-size:10px">Edit</span>
        //                         </button>
        //                         <button type="button" name="softDelete" onclick="deleteProductDetails(' . $product->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="padding: 2mm 4mm; font-size: 10px;">
        //                             <i class="fa fa-trash"></i>
        //                             <span class="action-text" style="font-size:10px">Delete</span>
        //                         </button>
        //                     '
        //                 ];
        //             }),
        //         ]);
        //     }
    
        // return view('products.index');
        public function index(Request $request)
        {  
            if ($request->ajax()) {

                $query = DB::table('products')
                    ->join('items', 'products.item_id', '=', 'items.id')

                    // get total stock out / daily usage
                    ->leftJoin('stock_ins', 'products.item_id', '=', 'stock_ins.item_id')

                    ->select(
                        'products.id',
                        'products.item_id',
                        'items.item_name',
                        'products.unit',
                        'products.holding_cost',
                        'products.ordering_cost',
                        'products.beginning_inventory',
                        'products.reorder_point',
                        'products.status',

                        DB::raw('COALESCE(SUM(stock_ins.daily_usage), 0) as daily_usage'),

                        DB::raw('
                            (products.beginning_inventory - 
                            COALESCE(SUM(stock_ins.daily_usage), 0)
                            ) as ending_inventory
                        ')
                    )

                    ->groupBy(
                        'products.id',
                        'products.item_id',
                        'items.item_name',
                        'products.unit',
                        'products.holding_cost',
                        'products.ordering_cost',
                        'products.beginning_inventory',
                        'products.reorder_point',
                        'products.status'
                    );

                return datatables()->of($query)

                    ->addColumn('action', function($row){
                        return '
                            <button class="btn btn-sm btn-primary">
                                Edit
                            </button>
                        ';
                    })

                    ->make(true);
            }

            return view('products.index');
        }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_product(Request $request)
    {
        $ProductForm              = Product::insert([
            'product_name'        => $request->product_name,
            'unit'                => $request->unit,
            'weeks'               => $request->weeks,
            'selling_price'       => $request->selling_price,
            'beginning_inventory' => $request->beginning_inventory,
            'beginning_inventory_fixed' => $request->beginning_inventory,
            'profit'              => $request->profit,
            'reorder_point'       => $request->reorder_point,
        ]);
       
        if ($ProductForm != null){
            return response()->json([
                'status'=>200,
                'message'=> 'Successfully Added House',
                
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'message'=> 'This site can’t be reached' ,
                
            ]);
        }
    }
    public function edit_product($id)
    {
       
        if(request()->ajax())
        {
            $data = Product::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }
    
    public function update_product(Request $request)
    {       
        $Updateform = Product::where('id', $request->id)->update([
            'product_name'        => $request->product_name,
            'unit'                => $request->unit,
            'weeks'               => $request->weeks,
            'selling_price'       => $request->selling_price,
            'beginning_inventory' => $request->beginning_inventory,
            'beginning_inventory_fixed' => $request->beginning_inventory,
            'profit'              => $request->profit,
            'reorder_point'       => $request->reorder_point,
        ]);
        
        return response()->json([
            'status'=> 200,
            'message'=>'Success Update Info!!'
        ]);

    }
    public function delete($id){
        return view('confirm-delete', ['id'=> $id]);
    }
    public function delete_product($id)
    {
        try{
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['message'=>'Product Deleted Sucessfully']);
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['error' => 'Product not found'], 404);
        }
        catch(\Exception $e){
            return response()->json(['error'=> 'An error occured while deleting the Product'], 500);
        }
    }
    public function getProductNames()
    {
        $Pname = select('product_name')->distinct()->orderBy('product_name')->pluck('product_name');
        return response()->json($Pname);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
