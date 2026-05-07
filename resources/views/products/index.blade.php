@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex align-items-center">
              <h5 class="text-white text-capitalize ps-3 flex-grow-1">My Products</h5>
              <a href="javascript:void(0)" class="btn btn-primary me-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fa fa-plus me-2"></i>Add Products
              </a>
              
          </div>
         
          <div class="card-body px-0 pb-2">
            <form action="{{ route('product.excel') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                @csrf
                <label for="file" class="form-label" >Import Excel:</label>
                <div class="d-flex align-items-center">
                    <input type="file" name="file" id="file" class="form-control ps-2 modal-inputs " style="margin-left:2%" required>
                    <button class="btn btn-success mt-3 px-3 ps-2" type="submit" style="width:230px;margin-left: 2%"><i class="fa fa-download" ></i> Import Products</button>
                </div>
            </form>
            <form id="filter-form" class="d-flex align-items-center">
                @csrf
                <label for="product_name" class="form-label" style="width:10%;">Filter By Product Name:</label>
                <select name="product_name_search" id="product_name_search" class="form-control ps-2 modal-inputs px-2" style="width:330px;">
                    <option value=""> --- ---</option>
                    
                    {{-- Flour 1 to 19 --}}
                    @for ($i = 1; $i <= 21; $i++)
                        <option value="Flour {{ $i }}">Flour {{ $i }}</option>
                    @endfor
                
                    {{-- Sugar 1 to 11 --}}
                    @for ($i = 1; $i <= 11; $i++)
                        <option value="Sugar {{ $i }}">Sugar {{ $i }}</option>
                    @endfor
                
                    {{-- Dairy & Oils 1 to 10 --}}
                    @for ($i = 1; $i <= 25; $i++)
                        <option value="Dairy & Oils {{ $i }}">Dairy & Oils {{ $i }}</option>
                    @endfor
                
                    {{-- Others 1 to 6 --}}
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="Others {{ $i }}">Others {{ $i }}</option>
                    @endfor
                
                    {{-- Leaving Agent 1 to 12 --}}
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="Leaving Agent {{ $i }}">Leaving Agent {{ $i }}</option>
                    @endfor
                
                    {{-- Add Ins 1 to 21 --}}
                    @for ($i = 1; $i <= 21; $i++)
                        <option value="Add Ins {{ $i }}">Add Ins {{ $i }}</option>
                    @endfor
                
                    {{-- Paper & Plastic 1 to 56 --}}
                    @for ($i = 1; $i <= 56; $i++)
                        <option value="Paper & Plastic {{ $i }}">Paper & Plastic {{ $i }}</option>
                    @endfor
                </select>
            
                <label for="weeks" class="form-label" style=";width:6%" >Filter By Week:</label>
                <select name="weeks_search" id="weeks_search" class="form-select px-2" style="margin-left:2%;width:330px">
                    <option value="">Select Week</option>
                    @for ($i = 1; $i <= 500; $i++)
                        <option value="Week {{ $i }}">Week {{ $i }}</option>
                    @endfor
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
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="productForm">
                    @csrf
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Week</label>
                        {{-- <input type="text" class="form-control ps-2 modal-inputs" placeholder="Enter Product Name" id="" name="product_name" required> --}}
                        <select name="weeks" id="weeks" class="form-control ps-2 modal-inputs">
                            <option value="" > --- ---</option>
                            @for ($i = 1; $i <= 31; $i++)
                            <option value="Week {{ $i }}">Week {{ $i }}</option>
                        @endfor                        
                    </select>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            {{-- <input type="text" class="form-control ps-2 modal-inputs" placeholder="Enter Product Name" id="" name="product_name" required> --}}
                            <select name="product_name" id="product_name" class="form-control ps-2 modal-inputs">
                                <option value=""> --- ---</option>
                                
                                @for ($i = 1; $i <= 21; $i++)
                                    <option value="Flour {{ $i }}">Flour {{ $i }}</option>
                                @endfor
                            
                                @for ($i = 1; $i <= 11; $i++)
                                    <option value="Sugar {{ $i }}">Sugar {{ $i }}</option>
                                @endfor
                            
                                @for ($i = 1; $i <= 25; $i++)
                                    <option value="Dairy & Oils {{ $i }}">Dairy & Oils {{ $i }}</option>
                                @endfor
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="Others {{ $i }}">Others {{ $i }}</option>
                                @endfor
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="Leaving Agent {{ $i }}">Leaving Agent {{ $i }}</option>
                                @endfor
                                @for ($i = 1; $i <= 21; $i++)
                                    <option value="Add Ins {{ $i }}">Add Ins {{ $i }}</option>
                                @endfor
                            
                                @for ($i = 1; $i <= 56; $i++)
                                    <option value="Paper & Plastic {{ $i }}">Paper & Plastic {{ $i }}</option>
                                @endfor
                            </select>
                            
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <select name="unit" id="unit" class="form-control ps-2 modal-inputs">
                                    <option value="" > --- ---</option>
                                    <option value="Sack"> Sack</option>
                                    <option value="Kilo"> Kilo</option>
                                    <option value="Cont"> Cont</option>
                                    <option value="Btl"> Btl</option>
                                    <option value="Pcs"> Pcs</option>
                                    <option value="Galloon"> Galloon</option>
                                    <option value="Box"> Box</option>
                                    <option value="Pack"> Pack</option>
                                    <option value="Bdl"> Bdl</option>
                                    <option value="Ream"> Ream</option>
                                    <option value="Can"> Can</option>
                                    <option value="Pail"> Pail</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="selling_price" class="form-label">Selling Price</label>
                            <input type="number" class="form-control ps-2 modal-inputs" placeholder="Enter Product Selling Price" id="selling_price" name="selling_price" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplier_cost" class="form-label">Profit</label>
                            <input type="number" class="form-control ps-2 modal-inputs" placeholder="Enter Profit" id="profit" name="profit" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="supplier_cost" class="form-label">Beginning inventory</label>
                            <input type="number" class="form-control ps-2 modal-inputs" placeholder="Product Stock" id="beginning_inventory" name="beginning_inventory">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplier_cost" class="form-label">Re-order Point</label>
                            <input type="number" class="form-control ps-2 modal-inputs" placeholder="Set Re-order Point" id="reorder_point" name="reorder_point" required>
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
                <button type="button" id="addproduct_btn" class="btn btn-success">Save Product</button>
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
            'product_name': $('#product_name').val(),
            'unit': $('#unit').val(),
            'weeks': $('#weeks').val(),
            'profit': $('#profit').val(),
            'selling_price': $('#selling_price').val(),
            'beginning_inventory': $('#beginning_inventory').val(),
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
                  $('#profit').val('')
                  $('#selling_price').val(''),
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
  

    function editProductDetails(id){
        $.ajax({
            url: "/product/edit/" + id + "/",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                $('#edit_product_name').val(data.result.product_name);

                    if (data.result.weeks) {
                        $('#edit_weeks').val(data.result.weeks);
                    }
                $('#edit_unit').val(data.result.unit)
                $('#edit_profit').val(data.result.profit)
                $('#edit_selling_price').val(data.result.selling_price);
                $('#edit_beginning_inventory').val(data.result.beginning_inventory);
                $('#edit_reorder_point').val(data.result.reorder_point);

                $('#update_product_btn').val('Update');
                $('#action').val('Edit');
                $('#editproductmodal').modal('show');
                $('#update_product_btn').off('click').on('click', function () {
                    updateProduct(id);
                });
                edit_updateProductTypeOptions();
            },
            error: function (data) {
                var errors = data.responseJSON;
            }
        });

    }
    // UPDATE FUNCTION
    function updateProduct(id) {
        var Updateform = {
            'id': id,
            'product_name': $('#edit_product_name').val(),
            'weeks': $('#edit_weeks').val(),
            'unit': $('#edit_unit').val(),
            'profit': $('#edit_profit').val(),
            'selling_price': $('#edit_selling_price').val(),
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
                    return '<div style="flex: 1; white-space: nowrap;" class="text-dark">' + data + '</div>';
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
                data: 'beginning_inventory',
                name: 'beginning_inventory',
                render: function(data) {
                    return '<div style="flex: 1; white-space: nowrap;" class="text-info">' + parseFloat(data).toFixed(2) + '</div>';
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
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="editproductmodalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Week</label>
                        {{-- <input type="text" class="form-control ps-2 modal-inputs" placeholder="Enter Product Name" id="" name="product_name" required> --}}
                        <select name="edit_weeks" id="edit_weeks" class="form-control ps-2 modal-inputs">
                            <option value="" > --- ---</option>
                            @for ($i = 1; $i <= 31; $i++)
                            <option value="Week {{ $i }}">Week {{ $i }}</option>
                        @endfor                        
                    </select>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            {{-- <input type="text" class="form-control ps-2 modal-inputs" placeholder="Enter Product Name" id="" name="product_name" required> --}}
                            <select name="edit_product_name" id="edit_product_name" class="form-control ps-2 modal-inputs">
                                <option value=""> --- ---</option>
                                
                                {{-- Flour 1 to 19 --}}
                                @for ($i = 1; $i <= 21; $i++)
                                    <option value="Flour {{ $i }}">Flour {{ $i }}</option>
                                @endfor
                            
                                {{-- Sugar 1 to 11 --}}
                                @for ($i = 1; $i <= 11; $i++)
                                    <option value="Sugar {{ $i }}">Sugar {{ $i }}</option>
                                @endfor
                            
                                {{-- Dairy & Oils 1 to 10 --}}
                                @for ($i = 1; $i <= 25; $i++)
                                    <option value="Dairy & Oils {{ $i }}">Dairy & Oils {{ $i }}</option>
                                @endfor
                            
                                {{-- Others 1 to 6 --}}
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="Others {{ $i }}">Others {{ $i }}</option>
                                @endfor
                            
                                {{-- Leaving Agent 1 to 12 --}}
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="Leaving Agent {{ $i }}">Leaving Agent {{ $i }}</option>
                                @endfor
                            
                                {{-- Add Ins 1 to 21 --}}
                                @for ($i = 1; $i <= 21; $i++)
                                    <option value="Add Ins {{ $i }}">Add Ins {{ $i }}</option>
                                @endfor
                            
                                {{-- Paper & Plastic 1 to 56 --}}
                                @for ($i = 1; $i <= 56; $i++)
                                    <option value="Paper & Plastic {{ $i }}">Paper & Plastic {{ $i }}</option>
                                @endfor
                            </select>
                            
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <select name="unit" id="edit_unit" class="form-control ps-2 modal-inputs">
                                    <option value="" > --- ---</option>
                                    <option value="Sack">Sack</option>
                                    <option value="Kilo">Kilo</option>
                                    <option value="Cont">Cont</option>
                                    <option value="Btl">Btl</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Galloon">Galloon</option>
                                    <option value="Box">Box</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Bdl">Bdl</option>
                                    <option value="Ream">Ream</option>
                                    <option value="Can">Can</option>
                                    <option value="Pail">Pail</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="selling_price" class="form-label">Selling Price</label>
                            <input type="number" class="form-control ps-2 modal-inputs" id="edit_selling_price" name="edit_selling_price" value="{{ old('selling_price') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplier_cost" class="form-label">Profit</label>
                            <input type="number" class="form-control ps-2 modal-inputs" id="edit_profit" name="edit_profit" value="{{ old('supplier_cost') }}" required>
                        </div>
                
                     
                    </div>
                
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="profit" class="form-label">Beginning inventory</label>
                            <input type="number" class="form-control ps-2 modal-inputs" id="edit_beginning_inventory" name="edit_beginning_inventory" value="{{ old('profit') }}" required>
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <label for="profit" class="form-label">Re-order point</label>
                            <input type="number" class="form-control ps-2 modal-inputs" id="edit_reorder_point" name="edit_reorder_point" value="{{ old('profit') }}" required>
                        </div>
                    </div>
                </form>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-close-btn" data-bs-dismiss="modal">Close</button>
                <button type="button" id="update_product_btn" class="btn btn-success">Update Product</button>
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