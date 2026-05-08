@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <h5 class="text-white text-capitalize ps-3">Daily Usage Form</h5>
                </div>
            </div>
          <div class="card-body">
          <form role="form" action="{{ route('dailyusage.update') }}" method="POST" id="userForm">

    @csrf
    @method('PUT')

    <input type="hidden" name="id" value="{{ $daily->id }}">

    <label class="form-label">Item Name</label>

    <div class="input-group input-group-outline mb-3">

        <select name="item_id" id="item_id" class="form-control ps-2 modal-inputs">

            <option value=""> </option>

            @foreach($items as $item)

                <option value="{{ $item->id }}"
                    {{ $daily->item_id == $item->id ? 'selected' : '' }}>

                    {{ $item->item_name }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="card p-3 mb-3">

        <h6>Product Info</h6>

        <p>
            <strong>Beginning Inventory:</strong>
            <span id="info_beginning">-</span>
        </p>

        <p>
            <strong>Holding Cost:</strong>
            <span id="info_holding">-</span>
        </p>

        <p>
            <strong>Ordering Cost:</strong>
            <span id="info_ordering">-</span>
        </p>

    </div>

        <label class="form-label">Daily Usage</label>
    <div class="input-group input-group-outline mb-3">


        <input
            type="number"
            id="daily_usage"
            name="daily_usage"
            class="form-control"
            value="{{ $daily->daily_usage }}"
        >

    </div>

    <small id="usage_error" class="text-danger mb-3"></small>

    <br>

    <label class="form-label">Recent Stocks</label>

    <div class="input-group input-group-outline mb-3">

        <input
            readonly
            type="number"
            id="total_recent_stock"
            name="total_recent_stock"
            class="form-control"
            value="{{ $daily->total_recent_stock }}"
        >

    </div>

    <label class="form-label">Date Used</label>

    <div class="input-group input-group-outline mb-3">

        <input
            type="date"
            id="date"
            name="date"
            class="form-control"
            value="{{ $daily->date }}"
        >

    </div>

    <div class="col-md-12 mt-4 d-flex justify-content-between align-items-center">

        <a href="/dailyusage/index"
           class="btn btn-lg bg-gradient-secondary btn-lg w-100 mt-4 mb-0 me-4"
           style="box-shadow: none;">

            Cancel

        </a>

        <button type="submit"
                class="btn btn-lg bg-gradient-success btn-lg w-100 mt-4 mb-0">

            Update

        </button>

    </div>

</form>


<script>

$(document).ready(function () {

    // LOAD PRODUCT INFO
    function loadProductInfo(id) {

        if (!id) {

            $('#info_beginning').text('-');
            $('#info_holding').text('-');
            $('#info_ordering').text('-');

            return;
        }

        $.ajax({

            url: '/product/info/' + id,
            type: 'GET',

            success: function (data) {

                $('#info_beginning').text(data.beginning_inventory ?? '-');
                $('#info_holding').text(data.holding_cost ?? '-');
                $('#info_ordering').text(data.ordering_cost ?? '-');

                calculateRemaining();

            },

            error: function (xhr) {

                console.log(xhr.responseText);

            }

        });
    }


    // CALCULATE REMAINING STOCK
    function calculateRemaining() {

        let usage = parseFloat($('#daily_usage').val()) || 0;

        let beginning = parseFloat($('#info_beginning').text()) || 0;

        let remaining = beginning - usage;

        if (remaining < 0) {

            remaining = 0;

            $('#daily_usage').val(beginning);

            $('#usage_error').text('Cannot exceed Beginning Inventory');

        } else {

            $('#usage_error').text('');

        }

        $('#total_recent_stock').val(remaining);
    }


    // ITEM CHANGE
    $('#item_id').on('change', function () {

        loadProductInfo($(this).val());

    });


    // DAILY USAGE CHANGE
    $('#daily_usage').on('input', function () {

        calculateRemaining();

    });


    // AUTO LOAD ON EDIT
    loadProductInfo($('#item_id').val());

});

</script>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection