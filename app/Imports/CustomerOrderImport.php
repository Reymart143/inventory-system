<?php

namespace App\Imports;

use App\Models\CustomerOrder;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerOrderImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new CustomerOrder([
    //         //
    //     ]);


    // }
    // public function model(array $row)
    // {
    //     if (is_null($row[1])) {
    //         return null;
    //     }
    
    //   $P_Id = Product::where('product_name',$row[1])->where('weeks',$row[0])->first();
        
    //     $beginningInventory = (int)$P_Id->beginning_inventory;
    //     $stockOutQuantity = (int)$row[2];

    //     $endingInventory = $beginningInventory - $stockOutQuantity;

    //     return new CustomerOrder([
    //         'weeks' => $row[0],
    //         'product_id' => $P_Id->id,
    //         'stockout_by' => Auth::user()->id,
    //         'stock_out_quantity' => $row[2],
    //         'ending_inventory' => $endingInventory,
    //         'type' => 0,
    //         'status' => 'Done',
    //         'date_stockout' => Carbon::now()
    //     ]);
    // }

    public function model(array $row)
    {
        if (is_null($row[1])) {
            return null;
        }
        
        $P_Id = Product::where('product_name', $row[1])->where('weeks', $row[0])->first();

        if (!$P_Id) {
            Log::warning("Product not found for name {$row[1]} and week {$row[0]}");
            return null;
        }

        dd($P_Id);
        
        $beginningInventory = (int)$P_Id->beginning_inventory;
        $stockOutQuantity = (int)$row[2];

        $endingInventory = $beginningInventory - $stockOutQuantity;

        return new CustomerOrder([
            'weeks' => $row[0],
            'product_id' => $P_Id->id,
            'stockout_by' => Auth::user()->id,
            'stock_out_quantity' => $row[2],
            'ending_inventory' => $endingInventory,
            'type' => 0,
            'status' => 'Done',
            'date_stockout' => Carbon::now()
        ]);
    }
}
