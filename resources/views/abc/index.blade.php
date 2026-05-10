@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
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
                        <th class="mb-0 text-sm">Item Name</th>
                        <th class="mb-0 text-sm">Item Value</th>
                        <th class="mb-0 text-sm bg-success text-white">
                            Individual Percentage
                        </th>
                        <th class="mb-0 text-sm bg-warning text-white">
                            Cumulative Percentage
                        </th>
                        <th class="mb-0 text-sm bg-primary text-white">
                            Classification
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($productData as $data)
                        <tr>

                            <!-- ITEM NAME -->
                            <td>
                                <p class="text-sm font-weight-bold mb-0">
                                    {{ $data['item_name'] }}
                                </p>
                            </td>

                            <!-- ITEM VALUE -->
                            <td>
                                <p class="text-sm mb-0">
                                    ₱ {{ number_format($data['item_value'], 2) }}
                                </p>
                            </td>

                            <!-- INDIVIDUAL % -->
                            <td>
                                <span class="badge bg-success">
                                    {{ $data['individual_percentage'] }}%
                                </span>
                            </td>

                            <!-- CUMULATIVE % -->
                            <td>
                                <span class="badge bg-warning text-white">
                                    {{ $data['cumulative_percentage'] }}%
                                </span>
                            </td>

                            <!-- CLASSIFICATION -->
                            <td>

                                @if($data['classification'] == 'A')
                                    <span class="badge bg-danger">
                                        A
                                    </span>

                                @elseif($data['classification'] == 'B')
                                    <span class="badge bg-primary">
                                        B
                                    </span>

                                @else
                                    <span class="badge bg-secondary">
                                        C
                                    </span>
                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
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





