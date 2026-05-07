@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-success border-radius-lg pt-4 pb-3">
            <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                <h5 class="text-white text-capitalize flex-grow-1">Reports on Forecasting Demand</h5>
               
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2"> 
          <div class="table-responsive p-0">
              <table class="table align-items-center mb-0" id="ABC_table">
                  <thead>
                      <tr>
                          <th class="mb-0 text-sm">Product</th> 
                          <th class="mb-0 text-sm">Total Actual Demand</th> 
                         <th class="mb-0 text-sm bg-warning text-white">Total Forecast</th> 
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($productDataArray as $data)
                    <tr>
                        <td class="text-sm text-dark">{{ $data['product_name'] }}</td>
                        <td class="text-sm text-dark">{{ $data['total_actual_demand'] }}</td>
                        <td class="text-sm text-dark">
                            @php
                              
                                $total_forecast = $data['total_forecast'];
                                $totalForecastFromWeek4 = 0;
                
                                $averages = [];
                
                                for ($currentWeek = 4; $currentWeek <= 32; $currentWeek++) {
                 
                                    $sum = 0;
                                    $count = 0;
                
                                    for ($i = $currentWeek - 1; $i >= $currentWeek - 3 && $i >= 1; $i--) {
                                        $prev_week_key = "Week " . $i;
                                        if (isset($total_forecast[$prev_week_key])) {
                                            $sum += (int) $total_forecast[$prev_week_key]; 
                                            $count++;
                                        }
                                    }
                
                                    if ($count === 3) {
                                        $average = round($sum / $count); 
                                        $averages['Week ' . $currentWeek] = $average;
                                    } elseif ($count > 0) { 
                                        $averages['Week ' . $currentWeek] = round($sum / $count);
                                    } else {
                                        $averages['Week ' . $currentWeek] = 0; 
                                    }
                                }
                
                                $totalForecastFromWeek4 = array_sum($averages);
                            @endphp
                
                            <strong></strong> {{ number_format($totalForecastFromWeek4, 0) }}
                
                            {{-- Display averages for each week from Week 4 to Week 32 --}}
                            {{-- <ul>
                                @foreach ($averages as $week => $average)
                                    <li>{{ $week }}: {{ sum(number_format($average, 0)) }}</li>
                                @endforeach
                            </ul> --}}
                        </td>
                    </tr>
                @endforeach
                
                </tbody>
                
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection





