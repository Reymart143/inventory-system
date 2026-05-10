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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                    <h5 class="text-white text-capitalize flex-grow-1">List of Items</h5>
                    <a href="/items/create" class="btn btn-primary me-4" >
                        <i class="fa fa-plus me-2"></i>Add Items
                    </a>
                </div>
            </div> 
          </div>
          <div class="card-body px-2 pb-2">
            {{-- <form id="filter-form" class="d-flex flex-wrap align-items-center" method="GET" action="{{ route('customer.list_customer') }}">
                @csrf
            
                <div class="mb-2 me-2 ms-3" style="flex: 1; min-width: 250px;">
                    <label for="product_name" class="form-label">Filter By Product Name:</label>
                    <select class="form-control modal-inputs ps-2 product-select" id="product_name" name="product_name" required>
                        <option value=""> --- --- </option>
                          @foreach($Pname as $Pn)
                            <option value="{{ $Pn->id }}">{{ $Pn->product_name }}</option>
                        @endforeach
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
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Item Name</th>
                           <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Item Cost</th>
                             <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Safety Stocks</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($items->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-secondary text-xs font-weight-bold text-uppercase">
                                    No Items added
                                </td>
                            </tr>
                        @else
                            @foreach($items as $c)
                            <tr>
                               <td class="text-dark">{{ $c->item_name}}</td>
                               <td class="text-dark">{{ number_format($c->item_cost,2 )}}</td>
                              <td class="text-dark">{{ $c->safety_stock }}</td>
                              {{-- <td class="text-dark">
                                <img src="{{ asset('storage/images/' . $c->image) }}" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                            </td> --}}
                            
                              <td class="text-dark">
                                  <div class="d-flex gap-1 align-items-center">

                                        <a href="{{ route('items.edit', $c->id )}}" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('items.destroy', $c->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>                   
                            @endforeach
                        @endif
                      
                    </tr>
                    </tbody>
                    {{-- <tfoot>
                      <tr>
                          <td colspan="4" class="text-right text-uppercase font-weight-bold ">
                              Total Out of Stock Products: {{ $totalOutstockProducts }}
                          </td>
                      </tr>
                  </tfoot> --}}
                </table>
                
               
                <div class="ps-4 mt-5">
                    {{ $items->links() }}
                </div>
                
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection