<!-- Navbar -->
@if (session('success'))
    <div class="position-fixed top-0 end-0 p-2" style="z-index: 1050;">
        <div class="toast fade show bg-gradient-success" role="alert" aria-live="assertive" id="successToast"
            aria-atomic="true">
            <div class="toast-header bg-transparent border-0">
                <i class="material-icons text-white me-2">check_circle</i>
                <small class="text-white">Success</small>
                <i class="fas fa-times text-white ms-4 cursor-pointer" style="margin-left:200px !important;" data-bs-dismiss="toast" aria-label="Close"></i>
            </div>
            <hr class="horizontal light m-0">
            <div class="toast-body text-white">
                {{ session('success') }}
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#successToast').fadeOut('slow');
            }, 3000);
        });
    </script>
@endif

<style>
    .no-hover:hover{
        background-color:white !important;
    }
</style>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 border-radius-xl position-sticky mt-4 top-1 z-index-sticky mb-4 shadow-none" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
                @if(request()->is('users/create'))
                    <a class="opacity-5 text-dark" href="/users">List of Users</a>
                @elseif(request()->is('users/*/edit'))
                    <a class="opacity-5 text-dark" href="/users">List of Users</a>
                @else
                    <a class="opacity-5 text-dark" href="/dashboard">Dashboard</a>
                @endif
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                @if(request()->is('dashboard'))
                    Dashboard
                @elseif(request()->is('products/index'))
                    Products
                @elseif(request()->is('customer-orders'))
                    Customer Orders
                @elseif(request()->is('reports'))
                    Summary
                @elseif(request()->is('activity-logs'))
                    Activity Logs
                @elseif(request()->is('users'))
                    Users
                @elseif(request()->is('stock-in-products'))
                    Stock in Products
                @elseif(request()->is('critical-products'))
                    Critical Products
                @elseif(request()->is('profile'))
                    Profile
                @elseif(request()->is('users/create'))
                    Add User
                @elseif(request()->is('out-of-stocks'))
                    Out of Stock Products
                @elseif(request()->is('users/*/edit'))
                    Edit User 
                @elseif(request()->is('customer-transactions'))
                    Transactions 
                @elseif(request()->is('abc.index'))
                    ABC Analysis Reports 
                @elseif(request()->is('forecasting.index'))
                    Forecasting Demand Reports 
                @elseif(request()->is('eoq.index'))
                    EOQ Reports 
                @elseif(request()->is('rop.index'))
                    ROP Reports 
                @else
                    {{ $pageName ?? 'Page' }} 
                @endif
            </li>
        </ol>
        <h6 class="font-weight-bolder mb-0">
            @if(request()->is('dashboard'))
                Dashboard
            @elseif(request()->is('products/index'))
                Products
            @elseif(request()->is('customer-orders'))
                Customer Orders
            @elseif(request()->is('reports'))
                Summary
            @elseif(request()->is('activity-logs'))
                Activity Logs
            @elseif(request()->is('users'))
                Registered Users
            @elseif(request()->is('stock-in-products'))
                Stock in Products
            @elseif(request()->is('critical-products'))
                Critical Products
            @elseif(request()->is('profile'))
                Your Profile
            @elseif(request()->is('users/create'))
                Register User
            @elseif(request()->is('out-of-stocks'))
                Out of Stock Products
            @elseif(request()->is('users/*/edit'))
                Edit User 
            @elseif(request()->is('customer-transactions'))
                Transactions 
            @elseif(request()->is('abc.index'))
                ABC Analysis Reports 
            @elseif(request()->is('forecasting.index'))
                Forecasting Demand Reports 
            @elseif(request()->is('eoq.index'))
                EOQ Reports 
            @elseif(request()->is('rop.index'))
                ROP Reports 
            @else
                {{ $pageName ?? 'Page' }}
            @endif
        </h6>
      </nav>    
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
        <ul class="navbar-nav  justify-content-end">
            @if(Auth::user()->role == 0)
                {{-- <li class="nav-item d-flex align-items-center">
                    <a class="btn btn-outline-success btn-sm mb-0 me-3 ms-2" href="/reports">Reports</a>
                </li> --}}
            @endif
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
          <li class="nav-item px-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0">
              <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
            </a>
          </li>
          <li class="nav-item dropdown d-flex align-items-center">
            <a class="nav-link dropdown-toggle text-body font-weight-bold px-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if(!empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                    <img src="{{ asset(Auth::user()->image) }}" alt="profile_image" class="rounded-circle mb-2 me-2" width="30" height="30">
                @else
                    <img src="{{ asset('assets/img/drake.jpg') }}" alt="Default Avatar" class="rounded-circle mb-2 me-2" width="30" height="30">
                @endif
              <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item text-secondary font-weight-bold text-xs mt-1 mb-0 no-hover" href="#" style="cursor:auto">
                        @if(Auth::user()->role == 0)
                            Position: <span class="badge badge-sm bg-gradient-primary ">Admin</span>
                        @elseif(Auth::user()->role == 1)
                            Position: <span class="badge badge-sm bg-gradient-warning ">Staff</span>
                        @elseif(Auth::user()->role == 2)
                            Position: <span class="badge badge-sm bg-gradient-danger ">Seller</span>
                        @elseif(Auth::user()->role == 3)
                            Position: <span class="badge badge-sm bg-gradient-info ">Customer</span>
                        @else
                            Position: <span class="badge badge-sm bg-gradient-secondary ">Unknown</span>
                        @endif
                    </a>
                </li>
                <hr class="dark horizontal" style="background-color: black !important;">
                <li>
                    <a class="dropdown-item text-secondary font-weight-bold text-xs mt-1 mb-0" href="#" id="logout-btn">
                        <i class="fas fa-power-off me-2"></i> Logout
                    </a>
                </li>
            </ul>
          </li>
          
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>

        </ul>
        <script>
            document.getElementById('logout-btn').addEventListener('click', function (e) {
                e.preventDefault(); 
        
                Swal.fire({
                    title: 'Are you sure you want to log out?',
                    text: "You will be logged out of your account.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, log me out'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit(); 
                    }
                });
            });
        </script>
      </div>
    </div>
</nav>
<!-- End Navbar -->