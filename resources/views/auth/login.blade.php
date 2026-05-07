<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/logos/logo.png') }}">

  <title>
    Company A IMS | Login Page
  </title>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
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
<body class="bg-gray-200">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1 text-center">
                  <img src="{{asset('assets/img/logos/logo.png')}}" alt="System Logo" class="rounded-circle mb-4" width="150" height="150">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login Portal</h4>
                  <div class="row mt-3"></div>
                </div>
              </div>
              <div class="card-body">
                <form class="text-start" method="POST" action="{{ route('Credlogin') }}">
                    @csrf
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Email or Username</label>
                        <input id="login" type="text" name="login" :value="old('login')" required autofocus class="form-control">
                    </div>
                    <div class="input-group input-group-outline mb-2">
                        <label class="form-label">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control">
                    </div>
                    <div class="form-check form-check-inline mb-3 me-1" style="float: right;">
                        <input class="form-check-input" type="checkbox" id="showPassword">
                        <label class="form-check-label" for="showPassword">Show Password</label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Sign in</button>
                    </div>
                    <p class="mt-4 text-sm text-center">
                      Don't have an account?
                      <a href="/register" class="text-success text-gradient font-weight-bold">Sign up</a>
                    </p>
                </form>    
                <script>
                    document.getElementById('showPassword').addEventListener('change', function () {
                        const passwordInput = document.getElementById('password');
                        passwordInput.type = this.checked ? 'text' : 'password';
                    });
                </script>         
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>