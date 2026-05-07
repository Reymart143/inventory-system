<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new ([
    //         //
    //     ]);
    // }
    public function model(array $row)
    {
        if (is_null($row[1])) {
            return null;
        }
    
        return new Product([
            'weeks' => $row[0],
            'product_name' => $row[1],
            'unit' => $row[2],
            'selling_price' => $row[3],
            'profit' => $row[4],
            'beginning_inventory_fixed' => $row[5],
            'beginning_inventory' => $row[5],
            'reorder_point' => $row[6],
            'status' => 0,
        ]);
    }
}


