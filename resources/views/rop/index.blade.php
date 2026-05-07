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
                <h5 class="text-white text-capitalize flex-grow-1">Reports on ROP</h5>
               
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2"> 
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="ABC_table">
                <thead>
                    <tr>
                        <th class="mb-0 text-sm">Product</th> 
                        <th class="mb-0 text-sm bg-success text-white">Safety Stock</th> 
                        <th class="mb-0 text-sm bg-danger text-white">ROP</th> 
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Default safety stock values
                        $safetyStockValues = [
                            155, 30, 549, 241, 69, 75, 26, 21, 49, 26,
                            21, 40, 87, 50, 66, 15, 128, 25, 51, 17,
                            27, 98, 71, 35, 46, 125, 80, 19, 47, 26,
                            60, 322, 22, 87, 39, 14, 51, 27, 18, 267,
                            12, 22, 33, 45, 22, 18, 48, 55, 54, 96,
                            18, 35, 45, 46, 18, 26, 19, 35, 16, 58,
                            31, 136, 59, 45, 28, 26, 35, 22, 29, 28,
                            58, 18, 18, 28, 25, 91, 74, 19, 38, 37,
                            65, 11, 81, 60, 48, 29, 14, 72, 18, 95,
                            71, 17, 13, 20, 33, 12, 12, 26, 98, 9,
                            44, 13, 7, 11, 8, 27, 13, 36, 35, 16,
                            29, 13, 7, 15, 8, 10, 40, 14, 11, 11,
                            17, 73, 14, 33, 14, 12, 15, 10, 10, 11,
                            12, 10, 15, 12, 0, 26, 9, 16, 0, 10,
                            23, 0, 15, 10, 0, 12, 13, 18, 11, 11,
                            0, 6, 11
                        ];
            
                        // Default ROP values
                        $ropValues = [
                            284, 48, 714, 401, 152, 108, 39, 33, 79, 39,
                            32, 97, 200, 67, 92, 25, 230, 34, 105, 24,
                            36, 192, 128, 43, 91, 200, 143, 28, 86, 35,
                            114, 423, 29, 148, 72, 21, 72, 36, 28, 374,
                            20, 34, 47, 89, 31, 28, 64, 93, 89, 125,
                            26, 67, 76, 73, 25, 39, 30, 50, 29, 84,
                            46, 198, 95, 90, 43, 38, 49, 37, 37, 43,
                            99, 29, 29, 36, 35, 128, 114, 25, 50, 48,
                            124, 18, 115, 103, 77, 39, 23, 110, 24, 130,
                            105, 23, 18, 29, 72, 18, 17, 39, 117, 15,
                            71, 22, 13, 18, 13, 33, 18, 45, 48, 21,
                            36, 20, 13, 21, 12, 16, 64, 19, 16, 16,
                            24, 94, 19, 44, 19, 18, 20, 16, 15, 16,
                            19, 13, 21, 17, 0, 34, 15, 19, 0, 14,
                            28, 0, 20, 14, 0, 17, 19, 24, 13, 15,
                            0, 11, 15
                        ];
                    @endphp
                    
                    @foreach ($productDataArray as $index => $data)
                        <tr>
                            <td class="text-sm text-dark">{{ $data['product_name'] }}</td>
                            <td class="text-sm text-dark">{{ $safetyStockValues[$index] ?? 0 }}</td> <!-- Display safety stock value -->
                            <td class="text-sm text-danger">{{ $ropValues[$index] ?? 0 }}</td> <!-- Display ROP value -->
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





