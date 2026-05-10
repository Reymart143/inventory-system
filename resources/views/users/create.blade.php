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
                <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h5 class="text-white text-capitalize ps-3">Registration Form</h5>
                </div>
            </div>
          <div class="card-body">
            <form role="form" enctype="multipart/form-data" action="{{ route('users.store') }}" method="POST" id="userForm">
                @csrf
            
                <h6 class="text-success">Personal Information</h6>
                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                </div>
            
                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}">
                </div>
            
                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" id="number" name="number" class="form-control" value="{{ old('number') }}" 
                           oninput="this.value = this.value.replace(/[^0-9+]/g, '');" required>
                </div>                
            
                <div class="input-group input-group-outline mb-3">
                    <label class="form-label me-4">Gender</label>
                    <div class="ms-4 d-flex mt-2">
                        <div class="form-check me-2 ms-4">
                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_male">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_female">Female</label>
                        </div>
                    </div>
                </div>
            
                <label class="form-label mb-0">Birthday</label>
                <div class="input-group input-group-outline mb-3">
                    <input type="date" id="birthday" name="birthday" class="form-control" value="{{ old('birthday') }}">
                </div>
            
                <label class="form-label mb-0">Position</label>
                <div class="input-group input-group-outline mb-3">
                    <select id="role" name="role" class="form-control" required>
                        <option value="">Select Position</option>
                        <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Staff</option>
                        {{-- <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Seller</option> --}}
                    </select>
                </div>
            
                <label class="form-label mb-0">Upload Image</label>
                <div class="input-group input-group-outline mb-3">
                    <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                    @if($errors->has('image'))
                        <div class="text-danger">{{ $errors->first('image') }}</div>
                    @endif
                </div>
            
                <h6 class="text-success mb-2">Account Information</h6>
                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}">
                </div>
                <div class="input-group input-group-outline mb-1">
                    <label class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="form-check form-check-inline ms-0 mb-3 me-1" style="float: right;">
                    <input class="form-check-input ms-0" type="checkbox" id="showPassword">
                    <label class="form-check-label" for="showPassword">Show Password</label>
                </div>
                <div class="input-group input-group-outline mb-1">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                </div>
                <div class="form-check form-check-inline mb-3 ms-0 me-1" style="float: right;">
                    <input class="form-check-input ms-0" type="checkbox" id="showConfirmPassword">
                    <label class="form-check-label" for="showPassword">Show Password</label>
                </div>
                <div class="col-md-12 mt-4 d-flex justify-content-between align-items-center">
                    <a href="/users" class="btn btn-lg bg-gradient-secondary btn-lg w-100 mt-4 mb-0 me-4" style="box-shadow: none;">Cancel</a>
                    <button type="submit" class="btn btn-lg bg-gradient-success btn-lg w-100 mt-4 mb-0">Register</button>
                </div>
            </form>
            <script>
                document.getElementById('showPassword').addEventListener('change', function () {
                    const passwordInput = document.getElementById('password');
                    passwordInput.type = this.checked ? 'text' : 'password';
                });

                document.getElementById('showConfirmPassword').addEventListener('change', function () {
                    const passwordInput = document.getElementById('confirm_password');
                    passwordInput.type = this.checked ? 'text' : 'password';
                });
            </script>             
          </div>
        </div>
      </div>
    </div>
</div>
@endsection