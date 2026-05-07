<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderApproval;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomerOrderImport;


class CustomerOrdersController extends Controller
{

    public function index(Request $request)
{
    $Pname = Product::selectRaw('MIN(id) as id, product_name')
    ->groupBy('product_name') 
    ->orderBy('product_name')
    ->get();

    if ($request->ajax()) {
        $stockoutData = CustomerOrder::with(['product', 'user'])
            ->orderBy('created_at', 'asc')
            ->select('id', 'stockout_by', 'stock_out_quantity', 'product_id', 'ending_inventory', 'type', 'proof_receipt', 'reference_no', 'status', 'date_stockout','weeks')
            ->get();

        return datatables()->of($stockoutData)->addIndexColumn()
            ->addColumn('product_name', function ($data) {
                return $data->product ? $data->product->product_name : 'N/A'; 
            })
            ->addColumn('stockout_by', function ($data) {
                return $data->user->name; 
            })
            ->addColumn('unit', function ($data) {
                return $data->product ? $data->product->unit : 'N/A'; 
            })
            ->make(true);
    }

    return view('customer_order.index', compact('Pname'));
}
    // public function stockout_product(Request $request)
    // {
    
    //     $data = $request->input('stockoutProductform');

    //     $userId = auth()->id();

    
    //     foreach ($data as $item) {
    //         $product = Product::find($item['product_id']);
    
    //         if ($item['type'] == 0) {
    //             if ($product) {
    //                 if ($product->beginning_inventory < $item['stockout']) {
    //                     $exceededProducts[] = $product->name; 
    //                 } else {
    //                     $product->beginning_inventory -= $item['stockout'];
    //                     $product->save();
    
    //                     CustomerOrder::create([
    //                         'product_id' => $item['product_id'],
    //                         'stock_out_quantity' => $item['stockout'],
    //                         'status' => 'Done',
    //                         'weeks' => $item['weeks'],
    //                         'type' => $item['type'],
    //                         'ending_inventory' => $product->beginning_inventory,
    //                         'stockout_by' => $userId,
    //                         'date_stockout' => Carbon::now()
    //                     ]);
    //                 }
    //             }
    //         } else {
    //             // Handle other types (e.g., with proof_receipt)
    //             // if ($request->hasFile('proof_receipt')) {
    //             //     $imageName = time() . '.' . $request->proof_receipt->extension();
    //             //     $request->proof_receipt->move(public_path('storage/images'), $imageName);
    //             //     $validated['proof_receipt'] = 'storage/images/' . $imageName;
    //             // }
    //         }
    //     }
    
    // return response()->json([
    //     'status' => 200,
    //     'message' => 'Stock out product Successfully Saved'
    // ], 200);
    // }
    public function stockout_product(Request $request)
    {
        $data = $request->input('stockoutProductform');
    
        $userId = auth()->id();
        foreach ($data as $item) {
            $product = Product::find($item['product_id']);
            if ($item['type'] == 0) {
                if ($product) {
                    $product->beginning_inventory -= $item['stockout'];
                    $product->save();

                        CustomerOrder::create([
                            'product_id' => $item['product_id'],
                            'stock_out_quantity' => $item['stockout'],
                            'status' => 'Done',
                            'weeks' => $item['weeks'],
                            'type' => $item['type'],
                            'ending_inventory' => $product->beginning_inventory,
                            'stockout_by' => $userId,
                            'date_stockout' => Carbon::now()
                        ]);
                }
            } else {
                if ($product) {
                    CustomerOrderApproval::create([
                        'product_id' => $item['product_id'],
                        'stock_out_quantity' => $item['stockout'],
                        'status' => 'Pending',
                        'weeks' => $item['weeks'],
                        'stockout_by' => $userId,
                        'reference_no' => $item['reference_no'],
                        'date_stockout' => Carbon::now()
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Stock out product successfully saved'
        ], 200);
    }
    public function CustomerOrderImport(){

        Excel::Import(new CustomerOrderImport, request()->file('file'));

        return redirect()->back();
    }
    
}
