<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use DB;
 use Carbon\Carbon;

class ReportsController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Get products with total stock out quantities aggregated per product
    //     $products = Product::select(
    //             'products.id',
    //             'products.product_name',
    //             'products.unit',
    //             'products.selling_price',
    //             'products.profit',
    //             'products.beginning_inventory',
    //             'products.beginning_inventory_fixed',
    //             'products.weeks',
    //             'products.reorder_point',
    //             'products.status',
    //             \DB::raw('COALESCE(SUM(customer_orders.stock_out_quantity), 0) as total_stock_out_quantity') // Use COALESCE to handle NULL values
    //         )
    //         ->leftJoin('customer_orders', 'products.id', '=', 'customer_orders.product_id') // Join to get stock out quantities
    //         ->groupBy('products.id', 'products.product_name', 'products.unit', 'products.selling_price', 'products.profit', 'products.beginning_inventory', 'products.beginning_inventory_fixed', 'products.weeks', 'products.reorder_point', 'products.status')
    //         ->get();
    
    //     // Initialize an array to hold profit data
    //     $profitData = [];
    
    //     // Process each product to calculate profits
    //     foreach ($products as $product) {
    //         $totalStockOutQuantity = (int) $product->total_stock_out_quantity;
    
    //         $beginningInventory = (int) $product->beginning_inventory_fixed;
    //         $endingInventory = $beginningInventory - $totalStockOutQuantity;
    
    //         // Calculate loss and potential profit
    //         $lossProfit = (float) $endingInventory * (float) $product->profit;
    //         $potentialProfit = (float) $totalStockOutQuantity * (float) $product->profit;
    
    //         // Initialize week data if not already set
    //         if (!isset($profitData[$product->weeks])) {
    //             $profitData[$product->weeks] = [
    //                 'week' => $product->weeks,
    //                 'total_loss' => 0,
    //                 'total_potential' => 0,
    //             ];
    //         }
    
    //         // Accumulate negative loss profit into total_loss
    //         if ($lossProfit < 0) {
    //             $profitData[$product->weeks]['total_loss'] += $lossProfit; // Add only negative values
    //         }
    
    //         // Accumulate potential profit
    //         $profitData[$product->weeks]['total_potential'] += $potentialProfit;
    //     }
    
    //     // Pass the profit data to the view using compact
    //     return view('reports.index', compact('profitData'));
    // }
    
    public function index(Request $request)
    {
        // Get products with total stock out quantities aggregated per product
        $products = Product::select(
                'products.id',
                'products.product_name',
                'products.unit',
                'products.selling_price',
                'products.profit',
                'products.beginning_inventory',
                'products.beginning_inventory_fixed',
                'products.weeks',
                'products.reorder_point',
                'products.status',
                \DB::raw('COALESCE(SUM(customer_orders.stock_out_quantity), 0) as total_stock_out_quantity')
            )
            ->leftJoin('customer_orders', 'products.id', '=', 'customer_orders.product_id') 
            ->groupBy('products.id', 'products.product_name', 'products.unit', 'products.selling_price', 'products.profit', 'products.beginning_inventory', 'products.beginning_inventory_fixed', 'products.weeks', 'products.reorder_point', 'products.status')
            ->get();

        $profitData = [];

        foreach ($products as $product) {
            $totalStockOutQuantity = (int) $product->total_stock_out_quantity;

            $beginningInventory = (int) $product->beginning_inventory_fixed;
            $endingInventory = $beginningInventory - $totalStockOutQuantity;

            // Calculate loss and potential profit
            $lossProfit = (float) $endingInventory * (float) $product->profit;
            $potentialProfit = (float) $totalStockOutQuantity * (float) $product->profit;
            if($lossProfit < 0){
                if ($lossProfit < 0 || $potentialProfit < 0) {
                    
                    $actualProfit = $lossProfit + $potentialProfit;
                    $actualProfit = abs($actualProfit); 
                } else {
                    
                    $actualProfit = $lossProfit -  $potentialProfit;
                }
            }else{
             
                $actualProfit = $potentialProfit;
            }
            if (!isset($profitData[$product->weeks])) {
                $profitData[$product->weeks] = [
                    'week' => $product->weeks,
                    'total_loss' => 0,
                    'total_potential' => 0,
                    'total_actualprofit' => 0,
                ];
            }

            if ($lossProfit < 0) {
                $profitData[$product->weeks]['total_loss'] += $lossProfit; // Add only negative values

                // Accumulate potential profit only for negative loss profit
                $profitData[$product->weeks]['total_potential'] += $potentialProfit; // Add only when loss is negative
            }

            $profitData[$product->weeks]['total_actualprofit'] += $actualProfit; // Add only when loss is negative
        }

        // Pass the profit data to the view using compact
    return view('reports.index', compact('profitData'));
}

    // public function indexABC(Request $request)
    // {
    //     $products = Product::with(['customerOrders' => function ($query) {
    //         $query->select('product_id', DB::raw('SUM(stock_out_quantity) as total_stock_out_quantity'))
    //             ->groupBy('product_id');
    //     }])->get();

    //     $productData = [];
    //     $grandTotalProfit = 0; 
    //     foreach ($products as $product) {
    //         $totalStockOutQuantity = $product->customerOrders->sum('total_stock_out_quantity') ?: 0;

    //         $beginningInventory = (int) $product->beginning_inventory_fixed;
    //         $endingInventory = $beginningInventory - $totalStockOutQuantity;

    //         $lossProfit = (float) $endingInventory * (float) $product->profit; 
    //         $potentialProfit = (float) $totalStockOutQuantity * (float) $product->profit; 

    //         $actualProfit = 0; 
    //         if($lossProfit < 0){
    //             if ($lossProfit < 0 || $potentialProfit < 0) {    
    //                 $actualProfit = $lossProfit + $potentialProfit;
    //                 $actualProfit = abs($actualProfit); 
    //             } else {
                    
    //                 $actualProfit = $lossProfit -  $potentialProfit;
    //             }
    //         }else{
            
    //             $actualProfit = $potentialProfit;
    //         }
        
    //         if (!isset($productData[$product->product_name])) {
    //             $productData[$product->product_name] = [
    //                 'product_name' => $product->product_name,
    //                 'total_actual_profit' => $actualProfit, 
    //             ];
    //         } else {
    //             $productData[$product->product_name]['total_actual_profit'] += $actualProfit; 
    //         }
    //         // Add to the grand total profit
    //     $grandTotalProfit += $actualProfit;
    //     }
    //     usort($productData, function($a, $b) {
    //         return $b['total_actual_profit'] <=> $a['total_actual_profit'];
    //     });

    //     $productData = array_values($productData);
    //     return view('abc.index', compact('productData','grandTotalProfit'));
    // }
    // CONTROLLER

        public function abc_analysis()
        {
 $products = DB::table('products')
    ->join('items', 'products.item_id', '=', 'items.id')
    ->leftJoin('daily_usages', 'products.item_id', '=', 'daily_usages.item_id')
    ->select(
        'products.item_id',
        'items.item_name',
        'items.item_cost',
        DB::raw('COALESCE(SUM(daily_usages.daily_usage), products.daily_usage, 0) as total_daily_usage')
    )
    ->groupBy(
        'products.item_id',
        'items.item_name',
        'items.item_cost',
        'products.daily_usage'
    )
    ->get();

$productData = [];

foreach ($products as $product) {
    $dailyUsage = (float) $product->total_daily_usage;
    $itemCost = (float) $product->item_cost;

    $itemValue = $dailyUsage * $itemCost;

    $productData[] = [
        'item_id' => $product->item_id,
        'item_name' => $product->item_name,
        'daily_usage' => $dailyUsage,
        'item_cost' => $itemCost,
        'item_value' => $itemValue,
    ];
}

$totalItemValue = collect($productData)->sum('item_value');

usort($productData, function ($a, $b) {
    return $b['item_value'] <=> $a['item_value'];
});

$cumulative = 0;

foreach ($productData as &$item) {
    $individualPercentage = $totalItemValue > 0
        ? ($item['item_value'] / $totalItemValue) * 100
        : 0;

    $cumulative += $individualPercentage;

    if ($cumulative <= 80) {
        $classification = 'A';
    } elseif ($cumulative <= 95) {
        $classification = 'B';
    } else {
        $classification = 'C';
    }

    $item['individual_percentage'] = round($individualPercentage, 2);
    $item['cumulative_percentage'] = round($cumulative, 2);
    $item['classification'] = $classification;
}

unset($item);
            return view('abc.index', compact('productData'));
        }
    // public function indexABC(Request $request)
    // {
    //     $products = Product::with(['customerOrders' => function ($query) {
    //         $query->select('product_id', DB::raw('SUM(stock_out_quantity) as total_stock_out_quantity'))
    //             ->groupBy('product_id');
    //     }])->get();

    //     $productData = [];
    //     $grandTotalProfit = 0; 

    //     foreach ($products as $product) {
    //         $totalStockOutQuantity = $product->customerOrders->sum('total_stock_out_quantity') ?: 0;

    //         $beginningInventory = (int) $product->beginning_inventory_fixed;
    //         $endingInventory = $beginningInventory - $totalStockOutQuantity;

    //         $lossProfit = (float) $endingInventory * (float) $product->profit; 
    //         $potentialProfit = (float) $totalStockOutQuantity * (float) $product->profit; 

    //         $actualProfit = 0; 
    //         if ($lossProfit < 0) {
    //             if ($lossProfit < 0 || $potentialProfit < 0) {    
    //                 $actualProfit = $lossProfit + $potentialProfit;
    //                 $actualProfit = abs($actualProfit); 
    //             } else {
    //                 $actualProfit = $lossProfit - $potentialProfit;
    //             }
    //         } else {
    //             $actualProfit = $potentialProfit;
    //         }

    //         if (!isset($productData[$product->product_name])) {
    //             $productData[$product->product_name] = [
    //                 'product_name' => $product->product_name,
    //                 'total_actual_profit' => $actualProfit,
    //                 'rowspan' => 1, 
    //             ];
    //         } else {
    //             $productData[$product->product_name]['total_actual_profit'] += $actualProfit; 
    //             $productData[$product->product_name]['rowspan']++; 
    //         }
    //         $grandTotalProfit += $actualProfit;
    //     }
    //     usort($productData, function($a, $b) {
    //         return $b['total_actual_profit'] <=> $a['total_actual_profit'];
    //     });
    //     foreach ($productData as &$data) {
    //         $data['percentage_value_of_total_profit'] = $grandTotalProfit > 0
    //             ? ($data['total_actual_profit'] / $grandTotalProfit) * 100
    //             : 0; 
    //     }
    //     $cumulativePercentage = 0; 
    //     foreach ($productData as &$data) {
    //         $cumulativePercentage += $data['percentage_value_of_total_profit'];
    //         $data['cumulative_percentage'] = $cumulativePercentage;
    //     }

    //     $classificationLimits = [
    //         'A' => 73.24,
    //         'B' => 20.86,
    //         'C' => 5.90,
    //     ];

    //     $currentCategory = 'A';
    //     $currentSum = 0;

    //     foreach ($productData as &$data) {
          
    //         if ($currentCategory === 'A') {
    //             $currentSum += $data['percentage_value_of_total_profit'];
    //             $data['classification'] = 'A';
    //             if ($currentSum >= $classificationLimits['A']) {
    //                 $currentCategory = 'B';
    //                 $currentSum = 0; 
    //             }
    //         } elseif ($currentCategory === 'B') {
    //             $currentSum += $data['percentage_value_of_total_profit'];
    //             $data['classification'] = 'B';
    //             if ($currentSum >= $classificationLimits['B']) {
    //                 $currentCategory = 'C'; 
    //                 $currentSum = 0; 
    //             }
    //         } elseif ($currentCategory === 'C') {
    //             $currentSum += $data['percentage_value_of_total_profit'];
    //             $data['classification'] = 'C'; 
    //         }
    //         if ($data['classification'] === 'A') {
    //             $data['indicated_percentage'] = '73.24%'; 
    //         } elseif ($data['classification'] === 'B') {
    //             $data['indicated_percentage'] = '20.86%'; 
    //         } elseif ($data['classification'] === 'C') {
    //             $data['indicated_percentage'] = '5.90%'; 
    //         }
    //     }

    //     $totalProducts = count($productData);
    //     $classificationCounts = [
    //         'A' => 0,
    //         'B' => 0,
    //         'C' => 0,
    //     ];
    //     foreach ($productData as $data) {
    //         if ($data['classification'] === 'A') {
    //             $classificationCounts['A']++;
    //         } elseif ($data['classification'] === 'B') {
    //             $classificationCounts['B']++;
    //         } elseif ($data['classification'] === 'C') {
    //             $classificationCounts['C']++;
    //         }
    //     }

    //     foreach ($productData as &$data) {
    //         $data['percentage_of_items'] = $totalProducts > 0
    //             ? ($classificationCounts[$data['classification']] / $totalProducts) * 100
    //             : 0;
    //     }

    //     foreach ($productData as &$data) {
    //         $data['rowspan'] = $data['rowspan'] > 1 ? $data['rowspan'] : 1; 
    //     }

    //     $productData = array_values($productData);
    
    //     return view('abc.index', compact('productData', 'grandTotalProfit'));
    // }
    
    public function indexForecasting()
    {
        $products = Product::with(['customerOrders' => function ($query) {
            $query->select('product_id', 'weeks', DB::raw('SUM(stock_out_quantity) as total_stock_out_quantity'))
                ->groupBy('product_id', 'weeks');
        }])->get();

        $productData = [];
        $grandTotalProfit = 0; 

        foreach ($products as $product) {
            $weeklyStockOutQuantities = [];

            foreach ($product->customerOrders as $order) {
                $weekNumber = $order->weeks; 

                if (!isset($weeklyStockOutQuantities[$weekNumber])) {
                    $weeklyStockOutQuantities[$weekNumber] = 0;
                }
                $weeklyStockOutQuantities[$weekNumber] += $order->total_stock_out_quantity;
            }

            ksort($weeklyStockOutQuantities);

            $totalStockOutQuantity = array_sum($weeklyStockOutQuantities);

            $beginningInventory = (int)$product->beginning_inventory_fixed;
            $endingInventory = $beginningInventory - $totalStockOutQuantity;

            $lossProfit = (float)$endingInventory * (float)$product->profit; 
            $potentialProfit = (float)$totalStockOutQuantity * (float)$product->profit; 

            $actualProfit = $potentialProfit; 
            if ($lossProfit < 0) {
                $actualProfit = $lossProfit < 0 ? abs($lossProfit + $potentialProfit) : $lossProfit - $potentialProfit;
            }

            if (!isset($productData[$product->product_name])) {
                $productData[$product->product_name] = [
                    'product_name' => $product->product_name,
                    'total_actual_profit' => $actualProfit,
                    'total_actual_demand' => $totalStockOutQuantity, 
                    'total_forecast' => $weeklyStockOutQuantities, 
                ];
            } else {
                $productData[$product->product_name]['total_actual_profit'] += $actualProfit; 
                $productData[$product->product_name]['total_actual_demand'] += $totalStockOutQuantity; 
                $productData[$product->product_name]['total_forecast'] += $weeklyStockOutQuantities;
            }

            $grandTotalProfit += $actualProfit;
        
        }

        $productDataArray = array_values($productData);

        usort($productDataArray, function($a, $b) {
            return $b['total_actual_profit'] <=> $a['total_actual_profit'];
        });

    

        return view('forecasting.index', compact('productDataArray', 'grandTotalProfit'));
        }
    public function indexEOQ(){
        $products = DB::table('products')
        ->join('items', 'products.item_id', '=', 'items.id')
        ->leftJoin('daily_usages', 'products.item_id', '=', 'daily_usages.item_id')
        ->select(
            'products.item_id',
            'items.item_name',
            'items.item_cost',
            'products.ordering_cost',
            DB::raw('COALESCE(SUM(daily_usages.daily_usage), products.daily_usage, 0) as total_daily_usage')
        )
        ->groupBy(
            'products.item_id',
            'items.item_name',
            'items.item_cost',
            'products.ordering_cost',
            'products.daily_usage'
        )
        ->get();

    $eoqData = [];

    foreach ($products as $product) {

        // D = Annual Usage
        $dailyUsage = (float) $product->total_daily_usage;
        $annualUsage = $dailyUsage * 288;

        // S = Ordering Cost
        $orderingCost = (float) $product->ordering_cost;

        // H = Holding Cost (25% of item cost)
        $holdingCost = (float) $product->item_cost * 0.25;

        // EOQ Formula
        $EOQ = 0;

        if ($holdingCost > 0) {
            $EOQ = sqrt((2 * $annualUsage * $orderingCost) / $holdingCost);
        }

        $eoqData[] = [
            'item_name' => $product->item_name,
            'annual_usage' => round($annualUsage, 2),
            'ordering_cost' => round($orderingCost, 2),
            'holding_cost' => round($holdingCost, 2),
            'eoq' => round($EOQ),
        ];
    }

        return view('eoq.index', compact('eoqData'));
    }
 
    public function indexROP(){
      

        $products = DB::table('products')
            ->join('items', 'products.item_id', '=', 'items.id')
            ->leftJoin('daily_usages', 'products.item_id', '=', 'daily_usages.item_id')
            ->select(
                'products.item_id',
                'items.item_name',
                'items.safety_stock',
                'products.ordering_date',
                'products.arrival_date',
                DB::raw('COALESCE(SUM(daily_usages.daily_usage), products.daily_usage, 0) as total_daily_usage')
            )
            ->groupBy(
                'products.item_id',
                'items.item_name',
                'items.safety_stock',
                'products.ordering_date',
                'products.arrival_date',
                'products.daily_usage'
            )
            ->get();

        $ropData = [];

        foreach ($products as $product) {

            // DAILY USAGE
            $dailyUsage = (float) $product->total_daily_usage;

            // SAFETY DAYS
            $safetyDays = (float) $product->safety_stock;

            // SAFETY STOCK
            $safetyStock = $dailyUsage * $safetyDays;

            // LEAD TIME
            $orderingDate = Carbon::parse($product->ordering_date);
            $arrivalDate = Carbon::parse($product->arrival_date);

            $leadTime = $orderingDate->diffInDays($arrivalDate);

            // ROP FORMULA
            $rop = ($dailyUsage * $leadTime) + $safetyStock;

            $ropData[] = [
                'item_name' => $product->item_name,
                'daily_usage' => $dailyUsage,
                'lead_time' => $leadTime,
                'safety_stock' => round($safetyStock),
                'rop' => round($rop),
            ];
        }
        return view('rop.index', compact('ropData'));
    }

    
}
