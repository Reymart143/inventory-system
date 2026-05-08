@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="position-fixed top-0 end-0 p-2" style="z-index: 1050;">
        <div class="toast fade show bg-gradient-danger" role="alert" aria-live="assertive" id="errorToast"
            aria-atomic="true">
            <div class="toast-header bg-transparent border-0">
                <i class="material-icons text-white me-2">notifications</i>
                <small class="text-white">Login Error</small>
                <i class="fas fa-times text-white ms-4 cursor-pointer" style="margin-left:200px !important;"
                    data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <hr class="horizontal light m-0">
            <div class="toast-body text-white">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#errorToast').fadeOut('slow');
            }, 3000);
        });
    </script>
@endif
<div class="container-fluid py-4">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="col-6">
        <div class="card my4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h5 class="text-white text-capitalize ps-3">Items Form</h5>
                </div>
            </div>
          <div class="card-body">
            <form role="form" action="{{ route('items.update', $item->id) }}" method="POST" id="userForm">
          
                @csrf
              @method('PUT')
                <h6 class="text-success">Personal Information</h6>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="item_name" class="me-3" style="width: 120px;">
                            Item Name
                        </label>

                        <input type="text"
                            id="item_name"
                            name="item_name"
                            class="form-control"
                            value="{{ $item->item_name }}">
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="item_cost" class="me-3" style="width: 120px;">
                            Item Cost
                        </label>

                        <input type="text"
                            id="item_cost"
                            name="item_cost"
                            class="form-control"
                            value="{{ $item->item_cost }}">
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="safety_stock" class="me-3" style="width: 120px;">
                            Safety Stocks
                        </label>

                        <input type="number"
                            id="safety_stock"
                            name="safety_stock"
                            class="form-control"
                            value="{{ $item->safety_stock }}">
                    </div>
                {{-- <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Ordering Date</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}">
                </div>
            
                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Arrival Date</label>
                    <input type="text" id="number" name="number" class="form-control" value="{{ old('number') }}" Soninput="this.value = this.value.replace(/[^0-9+]/g, '');" required>
                </div>                
             --}}
       
                <div class="col-md-12 mt-4 d-flex justify-content-between align-items-center">
                    <a href="/items" class="btn btn-lg bg-gradient-secondary btn-lg w-100 mt-4 mb-0 me-4" style="box-shadow: none;">Cancel</a>
                    <button type="submit" class="btn btn-lg bg-gradient-success btn-lg w-100 mt-4 mb-0">Update</button>
                </div>
            </form>
            {{-- <script>
                document.getElementById('showPassword').addEventListener('change', function () {
                    const passwordInput = document.getElementById('password');
                    passwordInput.type = this.checked ? 'text' : 'password';
                });

                document.getElementById('showConfirmPassword').addEventListener('change', function () {
                    const passwordInput = document.getElementById('confirm_password');
                    passwordInput.type = this.checked ? 'text' : 'password';
                });
            </script>              --}}
          </div>
        </div>
      </div>
    </div>
</div>
@endsection