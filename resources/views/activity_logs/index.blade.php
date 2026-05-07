@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
              <h5 class="text-white text-capitalize ps-3">Activity Logs</h5>
            </div>
          </div>
          <div class="card-body px-3 pb-2"> 
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="mb-0 text-sm ps-7">Name</th> 
                            <th class="mb-0 text-sm ps-7">Position</th> 
                            <th class="mb-0 text-sm ps-7">Login Time</th> 
                            <th class="mb-0 text-sm ps-7">Logout Time</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                          <tr>
                            <td>
                              <div class="d-flex align-items-center px-2 py-1">
                                  <div>
                                      <img src="{{ asset($log->user->image) }}" class="avatar avatar-sm me-3 border-radius-lg" alt="{{ $log->user->name ?? 'User' }}">
                                  </div>                                    
                                  <div class="d-flex flex-column justify-content-center">
                                      <h6 class="mb-0 text-sm">{{ $log->user->name ?? 'N/A' }}</h6>
                                      <p class="text-xs text-secondary mb-0">{{ $log->user->number ?? 'N/A' }}</p>
                                      <p class="text-xs text-secondary mb-0">{{ $log->user->email ?? 'N/A' }}</p>
                                  </div>
                              </div>
                            </td>
                              <td class="ps-7">
                                @if($log->user->role == 1)
                                  <span class="badge badge-sm bg-gradient-success "> Staff</span>
                                    @elseif($log->user->role == 2)
                                    <span class="badge badge-sm bg-gradient-primary"> Seller</span>
                                    @elseif($log->user->role == 3)
                                    <span class="badge badge-sm bg-gradient-info"> Customer</span>
                                    @else
                                    <span class="badge badge-sm bg-gradient-secondary"> Unknown</span>
                                  @endif  
                              </td>
                              <td>
                                  <h6 class="mb-2 text-sm ps-6">{{ \Carbon\Carbon::parse($log->login_time)->format('F j, Y \a\t g:i a') ?? 'N/A' }}</h6>
                              </td>
                              <td>
                                <h6 class="mb-2 text-sm ps-6"> {!! $log->logout_time ? \Carbon\Carbon::parse($log->logout_time)->format('F d, Y \a\t h:i A') : '<span class="badge badge-sm bg-gradient-success"><i class="fa fa-clock"></i> Still logged in</span>' !!}</h6>
                              </td>
                           </tr>
                          @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        </div>
      </div>
    </div>
</div>
@endsection