@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
              <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                  <h5 class="text-white text-capitalize flex-grow-1">Critical Products</h5>
                  <form action=" " method="GET" class="d-flex align-items-center"> 
                      <input placeholder="Search critical products by name" type="text"  
                             name="search"  class="form-control input-search ps-2" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ request('search') }}"  
                             style="margin-right: 10px; width: 20vw;background-color:white;">
                      <button type="submit" class="btn btn-primary mt-3">Search</button>
                  </form>  
              </div>
            </div>          
          </div>
          <div class="card-body px-3 pb-2">
            <div class="table-responsive p-3" style="overflow-x: auto !important; width: 100%; -webkit-overflow-scrolling: touch;"> 
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
                    @if($criticalProducts->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-secondary text-xs font-weight-bold text-uppercase">
                                No Critical Products for Today.
                            </td>
                        </tr>
                    @else
                        @foreach($criticalProducts as $critical)
                        <tr>
                          <td>{{ $critical->item_name }}</td>
                          <td>{{ $critical->unit }}</td>
                          <td>{{ number_format($critical->holding_cost, 2) }}</td>
                          <td>{{ number_format($critical->ordering_cost, 2) }}</td>
                          <td><span class="badge badge-sm bg-gradient-danger">{{ $critical->beginning_inventory }}</span></td>
                        </tr>                        
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                  <tr>
                      <td colspan="4" class="text-right text-uppercase font-weight-bold ">
                          Total Critical Products: {{ $totalCriticalProducts }}
                      </td>
                  </tr>
              </tfoot>
            </table>
            
           
            <div class="ps-4 mt-5">
                {{ $criticalProducts->links() }}
            </div>
            
            
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection