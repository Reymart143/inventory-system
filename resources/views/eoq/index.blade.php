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
                <h5 class="text-white text-capitalize flex-grow-1">Reports on Economic Order Quantity</h5>
               
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2"> 
          <div class="table-responsive p-0">
           <table class="table align-items-center mb-0">

    <thead>
        <tr>
            <th class="mb-0 text-sm">Item</th>
            <th class="mb-0 text-sm bg-warning text-white">
                EOQ
            </th>
        </tr>
    </thead>

    <tbody>

        @foreach($eoqData as $data)
            <tr>

                <td>
                    <p class="text-sm font-weight-bold mb-0">
                        {{ $data['item_name'] }}
                    </p>
                </td>

                <td>
                    <span class="badge bg-warning text-white">
                        {{ number_format($data['eoq']) }}
                    </span>
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





