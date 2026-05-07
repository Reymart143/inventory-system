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
            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                    <h5 class="text-white text-capitalize flex-grow-1">List of Customers Ordered</h5>
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
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Customer Name</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Product Name</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">QTY Ordered</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Reference No</th>
                            {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Proof of Receipt</th> --}}
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($custOrderApproval->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-secondary text-xs font-weight-bold text-uppercase">
                                    No Customer Ordered.
                                </td>
                            </tr>
                        @else
                            @foreach($custOrderApproval as $c)
                            <tr>
                               <td class="text-dark">{{ $c->user->name }}</td>
                              <td class="text-dark"> {{ $c->product->product_name }}</td>
                          
                              <td class="text-dark">{{ $c->stock_out_quantity }}</td>
                              <td class="text-dark">{{ $c->reference_no }}</td>
                              {{-- <td class="text-dark">
                                <img src="{{ asset('storage/images/' . $c->image) }}" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                            </td> --}}
                            
                              <td class="text-dark">
                                @if($c->status == 'Done')
                                <span class="badge badge-sm bg-gradient-success">Done</span></td>
                                @elseif($c->status == 'Pending')
                                <span class="badge badge-sm bg-gradient-secondary">Pending</span></td>
                                @else
                                <span class="badge badge-sm bg-gradient-danger">Reject</span></td>
                                @endif 
                                <td class="d-flex" > 
                                    @if($c->status == 'Done' || $c->status == 'Reject')
                                        <button class="btn btn-success approve-member" disabled style="margin-right:2%" data-id="{{ $c->id }}">
                                            <i class="fa fa-thumbs-up"></i>
                                        </button>
                                        <button class="btn btn-danger disapprove-member" disabled data-id="{{ $c->id }}">
                                            <i class="fa fa-thumbs-down"></i>
                                        </button>
                                
                                    @elseif($c->status == 'Pending')
                                        <button class="btn btn-success approve-member" style="margin-right:2%" data-id="{{ $c->id }}" >
                                            <i class="fa fa-thumbs-up"></i>
                                        </button>
                                        <button class="btn btn-danger disapprove-member" data-id="{{ $c->id }}">
                                            <i class="fa fa-thumbs-down"></i>
                                        </button>
                            
                                    @endif     
                                </td>                   
                            @endforeach
                        @endif
                      
                    </tr>
                        <script>
                         // Approve customer order
                         document.querySelectorAll('.approve-member').forEach(function(button) {
                            button.addEventListener('click', function() {
                                const orderId = button.getAttribute('data-id');
                                Swal.fire({
                                    title: 'Are you sure you want to approve?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, approve it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Send approval request via AJAX
                                        $.ajax({
                                            url: `/customer-order/approve/${orderId}`,
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                            },
                                            success: function() {
                                                Swal.fire('Approved!', 'Order has been approved.', 'success').then(() => {
                                                    location.reload(); // Reload the page after success
                                                });
                                            },
                                            error: function() {
                                                Swal.fire('Error!', 'Failed to approve the order.', 'error');
                                            }
                                        });
                                    }
                                });
                            });
                        });

                        document.querySelectorAll('.disapprove-member').forEach(function(button) {
                            button.addEventListener('click', function() {
                                const orderId = button.getAttribute('data-id');
                                Swal.fire({
                                    title: 'Are you sure you want to reject?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, reject it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Send rejection request via AJAX
                                        $.ajax({
                                            url: `/customer-order/reject/${orderId}`,
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                            },
                                            success: function() {
                                                Swal.fire('Rejected!', 'Order has been rejected.', 'success').then(() => {
                                                    location.reload(); // Reload the page after success
                                                });
                                            },
                                            error: function() {
                                                Swal.fire('Error!', 'Failed to reject the order.', 'error');
                                            }
                                        });
                                    }
                                });
                            });
                        });

                      </script>
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
                    {{ $custOrderApproval->links() }}
                </div>
                
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection