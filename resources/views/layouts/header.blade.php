<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/logos/logo.png') }}">

  <title>
    Company A Inventory Management System
  </title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <style>
    #sidenav-main {
        z-index: 1040; 
    }

    .modal {
        z-index: 1050; 
    }
    
    .btn-custom {
        padding: 10px 20px;
        font-size: 16px; 
    }

    .modal-inputs{
        border: solid 1px rgb(138, 138, 138);
    }

    .modal-inputs:focus{
        border: solid 1px rgb(138, 138, 138);
    }

    .modal-close-btn{
        box-shadow: 0 3px 3px 0 rgb(100 101 94), 0 3px 1px -2px rgb(125 125 125), 0 1px 5px 0 rgb(103 103 103) !important;
    }

  </style>
</head>

<body class="g-sidenav-show  bg-gray-200">