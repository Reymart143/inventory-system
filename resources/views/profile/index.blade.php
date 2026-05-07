@extendS('layouts.app')

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
<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
      <span class="mask bg-gradient-success  opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
      <div class="row gx-4 mb-2">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            @if(!empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                <img src="{{ asset(Auth::user()->image) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            @else
                <img src="{{ asset('assets/img/drake.jpg') }}" alt="Default Avatar" class="w-100 border-radius-lg shadow-sm">
            @endif
          </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1">
              {{ Auth::user()->name ?? 'N/A' }}
            </h5>
            @if(Auth::user()->role == 0)
                <p class="mb-0 font-weight-normal text-sm">Admin</p>
            @elseif(Auth::user()->role == 1)
                <p class="mb-0 font-weight-normal text-sm">Staff</p>
            @elseif(Auth::user()->role == 2)
                <p class="mb-0 font-weight-normal text-sm">Seller</p>
            @elseif(Auth::user()->role == 3)
                <p class="mb-0 font-weight-normal text-sm">Customer</p>
            @else
                <p class="mb-0 font-weight-normal text-sm">Unknown</p>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="row">
          @if(Auth::user()->role == 1 || Auth::user()->role == 2)
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Personal Information</h6>
                    </div>
                    <div class="col-md-4 text-end">
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editPersonalInfoModal">
                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">Mobile:</strong> &nbsp; {{ Auth::user()->number ?? 'N/A' }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">Location:</strong> &nbsp; {{ Auth::user()->address ?? 'N/A' }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">Birthday:</strong> &nbsp; 
                        {{ Auth::user()->birthday ? \Carbon\Carbon::parse(Auth::user()->birthday)->format('F j, Y') : 'N/A' }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">Gender:</strong> &nbsp; {{ Auth::user()->gender ?? 'N/A' }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Account Information</h6>
                    </div>
                    <div class="col-md-4 text-end">
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editAccountInfoModal">
                        <i class="fas fa-cog text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Account Settings"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; {{ Auth::user()->email ?? 'N/A' }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Username:</strong> &nbsp; {{ Auth::user()->username ?? 'N/A' }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                      <strong class="text-dark">Password: *********</strong> 
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Additional Information</h6>
                    </div>
                    <div class="col-md-4 text-end">
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editEmergencyContactModal">
                        <i class="fas fa-phone-alt text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Emergency Contact"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Emergency Contact Name:</strong> &nbsp; {{ Auth::user()->contact_name ?? 'N/A' }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Emergency Contact Name:</strong> &nbsp; {{ Auth::user()->contact_number ?? 'N/A' }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Relationship:</strong> &nbsp; {{ Auth::user()->relationship ?? 'N/A' }}</li>
                  </ul>
                </div>
              </div>
            </div>
          @else
            <div class="col-12 col-xl-6">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Personal Information</h6>
                    </div>
                    <div class="col-md-4 text-end">
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editPersonalInfoModal">
                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">Mobile:</strong> &nbsp; {{ Auth::user()->number ?? 'N/A' }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">Location:</strong> &nbsp; {{ Auth::user()->address ?? 'N/A' }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">Birthday:</strong> &nbsp; 
                        {{ Auth::user()->birthday ? \Carbon\Carbon::parse(Auth::user()->birthday)->format('F j, Y') : 'N/A' }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">Gender:</strong> &nbsp; {{ Auth::user()->gender ?? 'N/A' }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-6">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Account Information</h6>
                    </div>
                    <div class="col-md-4 text-end">
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editAccountInfoModal">
                        <i class="fas fa-cog text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Account Settings"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; {{ Auth::user()->email ?? 'N/A' }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Username:</strong> &nbsp; {{ Auth::user()->username ?? 'N/A' }}</li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                      <strong class="text-dark">Password: *********</strong> 
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
</div>
<!-- Edit Personal Info Modal -->
<div class="modal fade" id="editPersonalInfoModal" tabindex="-1" aria-labelledby="editPersonalInfoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="editPersonalInfoLabel">Edit Personal Information</h5>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button> 
      </div>
      <form id="editPersonalInfoForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control px-2" id="name" name="name" value="{{ Auth::user()->name }}" style="border: solid 1px rgb(138, 138, 138);">
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">Mobile</label>
                <input type="text" class="form-control px-2" id="number" name="number" value="{{ Auth::user()->number }}" style="border: solid 1px rgb(138, 138, 138);">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Location</label>
                <input type="text" class="form-control px-2" id="address" name="address" value="{{ Auth::user()->address }}" style="border: solid 1px rgb(138, 138, 138);">
            </div>
            <div class="mb-3">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control px-2" id="birthday" name="birthday" value="{{ Auth::user()->birthday }}" style="border: solid 1px rgb(138, 138, 138);">
            </div>
            <div class="input-group input-group-outline mb-3">
                <label class="form-label me-4">Gender</label>
                <div class="ms-4 d-flex mt-2">
                    <div class="form-check me-2 ms-4">
                        <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender_male">Male</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender_female">Female</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control px-2" id="image" name="image" style="border: solid 1px rgb(138, 138, 138);">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="box-shadow: 0 3px 3px 0 rgb(100 101 94), 0 3px 1px -2px rgb(125 125 125), 0 1px 5px 0 rgb(103 103 103) !important;">Close</button>
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Account Info Modal -->
<div class="modal fade" id="editAccountInfoModal" tabindex="-1" aria-labelledby="editAccountInfoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="editAccountInfoLabel">Edit Account Information</h5>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
          <i class="material-icons">close</i>
        </button> 
      </div>
      <form id="editAccountInfoForm" method="POST" action="{{ route('account.update') }}">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control px-2" id="email" name="email" value="{{ Auth::user()->email }}" style="border: solid 1px rgb(138, 138, 138);">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control px-2" id="username" name="username" value="{{ Auth::user()->username }}" style="border: solid 1px rgb(138, 138, 138);">
            </div>
            <hr class="dark horizontal mt-2" style="background-color:gray !important;">
            <div class="mb-3">
                <label for="old_password" class="form-label">Old Password</label>
                <input type="password" class="form-control px-2" id="old_password" name="old_password" style="border: solid 1px rgb(138, 138, 138);" placeholder="Enter Old Password">
                <p class="text-xs text-danger mt-2">Leave Blank if you don't want to change your password</p>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control px-2" id="new_password" name="new_password" style="border: solid 1px rgb(138, 138, 138);" placeholder="Enter New Password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control px-2" id="confirm_password" name="confirm_password" style="border: solid 1px rgb(138, 138, 138);" placeholder="Confirm Password">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="box-shadow: 0 3px 3px 0 rgb(100 101 94), 0 3px 1px -2px rgb(125 125 125), 0 1px 5px 0 rgb(103 103 103) !important;">Close</button>
            <button type="submit" class="btn btn-success">Save changes</button>
        </div>
      </form>    
    </div>
  </div>
</div>
<!-- Edit Emergency Contact Modal -->
<div class="modal fade" id="editEmergencyContactModal" tabindex="-1" aria-labelledby="editEmergencyContactModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <form id="editEmergencyContactForm" method="POST" action="{{ route('emergency.contact.update') }}">
          @csrf
          @method('PUT')
          <div class="modal-content">
              <div class="modal-header bg-success">
                  <h5 class="modal-title text-white" id="editEmergencyContactModalLabel">Edit Emergency Contact</h5>
                  <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                  </button> 
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="contact_name" class="form-label">Emergency Contact Name</label>
                      <input type="text" class="form-control px-2" id="contact_name" name="contact_name" value="{{ Auth::user()->contact_name }}" style="border: solid 1px rgb(138, 138, 138);">
                  </div>
                  <div class="mb-3">
                      <label for="contact_number" class="form-label">Emergency Contact Number</label>
                      <input type="text" class="form-control px-2" id="contact_number" name="contact_number" value="{{ Auth::user()->contact_number }}" style="border: solid 1px rgb(138, 138, 138);">
                  </div>
                  <div class="mb-3">
                      <label for="relationship" class="form-label">Relationship</label>
                      <input type="text" class="form-control px-2" id="relationship" name="relationship" value="{{ Auth::user()->relationship }}" style="border: solid 1px rgb(138, 138, 138);">
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="box-shadow: 0 3px 3px 0 rgb(100 101 94), 0 3px 1px -2px rgb(125 125 125), 0 1px 5px 0 rgb(103 103 103) !important;">Close</button>
                  <button type="submit" class="btn btn-success">Save changes</button>
              </div>
          </div>
      </form>
  </div>
</div>


@endsection