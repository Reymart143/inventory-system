@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
              <h5 class="text-white text-capitalize ps-3">Registered Users</h5>
              <a href="{{route('users.create')}}" class="btn btn-primary me-4"><i class="fa fa-plus me-2"></i>Register User</a>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <div class="input-group input-group-outline mb-3 mx-4">
                    <form action=" " method="GET" class="w-100 d-flex align-items-center"> 
                        <input placeholder="Search registered users by name, birthday, or address"  type="text"  name="search" class="form-control input-search"  onfocus="focused(this)"  onfocusout="defocused(this)"  value="{{ request('search') }}"  style="margin-right: 10px; width:50vw">
                        <button type="submit" class="btn btn-success mt-3">Search</button>
                    </form>    
                </div>                
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">User</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Birthday</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Address</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Position</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Registered Date</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tool</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-secondary text-xs font-weight-bold text-uppercase">
                                    No users registered yet.
                                </td>
                            </tr>
                        @else
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div>
                                            <img src="{{ asset($user->image) }}" class="avatar avatar-sm me-3 border-radius-lg" alt="{{ $user->name ?? 'User' }}">
                                        </div>                                    
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $user->name ?? 'N/A' }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $user->username ?? 'N/A' }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $user->number ?? 'N/A' }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $user->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <?php
                                    $formattedAddress = wordwrap($user->address, 30, "<br>\n", true);
                                ?>
                                <td>
                                    <p class="text-xs text-secondary mb-0">
                                        {{ \Carbon\Carbon::parse($user->birthday)->format('F d, Y') ?? 'N/A' }}
                                    </p>                                
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{!! $formattedAddress ?? 'N/A' !!}</p>
                                </td>
                                <td>
                                    @if( $user->role == 1)
                                        <p class="text-xs text-warning font-weight-bold mb-0">Staff</p>
                                    @elseif( $user->role == 2)
                                        <p class="text-xs text-info font-weight-bold mb-0">Seller</p>
                                    @else
                                        <p class="text-xs font-weight-bold mb-0">Unknown</p>
                                    @endif
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm cursor-pointer {{ $user->status === 0 ? 'bg-gradient-success' : 'bg-gradient-secondary' }}" 
                                          data-bs-toggle="modal" 
                                          data-bs-target="#statusModal{{ $user->id }}">
                                        {{ $user->status === 0 ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>  
                                <div class="modal fade" id="statusModal{{ $user->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="statusModalLabel{{ $user->id }}">Update Status for {{ $user->name }}</h5>
                                                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>                                                
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('users.updateStatus', $user->id) }}" method="POST" class="status-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="mb-3">
                                                        <label for="statusSelect{{ $user->id }}" class="form-label">Select Status</label>
                                                        <select name="status" id="statusSelect{{ $user->id }}" class="form-select ps-2" style="border: solid 1px rgb(138, 138, 138);">
                                                            <option class="ps-2" value="0" {{ $user->status === 0 ? 'selected' : '' }}>Active</option>
                                                            <option class="mps-2" value="1" {{ $user->status === 1 ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>                              
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at ? $user->created_at->format('F d, Y') : 'N/A' }}</span>
                                </td>                            
                                <td class="align-middle text-center">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-primary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        <i class="fa fa-pen me-1"></i>
                                        Edit
                                    </a>
                                </td>
                            </tr>                        
                            @endforeach
                        @endif
                    </tbody>                
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection