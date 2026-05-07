@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                <h5 class="text-white text-capitalize flex-grow-1">Reports on Economic Order Quantity</h5>
               
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2"> 
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="ABC_table">
                <thead>
                    <tr>
                        <th class="mb-0 text-sm">Product</th> 
                        <th class="mb-0 text-sm bg-warning text-white">EOQ</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productDataArray as $index => $data)
                    <tr>
                        <td class="text-sm text-dark">{{ $data['product_name'] }}</td>
                        <td class="text-sm text-dark">
                            @php
                              
                                $total_forecast = $data['total_forecast'];
                                $totalForecastFromWeek4 = 0;
                
                                $averages = [];
                
                                for ($currentWeek = 4; $currentWeek <= 32; $currentWeek++) {
                                    // Calculate the sum of the previous three weeks
                                    $sum = 0;
                                    $count = 0;
                
                                    // Collect the values of the previous three weeks
                                    for ($i = $currentWeek - 1; $i >= $currentWeek - 3 && $i >= 1; $i--) {
                                        $prev_week_key = "Week " . $i;
                                        if (isset($total_forecast[$prev_week_key])) {
                                            // Ensure we're only working with whole numbers
                                            $sum += (int) $total_forecast[$prev_week_key]; // Cast to int to avoid decimal
                                            $count++;
                                        }
                                    }
                
                                    // Calculate the average if there are enough previous weeks
                                    if ($count === 3) { // Only if all three weeks are available
                                        $average = round($sum / $count); // Use round instead of int casting
                                        $averages['Week ' . $currentWeek] = $average;
                                    } elseif ($count > 0) { 
                                        $averages['Week ' . $currentWeek] = round($sum / $count); 
                                    } else {
                                        $averages['Week ' . $currentWeek] = 0;
                                    }
                                }
                
                                $totalForecastFromWeek4 = array_sum($averages);
                
                                // Calculate the EOQ based on the total forecast
                                $annualDemand = round($totalForecastFromWeek4 * 1.625); // Annual demand calculation
                                $supplierCosts = [
                                    3650, 2760, 106, 775, 2960, 2550, 4150, 650, 1150, 2810,
                                    1130, 2950, 910, 920, 180, 2450, 890, 2450, 3500, 3000,
                                    2950, 890, 890, 700, 1150, 830, 880, 970, 1150, 1205,
                                    930, 40, 1905, 930, 3850, 1210, 280, 1050, 320, 31,
                                    715, 330, 330, 970, 390, 330, 160, 850, 97, 155,
                                    210, 122, 870, 120, 330, 31, 145, 46, 220, 215,
                                    70, 29, 228, 60, 70, 146, 35, 70, 80, 139,
                                    40, 70, 70, 105, 12, 54, 50, 23, 360, 85,
                                    57, 10, 67, 70, 50, 213, 30, 44, 62, 50,
                                    54, 177, 70, 105, 55, 71, 57, 38, 35, 53,
                                    35, 291, 14, 382, 36, 65, 47, 64, 105, 412,
                                    74, 31, 42, 104, 88, 72, 70, 94, 32, 11,
                                    23, 45, 24, 35, 18, 35, 115, 14, 15, 52,
                                    25, 37, 14, 9, 23, 53, 21, 7, 10, 70,
                                    10, 16, 12, 13, 14, 13, 5, 20, 23, 20,
                                    20, 15, 7
                                ];
                                // Calculate holding costs
                                $holdingCosts = array_map(function($cost) {
                                    return round($cost * 0.25); // Calculate and round holding cost
                                }, $supplierCosts);
                
                                $fixedOrderingCosts = [
                                    550.00, 300, 400, 500.00, 550.00, 500, 550.00, 550, 500, 300,
                                    550.00, 550, 500.00, 400, 300, 550, 500.00, 550, 550.00, 550,
                                    550, 500, 500, 380, 500, 500.00, 500, 400, 500, 550, 500,
                                    550, 400, 500, 550, 550, 300, 550, 300, 550.00, 550, 300,
                                    300, 500.00, 300, 300, 300, 500.00, 300, 400, 300.00, 500.00,
                                    500.00, 400, 300, 400, 300, 300, 300, 400, 300, 550, 550,
                                    550, 300, 400, 380, 300, 300, 550, 500.00, 300, 300, 300,
                                    380, 550, 500.00, 380, 400, 380, 550, 380, 550.00, 550,
                                    500.00, 300, 400, 550, 380, 550.00, 550, 400, 380, 550,
                                    550, 380, 380, 550, 300, 380, 500.00, 550, 380, 300, 380,
                                    380, 380, 380, 550, 300, 380, 380, 380, 380, 380, 380,
                                    550, 380, 380, 380, 380, 550, 380, 500, 380, 380, 380,
                                    380, 380, 380, 380, 380, 380, 380, 380, 380, 380, 380,
                                    380, 380, 380, 380, 380, 380, 380, 380, 380, 380, 380,
                                    380, 380, 380, 380, 380
                                ];
                
                                $totalFixedOrderingCost = isset($fixedOrderingCosts[$index]) ? $fixedOrderingCosts[$index] : 0;
                                
                                // Calculate EOQ
                                $holdingCost = $holdingCosts[$index] ?? 0;
                                $EOQ = ($holdingCost > 0) ? sqrt((2 * $annualDemand * $totalFixedOrderingCost) / $holdingCost) : 0;
                
                            @endphp
                
                            {{-- Display the EOQ --}}
                            {{-- <strong>{{ number_format($annualDemand, 0) }}</strong>
                            <strong>{{ number_format($holdingCosts[$index], 2) }}</strong>
                            <strong>{{ number_format($totalFixedOrderingCost, 2) }}</strong> --}}
                            <strong>{{ number_format($EOQ, 0) }}</strong> <!-- Display EOQ -->
                        </td>
                    </tr>
                @endforeach
                
                </tbody>
                
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection





