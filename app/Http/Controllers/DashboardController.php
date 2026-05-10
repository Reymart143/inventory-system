<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function index()
    {
        $productsWithUsage = DB::table('products')
            ->leftJoin('daily_usages', 'products.item_id', '=', 'daily_usages.item_id')
            ->select(
                'products.item_id',
                'products.beginning_inventory',
                'products.reorder_point',
                DB::raw('COALESCE(SUM(daily_usages.daily_usage), 0) as total_daily_usage')
            )
            ->groupBy(
                'products.item_id',
                'products.beginning_inventory',
                'products.reorder_point'
            )
            ->get();

        $totalProducts = DB::table('products')->count();
        $totalItems = DB::table('items')->count();

        $totalDailyUsage = $productsWithUsage->sum('total_daily_usage');

        $totalStock = $productsWithUsage->sum(function ($product) {
            return (float) $product->beginning_inventory - (float) $product->total_daily_usage;
        });

        $criticalProducts = $productsWithUsage->filter(function ($product) {
            $endingInventory = (float) $product->beginning_inventory - (float) $product->total_daily_usage;

            return $endingInventory <= (float) $product->reorder_point && $endingInventory > 0;
        })->count();

        $outOfStocks = $productsWithUsage->filter(function ($product) {
            $endingInventory = (float) $product->beginning_inventory - (float) $product->total_daily_usage;

            return $endingInventory <= 0;
        })->count();

        $totalItemValue = DB::table('products')
            ->join('items', 'products.item_id', '=', 'items.id')
            ->leftJoin('daily_usages', 'products.item_id', '=', 'daily_usages.item_id')
            ->select(
                'products.item_id',
                'items.item_cost',
                'products.beginning_inventory',
                DB::raw('COALESCE(SUM(daily_usages.daily_usage), 0) as total_daily_usage')
            )
            ->groupBy(
                'products.item_id',
                'items.item_cost',
                'products.beginning_inventory'
            )
            ->get()
            ->sum(function ($product) {
                $endingInventory = (float) $product->beginning_inventory - (float) $product->total_daily_usage;

                return $endingInventory * (float) $product->item_cost;
            });

        $totalUsers = DB::table('users')->count();
        $usageChart = DB::table('daily_usages')
                ->select(
                    'date',
                    DB::raw('SUM(daily_usage) as total_usage')
                )
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();

            $usageLabels = $usageChart->pluck('date_used')->map(function ($date) {
                return Carbon::parse($date)->format('F d, Y');
            });
            $usageValues = $usageChart->pluck('total_usage');

            // Classification chart: A B C count
            $abcCounts = collect($productData ?? [])->groupBy('classification')->map->count();

            $classA = $abcCounts['A'] ?? 0;
            $classB = $abcCounts['B'] ?? 0;
            $classC = $abcCounts['C'] ?? 0;
        return view('dashboard.index', compact(
            'totalProducts',
            'totalItems',
            'totalDailyUsage',
            'criticalProducts',
            'outOfStocks',
            'totalStock',
            'totalItemValue',
            'totalUsers',
            'usageLabels',
            'usageValues',
            'classA',
            'classB',
            'classC'
        ));
    }
}
