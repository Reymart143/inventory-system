@extends('layouts.app')
<style>
    svg.w-5.h-5 {
        width: 2% !important;
    }
    .flex.justify-between.flex-1.sm\:hidden {
        margin-bottom: 15px;
    }
</style>
@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                    <h5 class="text-white text-capitalize flex-grow-1">Out of Stock Products</h5>
                    
                 
                </div>
            </div> 
          </div>
          <div class="card-body px-2 pb-2">
            {{-- <form id="filter-form" class="d-flex flex-wrap align-items-center" method="GET" action="{{ route('out-of-stocks') }}">
                @csrf
            
                <div class="mb-2 me-2 ms-3" style="flex: 1; min-width: 250px;">
                    <label for="product_name" class="form-label">Filter By Product Name:</label>
                    <select name="product_name" id="product_name" class="form-control ps-2 modal-inputs px-2">
                        <option value=""> --- ---</option>
                        @for ($i = 1; $i <= 21; $i++)
                            <option value="Flour {{ $i }}" {{ request('product_name') == "Flour {$i}" ? 'selected' : '' }}>Flour {{ $i }}</option>
                        @endfor
                        @for ($i = 1; $i <= 11; $i++)
                            <option value="Sugar {{ $i }}" {{ request('product_name') == "Sugar {$i}" ? 'selected' : '' }}>Sugar {{ $i }}</option>
                        @endfor
                        @for ($i = 1; $i <= 25; $i++)
                            <option value="Dairy & Oils {{ $i }}" {{ request('product_name') == "Dairy & Oils {$i}" ? 'selected' : '' }}>Dairy & Oils {{ $i }}</option>
                        @endfor
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="Others {{ $i }}" {{ request('product_name') == "Others {$i}" ? 'selected' : '' }}>Others {{ $i }}</option>
                        @endfor
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="Leaving Agent {{ $i }}" {{ request('product_name') == "Leaving Agent {$i}" ? 'selected' : '' }}>Leaving Agent {{ $i }}</option>
                        @endfor
                        @for ($i = 1; $i <= 21; $i++)
                            <option value="Add Ins {{ $i }}" {{ request('product_name') == "Add Ins {$i}" ? 'selected' : '' }}>Add Ins {{ $i }}</option>
                        @endfor
                        @for ($i = 1; $i <= 56; $i++)
                            <option value="Paper & Plastic {{ $i }}" {{ request('product_name') == "Paper & Plastic {$i}" ? 'selected' : '' }}>Paper & Plastic {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            
                <div class="mb-2 me-2 ms-2" style="flex: 1; min-width: 200px;">
                    <label for="weeks" class="form-label">Filter By Week:</label>
                    <select name="weeks" id="weeks" class="form-select modal-inputs px-2">
                        <option value="">Select Week</option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="Week {{ $i }}" {{ request('weeks') == "Week {$i}" ? 'selected' : '' }}>Week {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            
                <button class="btn btn-primary ms-2 me-3" type="submit" style="min-width: 230px; margin-top:35px;">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </form> --}}
            
            <div class="table-responsive p-3" style="overflow-x: hidden !important;">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Products</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Unit</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Holding Cost</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Ordering Cost</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Stock Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($outOfStockProducts->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-secondary text-xs font-weight-bold text-uppercase">
                                    No Out of Stock Products.
                                </td>
                            </tr>
                        @else
                            @foreach($outOfStockProducts as $outstock)
                            <tr>
                              <td>{{ $outstock->item_name }}</td>
                               <td>{{ $outstock->unit }}</td>
                                <td>{{ number_format($outstock->holding_cost, 2) }}</td>
                                <td>{{ number_format($outstock->ordering_cost, 2) }}</td>
                              <td><span class="badge badge-sm bg-gradient-danger">{{ $outstock->beginning_inventory }}</span></td>
                            </tr>                        
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                      <tr>
                          <td colspan="4" class="text-right text-uppercase font-weight-bold ">
                              Total Out of Stock Products: {{ $totalOutstockProducts }}
                          </td>
                      </tr>
                  </tfoot>
                </table>
                
               
                <div class="ps-4 mt-5">
                    {{ $outOfStockProducts->links() }}
                </div>
                
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection