@include('layouts.header')
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.topbar')
    
        @if (session('success'))
            <div class="position-fixed top-0 end-0 p-2" style="z-index: 1050;">
                <div class="toast fade show bg-gradient-success" role="alert" aria-live="assertive" id="successToast"
                    aria-atomic="true">
                    <div class="toast-header bg-transparent border-0">
                        <i class="material-icons text-white me-2">check_circle</i>
                        <small class="text-white">Success</small>
                        <i class="fas fa-times text-white ms-4 cursor-pointer" style="margin-left:200px !important;"
                            data-bs-dismiss="toast" aria-label="Close"></i>
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
        @yield('content')
    </main>
@include('layouts.footer')