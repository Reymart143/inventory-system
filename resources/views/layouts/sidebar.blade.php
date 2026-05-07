<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" / ">
        <img src="{{asset('assets/img/logos/logo.png')}}" class="navbar-brand-img h-100 rounded-circle" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">Company A IMS</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        @if(Auth::user()->role == 0)
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('dashboard') ? 'active bg-gradient-success' : '' }}" href="/dashboard">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Activities</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('products/index') ? 'active bg-gradient-success' : '' }}" href="/products/index">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">store</i>
                        </div>
                        <span class="nav-link-text ms-1">My Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('stock-in-products') ? 'active bg-gradient-success' : '' }}" href="/stock-in-products">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">inventory</i>
                        </div>
                        <span class="nav-link-text ms-1">Stock In Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('critical-products') ? 'active bg-gradient-success' : '' }}" href="/critical-products">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">warning</i>
                        </div>
                        <span class="nav-link-text ms-1">Critical Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('out-of-stocks') ? 'active bg-gradient-success' : '' }}" href="/out-of-stocks">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">inventory_2</i>
                        </div>
                        <span class="nav-link-text ms-1">Out of Stocks</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('customer-orders') ? 'active bg-gradient-success' : '' }}" href="/customer-orders">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">shopping_cart</i>
                        </div>
                        <span class="nav-link-text ms-1">Customer Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('customer.list_customer') ? 'active bg-gradient-success' : '' }}" href="/customer.list_customer">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">List of Customer</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Management</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                       href="#" 
                       id="toggleReports">
                        <div class="d-flex align-items-center">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">assessment</i>
                            </div>
                            <span class="nav-link-text ms-1">Reports</span>
                        </div>
                        <i class="material-icons arrow-icon">expand_more</i>
                    </a>
                    
                    <div class="collapse" id="reportsDropdown" style="display: none;">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('reports') ? 'active bg-gradient-success' : '' }}" href="/reports">
                                    Summary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('abc.index') ? 'active bg-gradient-success' : '' }}" href="/abc.index">
                                    ABC Analysis
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('forecasting.index') ? 'active bg-gradient-success' : '' }}" href="/forecasting.index">
                                    Forecasting
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('eoq.index') ? 'active bg-gradient-success' : '' }}" href="/eoq.index">
                                    EOQ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('rop.index') ? 'active bg-gradient-success' : '' }}" href="/rop.index">
                                    ROP
                                </a>
                            </li>
                        </ul>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var reportsLink = document.getElementById('toggleReports');
                            var reportsDropdown = document.getElementById('reportsDropdown');
                            var arrowIcon = document.querySelector('.arrow-icon');
                    
                            // Check for active link and set dropdown display accordingly
                            var activeLink = reportsDropdown.querySelector('.nav-link.active');
                            if (activeLink) {
                                reportsDropdown.style.display = 'block';  
                                arrowIcon.classList.add('rotate');  
                            }
                    
                            reportsLink.addEventListener('click', function(e) {
                                e.preventDefault(); 
                                activeLink = reportsDropdown.querySelector('.nav-link.active');
                    
                                // Toggle dropdown visibility based on active link presence
                                if (!activeLink) {
                                    if (reportsDropdown.style.display === 'none' || reportsDropdown.style.display === '') {
                                        reportsDropdown.style.display = 'block'; 
                                        arrowIcon.classList.add('rotate'); 
                                    } else {
                                        reportsDropdown.style.display = 'none'; 
                                        arrowIcon.classList.remove('rotate');  
                                    }
                                }
                            });
                        });
                    </script>
                </li>
                
                <style>
                    .arrow-icon {
                        transition: transform 0.3s ease;
                    }
                
                    .rotate {
                        transform: rotate(180deg);
                    }
                </style>
                
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('activity-logs') ? 'active bg-gradient-success' : '' }}" href="/activity-logs">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">history</i>
                        </div>
                        <span class="nav-link-text ms-1">Activity Logs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('users') ? 'active bg-gradient-success' : '' }}" href="/users">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Users</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account Page</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('profile') ? 'active bg-gradient-success' : '' }}" href="/profile">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
            </ul>
            @elseif(Auth::user()->role == 1)
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('stock-in-products') ? 'active bg-gradient-success' : '' }}" href="/stock-in-products">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">inventory</i>
                        </div>
                        <span class="nav-link-text ms-1">Stock In Products</span>
                    </a>
                </li>
                
                {{-- <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('critical-products') ? 'active bg-gradient-success' : '' }}" href="/critical-products">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">warning</i>
                        </div>
                        <span class="nav-link-text ms-1">Critical Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('out-of-stocks') ? 'active bg-gradient-success' : '' }}" href="/out-of-stocks">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">inventory_2</i>
                        </div>
                        <span class="nav-link-text ms-1">Out of Stocks</span>
                    </a>
                </li> --}}
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Management</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center" 
                       href="#" 
                       id="toggleReports">
                        <div class="d-flex align-items-center">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">assessment</i>
                            </div>
                            <span class="nav-link-text ms-1">Reports</span>
                        </div>
                        <i class="material-icons arrow-icon">expand_more</i>
                    </a>
                    
                    <div class="collapse" id="reportsDropdown" style="display: none;">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('reports') ? 'active bg-gradient-success' : '' }}" href="/reports">
                                    Summary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('abc.index') ? 'active bg-gradient-success' : '' }}" href="/abc.index">
                                    ABC Analysis
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('forecasting.index') ? 'active bg-gradient-success' : '' }}" href="/forecasting.index">
                                    Forecasting
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('eoq.index') ? 'active bg-gradient-success' : '' }}" href="/eoq.index">
                                    EOQ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->is('rop.index') ? 'active bg-gradient-success' : '' }}" href="/rop.index">
                                    ROP
                                </a>
                            </li>
                        </ul>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var reportsLink = document.getElementById('toggleReports');
                            var reportsDropdown = document.getElementById('reportsDropdown');
                            var arrowIcon = document.querySelector('.arrow-icon');
                    
                            // Check for active link and set dropdown display accordingly
                            var activeLink = reportsDropdown.querySelector('.nav-link.active');
                            if (activeLink) {
                                reportsDropdown.style.display = 'block';  
                                arrowIcon.classList.add('rotate');  
                            }
                    
                            reportsLink.addEventListener('click', function(e) {
                                e.preventDefault(); 
                                activeLink = reportsDropdown.querySelector('.nav-link.active');
                    
                                if (!activeLink) {
                                    if (reportsDropdown.style.display === 'none' || reportsDropdown.style.display === '') {
                                        reportsDropdown.style.display = 'block'; 
                                        arrowIcon.classList.add('rotate'); 
                                    } else {
                                        reportsDropdown.style.display = 'none'; 
                                        arrowIcon.classList.remove('rotate');  
                                    }
                                }
                            });
                        });
                    </script>
                </li>
                
                <style>
                    .arrow-icon {
                        transition: transform 0.3s ease;
                    }
                
                    .rotate {
                        transform: rotate(180deg);
                    }
                </style>
                
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account Page</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('profile') ? 'active bg-gradient-success' : '' }}" href="/profile">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
            </ul>
        @elseif(Auth::user()->role == 2)
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('customer-orders') ? 'active bg-gradient-success' : '' }}" href="/customer-orders">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">shopping_cart</i>
                        </div>
                        <span class="nav-link-text ms-1">Customer Orders</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Management</h6>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('reports') ? 'active bg-gradient-success' : '' }}" href="/reports">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">assessment</i>
                        </div>
                        <span class="nav-link-text ms-1">Reports</span>
                    </a>
                </li>
                
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account Page</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('profile') ? 'active bg-gradient-success' : '' }}" href="/profile">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
            </ul>
        @elseif(Auth::user()->role == 3)
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('customer-transactions') ? 'active bg-gradient-success' : '' }}" href="/customer-transactions">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">account_balance_wallet</i>
                        </div>
                        <span class="nav-link-text ms-1">Transactions</span>
                    </a>
                </li>
                
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account Page</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('profile') ? 'active bg-gradient-success' : '' }}" href="/profile">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
            </ul>
        @else

        @endif
    </div>
</aside>