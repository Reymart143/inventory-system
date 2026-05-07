@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
              <h5 class="text-white text-capitalize ps-3">Customer Order</h5>
              <a href="javascript:void(0)" class="btn btn-primary me-4" data-bs-toggle="modal" data-bs-target="#addStockProductModal">
                <i class="fa fa-arrow-up me-2"></i>Add Stock Out Products
              </a>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <form action="{{ route('customerorder.excel') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                @csrf
                <label for="file" class="form-label px-2" >Import Excel:</label>
                <div class="d-flex align-items-center">
                    <input type="file" name="file" id="file" class="form-control ps-2 modal-inputs " style="margin-left:2%" required>
                    <button class="btn btn-success mt-3 px-3 ps-2" type="submit" style="width:330px;margin-left: 2%"><i class="fa fa-download" ></i> Import Cust. Order</button>
                </div>
            </form>
            <div class="table-responsive p-3" style="overflow-x: hidden !important;">
                {{-- add filter her --}}
                {{-- <div class="row mb-3">
                    <div class="col-md-4">
                    <table border="0" cellspacing="5" cellpadding="5" style="">
                        <tbody>
                            <tr>
                                <td style="color:black;">Date From : </td>
                                <td><input type="date" id="min" name="min" class="form-control modal-inputs px-3" style="width: 200px"></td>
                            </tr>
                            <tr>
                                <td style="color:black;">Date To : </td>
                                <td><input type="date" id="max" name="max" class="form-control modal-inputs px-3 mt-1 mb-2" style="width: 200px"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <div class="col-md-4">
                        <label for="weekFilter">Filter by Week:</label>
                        <select id="weekFilter" class="form-control modal-inputs ps-2">
                            <option value="">Select Week</option>
                            <option value="current">Current Week</option>
                            <option value="last">Last Week</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div> --}}
                <table class="table table-bordered table-striped ps-3" id="stockout_table">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Product Name</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Unit</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Customer Order</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Inventory</th>
                        {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Ending Inventory</th> --}}
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Stock Out By</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Date Stock Out</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                    </tr>
                    </thead>
                    
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- Add Stock In Products Modal-->
<div class="modal fade" id="addStockProductModal" tabindex="-1" aria-labelledby="addStockProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header bg-success">
              <h5 class="modal-title text-white" id="addStockProductModalLabel">Stock Out Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
           <div class="modal-body">
            <form id="stockProductForm">
              <div class="row">
                <div class="col-md-4 mb-3" id="selectNo">
                  <label for="no_stockout">How many products do you need to stock Out?</label>
                  <div class="d-flex align-items-center"> 
                      <input type="number" class="form-control modal-inputs ps-2" placeholder="Product Stock" id="no_stockout" name="no_stockout" required>
                      <button type="button" class="btn btn-primary ms-2 mt-3" id="stockin">Submit</button> 
                  </div>
                 
              </div>
          
          </div>
              <div class="row d-none" id="Show">
                  <div id="productEntries"></div>
                  <div class="col-md-12 mb-3">
                    <label for="weeks" class="form-label">Select Week</label>
                    <select name="weeks" id="weeks" class="form-control ps-2 modal-inputs" required>
                        <option value=""> --- ---</option>
                        @for ($i = 32; $i <= 100; $i++)
                            <option value="Week {{ $i }}">Week {{ $i }}</option>
                        @endfor                        
                    </select>
                </div>
              </div>
          </form>
          
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary modal-close-btn" data-bs-dismiss="modal">Close</button>
              <button type="button" id="stockoutproductbtn" class="btn btn-success">Stock Out Product</button>
          </div>
          

      </div>
  </div>
</div>
<script>
$(document).ready(function() {
    // Initialize DataTable
    var stockoutproductdataTable = $('#stockout_table').DataTable({
        processing: true,
        serverSide: true,
        "order": [[6, 'desc']],
        ajax: "{{ route('customer-orders') }}", 
        columns: [
            {
                data: 'product_name',
                name: 'product_name',
                render: function(data) { 
                    return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
                }
            },
            {
                data: 'unit',
                name: 'unit',
                render: function(data) {
                    return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
                }
            },
           
            {
                data: 'stock_out_quantity', 
                name: 'stock_out_quantity',
                render: function(data) {
                    return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
                }
            },
            {
                data: 'ending_inventory',
                name: 'ending_inventory',
                render: function(data) {
                    return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
                }
            },
            // {
            //     data: 'ending_inventory', 
            //     name: 'ending_inventory',
            //     render: function(data) {
            //         return '<div style="flex: 1; white-space: nowrap;">' + data + '</div>';
            //     }
            // },
            {
                data: 'stockout_by',
                name: 'stockout_by',
                render: function(data) {
                    return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
                }
            },
            {
                data: 'date_stockout',
                name: 'date_stockout',
                render: function(data) {
                    return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function(data) {
                    return '<div style="flex: 1; white-space: nowrap;" class="text-info">' + data + '</div>';
                }
            },
        ]
    });

    function filterByDateRange() {
        var minDate = $('#min').val();
        var maxDate = $('#max').val();

        stockoutproductdataTable.column(5).search('');

        if (minDate) {
            var formattedMinDate = new Date(minDate).toLocaleString('default', { month: 'long', day: 'numeric', year: 'numeric' });
            stockoutproductdataTable.column(5).search('^' + formattedMinDate, true, false); 
        }
        if (maxDate) {
            var formattedMaxDate = new Date(maxDate).toLocaleString('default', { month: 'long', day: 'numeric', year: 'numeric' });
            stockoutproductdataTable.column(5).search(formattedMaxDate + '$', true, false);
        }

        stockoutproductdataTable.draw();
    }

    $('#min, #max').on('change', function() {
        filterByDateRange();
    });
});
</script>
<script>
$(document).ready(function() {
    let entryCount = 0; 

    $('#stockin').click(function() {
        const quantity = parseInt($('#no_stockout').val());
        $('#productEntries').empty(); 

        if (quantity > 0) {
            $('#Show').removeClass('d-none');
            $('#selectNo').addClass('d-none');
            for (let i = 0; i < quantity; i++) {
                addProductEntry(entryCount);
                entryCount++;
            }
        } else {
            $('#Show').addClass('d-none'); 
        }
    });

    function addProductEntry(index) {
        const productEntry = `
          <div class="row mb-3 product-entry border p-3 rounded" id="product_entry_${index}">
              <div class="col-md-4 mb-3">
                  <label for="product_id_${index}">Product Name</label>
                  <select class="form-control modal-inputs ps-2 product-select" id="product_id_${index}" name="product_id[]" required>
                      <option value=""> --- --- </option>
                        @foreach($Pname as $Pn)
                          <option value="{{ $Pn->id }}">{{ $Pn->product_name }}</option>
                      @endforeach
                  </select>
              </div>
              <input type="hidden" id="type_${index}" name="type[]" value="0">
              <div class="col-md-4">
                  <label for="stock_${index}">Stock out quantity</label>
                  <input type="number" class="form-control ps-2 modal-inputs stockout-input" placeholder="Stock out quantity" id="stockout_${index}" name="stockout[]" required>
              </div>
              <div class="col-md-2">
                  <label for="stock_${index}">Product Details</label>
                  <div class="invoice-display" id="beginning_inventory_${index}">Recent Stock: </div>
                  <div class="invoice-display" id="reorder_point_${index}">Reorder Point: </div>
                  <input type="hidden" id="hidden_stock_${index}" value="0"> <!-- Hidden input to store recent stock -->
              </div>
              <div class="col-md-2">
                 <input type="hidden" id="weeks_${index}" name="weeks[]">
                  <button type="button" class="btn btn-danger btn-sm remove-product" data-index="${index}"> - </button>
                  <button type="button" class="btn btn-primary btn-sm plus-product ms-2" data-index="${index}">+</button>
              </div>
          </div>
          <hr>
        `;
        $('#productEntries').append(productEntry);
    }
    $('#weeks').on('change', function() {
        const selectedWeek = $(this).val();
        // Update the hidden input for all existing product entries with the selected week
        $('.product-entry').each(function(index) {
            $(this).find('input[id^=weeks_]').val(selectedWeek); // Set the hidden week's input value
        });
    });
    $(document).on('change', '[id^=product_id_]', function() {
        const productId = $(this).val();
        const index = $(this).attr('id').split('_')[2];

        if (productId) {
            $.ajax({
                url: '/get-product-details/' + productId,
                type: 'GET',
                success: function(response) {
                    const recentStock = response.beginning_inventory;
                    $(`#beginning_inventory_${index}`).html('Recent Stock: <span class="badge badge-sm bg-gradient-success">' + recentStock + '</span>');
                    $(`#reorder_point_${index}`).html('Reorder Point: <span class="badge badge-sm bg-danger">' + response.reorder_point + '</span>');
                    $(`#hidden_stock_${index}`).val(recentStock); // Store recent stock in hidden input
                }
            });
        } else {
            $(`#beginning_inventory_${index}`).html('Recent Stock: ');
            $(`#reorder_point_${index}`).html('Reorder Point: ');
            $(`#hidden_stock_${index}`).val(0); // Reset hidden input value
        }
    });

    $(document).on('input', '.stockout-input', function() {
        const index = $(this).attr('id').split('_')[1];
        const recentStock = parseInt($(`#hidden_stock_${index}`).val());
        const stockOutQty = parseInt($(this).val());

        if (stockOutQty > recentStock) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove(); // Remove previous error message
            $(this).after('<div class="invalid-feedback">Stock out quantity cannot exceed recent stock.</div>');
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove(); // Remove error message if valid
        }
    });

    $(document).on('click', '.remove-product', function() {
        const index = $(this).data('index'); 
        $(`#product_entry_${index}`).remove(); 

        if ($('.product-entry').length === 0) {
            $('#Show').addClass('d-none'); 
            $('#selectNo').removeClass('d-none'); 
        }
    });

    $(document).on('click', '.plus-product', function() {
        const index = $(this).data('index'); 
        addProductEntry(entryCount);
        entryCount++; 
    });

    $('#stockoutproductbtn').on('click', function (e) {
    e.preventDefault();

    let StockoutProductform = [];
    let invalidFields = 0;
    let isValid = true; 

    $('.product-entry').each(function() {
        const productId = $(this).find('select[id^=product_id_]').val();
        const stockout = $(this).find('input[id^=stockout_]').val();
        const type = $(this).find('input[id^=type_]').val();
        const stockInput = $(this).find('.stockout-input');
        const weeks = $(this).find('input[id^=weeks_]').val();

        if (stockInput.hasClass('is-invalid')) {
            invalidFields++;
        }

        if (!weeks || weeks === '') {
            Swal.fire({
                title: 'Error',
                text: 'Please select a week for each product entry',
                icon: 'error',
            });
            isValid = false; 
            return false; 
        }
        if (productId && stockout) {
            StockoutProductform.push({
                product_id: productId,
                stockout: stockout,
                type: type,
                weeks: weeks
            });
        }
    });
    
    if (!isValid) {
        return; 
    }

    // Removed the stock exceed validation
    // if (invalidFields > 0) {
    //     Swal.fire({
    //         title: 'Error',
    //         text: 'Please fix the stock out quantities that exceed the recent stock.',
    //         icon: 'error',
    //     });
    //     return;
    // }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '/stockout-product',
        data: { stockoutProductform: StockoutProductform },
        dataType: 'json',
        success: function (response) {
            if (response.status === 200) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                });
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('#addStockProductModal').modal('hide');
                $('#stockout_table').DataTable().ajax.reload();
            } else if (response.status == 400) {
                Swal.fire({
                    title: 'Error',
                    text: response.message, 
                    icon: 'error',
                });
            }
        },
        error: function (xhr) {
            Swal.fire({
                title: 'Error',
                text: 'There was a problem processing your request.',
                icon: 'error',
            });
        }
    });
});

});


</script>
<style>
  .product-entry {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    background-color: #f9f9f9;
}
</style>
@endsection