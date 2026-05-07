<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderApproval;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class CustomerController extends Controller
{
    public function transactionIndex(Request $request){

        $Pname = Product::selectRaw('MIN(id) as id, product_name')
        ->groupBy('product_name') 
        ->orderBy('product_name')
        ->get();
        if ($request->ajax()) {
            $stockoutData = CustomerOrderApproval::with(['product', 'user'])
                ->orderBy('created_at', 'asc')
                ->where('stockout_by',Auth::user()->id)
                ->select('id', 'stockout_by', 'stock_out_quantity', 'product_id', 'image', 'reference_no', 'status', 'date_stockout','weeks')
                ->get();
    
            return datatables()->of($stockoutData)->addIndexColumn()
                ->addColumn('product_name', function ($data) {
                    return $data->product ? $data->product->product_name : 'N/A'; 
                })
                ->addColumn('stockout_by', function ($data) {
                    return $data->user->name; 
                })
                ->make(true);
        }
        return view('customer.transactions', compact('Pname'));
    }
    public function listcustomerOrdered(){

        $custOrderApproval = CustomerOrderApproval::orderBy('status','desc')->paginate(20);
        return view('customer.list_customer',compact('custOrderApproval'));
    }
    public function approveCustomerOrder(Request $request, $id)
    {
        // Find the order to approve
        $orderApproval = CustomerOrderApproval::find($id);
    
        if ($orderApproval) {
            // Find the product associated with the order
            $product = Product::where('id', $orderApproval->product_id)
            ->where('weeks', $orderApproval->weeks)
            ->first();

    
            if ($product) {
                // Decrease the product's beginning inventory
                $product->beginning_inventory -= $orderApproval->stock_out_quantity;
                $product->save(); // Save the updated product inventory
    
                // Create a new customer order record
                CustomerOrder::create([
                    'product_id' => $orderApproval->product_id,
                    'stock_out_quantity' => $orderApproval->stock_out_quantity,
                    'status' => 'Done', // Mark as approved
                    'weeks' => $orderApproval->weeks,
                    'ending_inventory' => $product->beginning_inventory, // Updated inventory after stock out
                    'stockout_by' => auth()->user()->id, // Or any user identifier
                    'date_stockout' => Carbon::now(), // Current date
                ]);
    
                // Update the order status in the approval table
                $orderApproval->status = 'Done';
                $orderApproval->save();
    
                // Redirect back with a success message
                return redirect()->back()->with('success', 'The quantity has been deducted from the product successfully.');
            } else {
                return redirect()->back()->with('error', 'Product not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }
    
    public function rejectCustomerOrder(Request $request, $id)
    {
        // Find the order to reject
        $orderApproval = CustomerOrderApproval::find($id);

        if ($orderApproval) {
            // Update the status of the order to "Reject"
            $orderApproval->status = 'Reject';
            $orderApproval->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Order rejected successfully.');
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }

}
