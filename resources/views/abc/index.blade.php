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
                <h5 class="text-white text-capitalize flex-grow-1">Reports on ABC ANALYSIS</h5>
               
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2"> 
          <div class="table-responsive p-0">
              <table class="table align-items-center mb-0" id="ABC_table">
                  <thead>
                      <tr>
                          <th class="mb-0 text-sm">Product Name</th> 
                          <th class="mb-0 text-sm">Total Actual Profit</th> 
                         <th class="mb-0 text-sm bg-success text-white">Percentage Value of Total Profit</th> 
                          <th class="mb-0 text-sm bg-warning text-white">Comulative Percentage</th> 
                        <th class="mb-0 text-sm bg-primary text-white">Classification</th> 
                         <th class="mb-0 text-sm bg-warning text-white">Percentage Of Value</th>  
                       <th class="mb-0 text-sm bg-secondary text-white">Percentage Of Items</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($productData as $data)
                        <tr>
                            <td class="text-sm text-dark">{{ $data['product_name'] }}</td>
                            <td class="text-sm text-info" > {{ number_format($data['total_actual_profit'], 2) }}</td>
                            <td class="text-sm text-success">{{ number_format($data['percentage_value_of_total_profit'], 2) }}%</td>
                            <td class="text-sm text-dark">{{ number_format($data['cumulative_percentage'], 2) }}%</td>
                            <td class="text-sm text-dark">{{ $data['classification'] }}</td>
                            <td class="text-sm text-dark">{{ $data['indicated_percentage'] }}</td>
                            <td class="text-sm text-dark">{{ number_format($data['percentage_of_items'], 2) }}%</td>
                            
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-info text-white">
                    <tr>
                        <td class="text-sm font-weight-bold">Grand Total</td>
                        <td class="text-sm font-weight-bold">{{ number_format($grandTotalProfit, 2) }}</td>
                     
                    </tr>
                </tfoot>
              </table>
          </div>
        </div>
      {{-- <script>
          $(document).ready(function() {
            var ABC_tabledataTable = $('#ABC_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('abc.index') }}",
                 
                },
                pageLength: 153,
                lengthMenu: [ 
                    [153, 200, 500, 1000, 3000, 4000, 5000],
                    [153, 200, 500, 1000, 3000, 4000, 5000] 
                ],
                columns: [
                    {
            data: 'product_name',
            name: 'product_name',
            render: function(data) {
                return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
            }
        },
        {
            data: 'totalActualProfit',
            name: 'totalActualProfit',
            render: function(data) {
                return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
            }
        },
        // {
        //     data: 'percentTotalProfit',
        //     name: 'percentTotalProfit',
        //     render: function(data) {
        //         return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
        //     }
        // },
        // {
        //     data: 'comulativePercentage',
        //     name: 'comulativePercentage',
        //     render: function(data) {
        //         return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
        //     }
        // },
        // {
        //     data: 'classification',
        //     name: 'classification',
        //     render: function(data) {
        //         return '<div style="flex: 1; white-space: nowrap;">' +data + '</div>';
        //     }
        // },
        // {
        //     data: 'percentValue',
        //     name: 'percentValue',
        //     render: function(data) {
        //         return '<div style="flex: 1; white-space: nowrap;">' +data + '</div>';
        //     }
        // },
        // {
        //     data: 'percentItem',
        //     name: 'percentItem',
        //     render: function(data) {
        //         return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
        //     }
        // }
            
        ]
    });
   
});
      </script> --}}
      </div>
    </div>
  </div>
</div>
@endsection





