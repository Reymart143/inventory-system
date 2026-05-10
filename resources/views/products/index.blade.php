@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3 d-flex align-items-center">
              <h5 class="text-white text-capitalize ps-3 flex-grow-1">My Products</h5>
              <a href="javascript:void(0)" class="btn btn-primary me-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fa fa-plus me-2"></i>Add Products
              </a>
              
          </div>
         
          <div class="card-body px-0 pb-2">
            {{-- <form action="{{ route('product.excel') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                @csrf
                <label for="file" class="form-label" >Import Excel:</label>
                <div class="d-flex align-items-center">
                    <input type="file" name="file" id="file" class="form-control ps-2 modal-inputs " style="margin-left:2%" required>
                    <button class="btn btn-success mt-3 px-3 ps-2" type="submit" style="width:230px;margin-left: 2%"><i class="fa fa-download" ></i> Import Products</button>
                </div>
            </form> --}}
            <form id="filter-form" class="d-flex align-items-center">
                @csrf
                <label for="product_name" class="form-label" style="width:10%;">Filter By Product Name:</label>
                <select name="product_name_search" id="product_name_search" class="form-control ps-2 modal-inputs px-2" style="width:330px;">
                    <option value=""> --- ---</option>
                    
                </select>
            
              
            
                <button class="btn btn-primary mt-3 px-3 ps-2" type="submit" style="width:230px;margin-left: 2%">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </form>
            <div class="table-responsive p-0">
                <div class="input-group input-group-outline mb-3 mx-4">
                </div>
                <table class="table table-bordered table-striped" id="product_table">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Items</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Unit</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Holding Cost</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Ordering Cost</th>
                       <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Beginning Inventory</th>
                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Updated Inventory</th>
                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Daily Usage</th>
                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Ending Inventory</th>
                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Re-order Point</th>
                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tools</th>
                    </tr>
                    </thead>
                 
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- Add Product Modal-->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="productForm">
                    @csrf
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            {{-- <input type="text" class="form-control ps-2 modal-inputs" placeholder="Enter Product Name" id="" name="product_name" required> --}}
                                <select name="item_id" id="item_id" class="form-control ps-2 modal-inputs">
                                    <option value=""> --- ---</option>
                                      @foreach($items as $item)
                                        <option value="{{ $item->id }}" data-stocks="{{ $item->safety_stock }}" data-cost="{{ $item->item_cost }}">
                                            {{ $item->item_name }}
                                        </option>
                                    @endforeach
                                </select>
                            
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <select name="unit" id="unit" class="form-control ps-2 modal-inputs">
                                    <option value="" > --- ---</option>
                                    <option value="Meter"> Meter</option>
                                    <option value="Roll"> Roll</option>
                                    <option value="Millimeter"> Millimeter</option>
                                    <option value="Inches"> Inches</option>
                              
                            </select>
                        </div>
                    </div>
               <script>
                        document.getElementById('item_id').addEventListener('change', function () {
                            let selected = this.options[this.selectedIndex];
                            let cost = selected.getAttribute('data-cost');
                            let stocks = selected.getAttribute('data-stocks');
                            document.getElementById('item_cost').value = cost ?? '';
                             document.getElementById('safety_stock').value = stocks ?? '';
                        });
                        </script>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="item_cost" class="form-label">Item Cost</label>
                            <input readonly type="number" class="form-control ps-2 modal-inputs" placeholder="Enter Product Selling Price" id="item_cost" name="item_cost" >
                        </div>
                       
                        <div class="col-md-6 mb-3">
                            <label for="safety_stock" class="form-label">Safety Stocks</label>
                            <input readonly type="number" class="form-control ps-2 modal-inputs" placeholder="Enter Holding Cost" id="safety_stock" name="safety_stock" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="holding_cost" class="form-label">Holding Cost</label>
                            <input type="number" class="form-control ps-2 modal-inputs" placeholder="Enter Holding Cost" id="holding_cost" name="holding_cost" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplier_cost" class="form-label">Ordering Cost</label>
                            <input type="number" class="form-control ps-2 modal-inputs" placeholder="Ordering Cost" id="ordering_cost" name="ordering_cost">
                        </div>
                        
                
                    </div>
                    <div class="row">
                       <div class="col-md-6 mb-3">
                            <label for="supplier_cost" class="form-label">Beginning inventory</label>
                            <input type="number" class="form-control ps-2 modal-inputs" placeholder="Product Stock" id="beginning_inventory" name="beginning_inventory">
                        </div>
                      
                            <input type="hidden" class="form-control ps-2 modal-inputs" id="beginning_inventory_fixed" name="beginning_inventory_fixed">
                    <script>
                        $(document).ready(function () {

                            $('#beginning_inventory').on('input', function () {

                                let value = $(this).val();

                                if (value === '' || value === null) {
                                    $('#beginning_inventory_fixed').val('');
                                } else {
                                    $('#beginning_inventory_fixed').val(value);
                                }

                            });

                        });
                    </script>
                        <div class="col-md-6 mb-3">
                            <label for="supplier_cost" class="form-label">Re-order Point</label>
                            <input type="number" class="form-control ps-2 modal-inputs" placeholder="Set Re-order Point" id="reorder_point" name="reorder_point" required>
                        </div>
            
                    </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="holding_cost" class="form-label">Ordering Date</label>
                                <input type="date" class="form-control ps-2 modal-inputs" placeholder="Enter Ordering Date" id="ordering_date" name="ordering_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="supplier_cost" class="form-label">Arrival Date</label>
                                <input type="date" class="form-control ps-2 modal-inputs" placeholder="Arrival Date" id="arrival_date" name="arrival_date">
                            </div>
                            
                    
                        </div>
                    <div class="row">
                        {{--                        
                        <div class="col-md-6 mb-3">
                            <label for="productBarcode" class="form-label">Barcode</label>
                            <input type="file" class="form-control ps-2 modal-inputs" id="barcode" name="barcode" required>
                        </div> --}}
                    </div>
                </form>                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-close-btn" data-bs-dismiss="modal">Close</button>
                <button type="button" id="addproduct_btn" class="btn btn-info">Save Product</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#addproduct_btn').on('click', function (e) {
       e.preventDefault();
       console.log($('#product_name').val());
    console.log($('#weeks').val());
      // if (validateForm()) {
        var Productform = {
            'id': $('#hidden_id').val(),
            'item_id': $('#item_id').val(),
            'unit': $('#unit').val(),
            'holding_cost': $('#holding_cost').val(),
            'ordering_cost': $('#ordering_cost').val(),
            'arrival_date': $('#arrival_date').val(),
            'ordering_date': $('#ordering_date').val(),
            'beginning_inventory': $('#beginning_inventory').val(),
             'beginning_inventory_fixed': $('#beginning_inventory_fixed').val(),
            'reorder_point': $('#reorder_point').val()
            };
         
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '/create-product',
                data: Productform,
                dataType: 'json',
                success: function (response) {
                  $('#product_name').val(''),
                  $('#unit').val(''),
                  $('#ordering_cost').val('')
                  $('#holding_cost').val(''),
                  $('#beginning_inventory').val(''),
                  $('#reorder_point').val(''),

                  $('#addProductModal').modal('hide');
                    Swal.fire({
                        title: 'Created Successfully',
                        text: 'Successfully Added Products ',
                        icon: 'success',
                    });
                    
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('#product_table').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please input blank fields.',
                        icon: 'error',
                    });
                }
            });
    });
  
function editProductDetails(id) {
    $.ajax({
        url: "/product/edit/" + id,
        type: "GET",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function (data) {

            let result = data.result;

            // ID
            $('#edit_id').val(result.id);

            // Set item FIRST
            $('#edit_item_id').val(result.item_id);

            // Force update AFTER DOM selection is applied
            setTimeout(function () {
                $('#edit_item_id').trigger('change');
            }, 50);

            // Other fields
            $('#edit_unit').val(result.unit);
            $('#edit_holding_cost').val(result.holding_cost);
            $('#edit_ordering_cost').val(result.ordering_cost);
            $('#edit_ordering_date').val(result.ordering_date);
            $('#edit_arrival_date').val(result.arrival_date);
            $('#edit_beginning_inventory').val(result.beginning_inventory);
            $('#edit_reorder_point').val(result.reorder_point);

            // Show modal
            $('#editproductmodal').modal('show');

            // Update button
            $('#update_product_btn')
                .off('click')
                .on('click', function () {
                    updateProduct(result.id);
                });
        },

        error: function (xhr) {
            console.log(xhr.responseJSON);
        }
    });
}
$(document).ready(function () {

    $('#edit_item_id').on('change', function () {
        let selected = $(this).find(':selected');

        let cost = selected.data('cost');
        let stocks = selected.data('stocks');

        $('#edit_item_cost').val(cost || '');
        $('#edit_safety_stock').val(stocks || '');
    });

});
    // UPDATE FUNCTION
    function updateProduct(id) {
        var Updateform = {
            'id': id,
            'item_id': $('#edit_item_id').val(),
            'unit': $('#edit_unit').val(),
            'holding_cost': $('#edit_holding_cost').val(),
            'ordering_cost': $('#edit_ordering_cost').val(),
            'arrival_date': $('#edit_arrival_date').val(),
            'ordering_date': $('#edit_ordering_date').val(),
            'beginning_inventory': $('#edit_beginning_inventory').val(),
            'reorder_point': $('#edit_reorder_point').val(),
        };


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'post',
            url: '/product/update',
            data: Updateform,
            dataType: 'json',
            success: function (response) {
              $('#product_table').DataTable().ajax.reload();
              Swal.fire({
                  title: 'Successfully Updated',
                  text: 'This Product Information Is Now Update',
                  icon: 'success',
              });
            },
            error: function (error) {
                Swal.fire({
                title: 'Something Went Wrong ',
                text: 'Please Check you input fields',
                icon: 'error',
            });
            }
        });
       
    }
  function deleteProductDetails(id){
    Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.isConfirmed) {
              deleteProduct(id);
          } else {
              Swal.fire(
                  'Deletion canceled',
                  'The Product was not deleted.',
                  'info'
              )
          }
      });
    }

    function deleteProduct(id){
      $.ajax({
        url:"{{ url('delete/') }}/" + id,
        type: 'DELETE',

        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function(response){
          Swal.fire(
            'Deleted!',
            'The Product info has been deleted.',
            'success'
          ).then(() => {
            $('#product_table').DataTable().ajax.reload();
          });
        },
        error: function(xhr, status, error){
          Swal.fire(
            'Error!',
            'An error occured upon deleting the Product info.',
            'error'
          );
        }
      })
    }
    $(document).ready(function() {
    var productdataTable = $('#product_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('products.index') }}",
            data: function(d) {
                d.product_name = $('#product_name').val(); 
                d.weeks = $('#weeks').val(); 
            }
        },
        pageLength: 153,
        lengthMenu: [ 
            [153, 200, 500, 1000, 3000, 4000, 5000],
            [153, 200, 500, 1000, 3000, 4000, 5000] 
        ],
        columns: [
            {
                data: 'item_name',
                name: 'item_name',
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
                data: 'holding_cost',
                name: 'holding_cost',
                render: function(data) {
                   return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + parseFloat(data).toFixed(2) + '</div>';
                
                }
            },
            {
                data: 'ordering_cost',
                name: 'ordering_cost',
                render: function(data) {
                    return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + parseFloat(data).toFixed(2) + '</div>';
                }
            },
             {
                data: 'beginning_inventory_fixed',
                name: 'beginning_inventory_fixed',
                render: function(data) {
                       return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
                }
            },
            {
                data: 'beginning_inventory',
                name: 'beginning_inventory',
                render: function(data) {
                       return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
                }
            },
           
            {
                data: 'daily_usage',
                name: 'daily_usage',
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
            {
                data: 'reorder_point',
                name: 'reorder_point',
                render: function(data) {
                    return '<span class="badge badge-sm bg-gradient-warning" class="text-warning">' + data + '</span>';
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
      }); 
   
});

</script>
<!-- Edit Product Modal-->
<div class="modal fade" id="editproductmodal" tabindex="-1" aria-labelledby="editproductmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="editproductmodalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
    @csrf

    <input type="hidden" id="edit_id" name="id">

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Product Name</label>

            <select name="edit_item_id" id="edit_item_id" class="form-control ps-2 modal-inputs">
                <option value="">--- ---</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}"
                        data-stocks="{{ $item->safety_stock }}"
                        data-cost="{{ $item->item_cost }}">
                        {{ $item->item_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Unit</label>

            <select name="edit_unit" id="edit_unit" class="form-control ps-2 modal-inputs">
                <option value="">--- ---</option>
                <option value="Meter">Meter</option>
                <option value="Roll">Roll</option>
                <option value="Millimeter">Millimeter</option>
                <option value="Inches">Inches</option>
            </select>
        </div>

    </div>

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Item Cost</label>
            <input readonly type="number" class="form-control ps-2 modal-inputs"
                   id="edit_item_cost" name="edit_item_cost">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Safety Stocks</label>
            <input readonly type="number" class="form-control ps-2 modal-inputs"
                   id="edit_safety_stock" name="edit_safety_stock">
        </div>

    </div>

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Holding Cost</label>
            <input type="number" class="form-control ps-2 modal-inputs"
                   id="edit_holding_cost" name="edit_holding_cost">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Ordering Cost</label>
            <input type="number" class="form-control ps-2 modal-inputs"
                   id="edit_ordering_cost" name="edit_ordering_cost">
        </div>

    </div>

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Beginning Inventory</label>
            <input type="number" class="form-control ps-2 modal-inputs"
                   id="edit_beginning_inventory" name="edit_beginning_inventory">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Re-order Point</label>
            <input type="number" class="form-control ps-2 modal-inputs"
                   id="edit_reorder_point" name="edit_reorder_point">
        </div>

    </div>
       <div class="row">
        <div class="col-md-6 mb-3">
            <label for="holding_cost" class="form-label">Ordering Date</label>
            <input type="date" class="form-control ps-2 modal-inputs" placeholder="Enter Ordering Date" id="edit_ordering_date" name="edit_ordering_date" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="supplier_cost" class="form-label">Arrival Date</label>
            <input type="date" class="form-control ps-2 modal-inputs" placeholder="Arrival Date" id="edit_arrival_date" name="edit_arrival_date">
        </div>
        

    </div>
</form>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-close-btn" data-bs-dismiss="modal">Close</button>
                <button type="button" id="update_product_btn" class="btn btn-info">Update Product</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Product Script-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-product').forEach(function(button) {
            button.addEventListener('click', function() {
                const productId = button.getAttribute('data-id'); 
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this product!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + productId).submit();
                    }
                });
            });
        });
    });
</script>
@endsection