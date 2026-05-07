@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                <h5 class="text-white text-capitalize flex-grow-1">Reports on Profit</h5>
                {{-- <form action=" " method="GET" class="d-flex align-items-center"> 
                  <input placeholder="Search reports about product profit by product name or unit" type="text"  
                         name="search_profit"  class="form-control input-search ps-2" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ request('search_profit') }}"  
                         style="margin-right: 10px; width: 20vw;background-color:white;">
                  <button type="submit" class="btn btn-primary mt-3">Search</button>
                </form>   --}}
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2"> 
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                  <tr>
                      <th class="mb-0 text-sm">Week</th> 
                      <th class="mb-0 text-sm bg-danger text-white">Total Loss in Profit</th> 
                      <th class="mb-0 text-sm bg-success text-white">Total Potential Profit</th> 
                      <th class="mb-0 text-sm bg-info text-white">Total Actual Profit</th> 
                  </tr>
              </thead>
              <tbody>
                  @if(empty($profitData))
                      <tr>
                          <td colspan="3" class="text-center text-secondary text-xs font-weight-bold text-uppercase">
                              No Reports about the Product's Profit Yet.
                          </td>
                      </tr>
                  @else
                      @foreach($profitData as $profit)
                          <tr>
                              <td>{{ $profit['week'] }}</td>
                              <td class="text-danger">₱
                                {{ number_format($profit['total_loss'], 2) }}</td>
                              <td class="text-dark"> ₱{{ number_format($profit['total_potential'], 2) }}</td>
                              <td class="text-info"> ₱{{ number_format($profit['total_actualprofit'], 2) }}</td>
                          </tr>                        
                      @endforeach
                  @endif
              </tbody>
          </table>
          
        </div>
        
          </div>
        </div>
      
      </div>
    </div>
  </div>

</div>
@endsection