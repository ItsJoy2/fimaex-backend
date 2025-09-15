@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">User Details: {{ $user->name }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Basic Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        <tr>
                            <th>Email Verified At</th>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-danger">Not Verified</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Blocked</th>
                            <td>
                                 <span class="badge {{ $user->is_block ? 'bg-danger' : 'bg-success' }}">
                                    {{ $user->is_block ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Founder</th>
                            <td>
                                <span class="badge {{ $user->is_founder ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->is_founder ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <!-- Update User Button -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                            Update User Info
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5>Wallet Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Main Wallet</th>
                            <td>${{ number_format($user->main_wallet, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Profit Wallet</th>
                            <td>${{ number_format($user->profit_wallet, 2) }}</td>
                        </tr>
                    </table>

                    <h5>Referral Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Refer Code</th>
                            <td>{{ $user->refer_code }}</td>
                        </tr>
                        <tr>
                            <th>Referred By</th>
                            <td>{{ $user->referredBy ? $user->referredBy->name : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Total Team Members</th>
                            <td>{{ $user->totalTeamMembersCount() }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                @if($user->founder)
                <div class="col-md-6 mb-3">
                    <h5>Founder Info</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Founder Since</th>
                            <td>{{ $user->founder->created_at->format('d M Y') }}</td>
                        </tr>
                        <!-- Add more founder details if needed -->
                    </table>
                </div>
                @endif

                @if($user->activeClub())
                <div class="col-md-6 mb-3">
                    <h5>Active Club</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Club Name</th>
                            <td>{{ $user->activeClub()->name }}</td>
                        </tr>
                        {{-- <tr>
                            <th>Required Refers</th>
                            <td>{{ $user->activeClub()->required_refers }}</td>
                        </tr> --}}
                    </table>
                </div>
                @endif

                @if($user->nominee)
                <div class="col-md-6 mb-3">
                    <h5>Nominee</h5>
                    <table class="table table-bordered">

                        <tr>
                            <th>Name</th>
                            <td>{{ $user->nominee->name }}</td>
                        </tr>
                        <tr>
                            <th>Relationship</th>
                            <td>{{ $user->nominee->relationship }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $user->nominee->contact_number }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ $user->nominee->date_of_birth }}</td>
                        </tr>
                        <tr>
                            <th>Photo</th>
                            <td>
                                @if($user->nominee->image)
                                    <img src="{{ asset('storage/' . $user->nominee->image) }}" alt="Nominee Photo" class="img-thumbnail" style="max-width: 150px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                        </tr>
                        <!-- Add more nominee details if needed -->
                    </table>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>






                <!-- Update User Modal -->
                <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <form action="{{ route('users.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="modal-header">
                        <h5 class="modal-title" id="updateUserModalLabel">Update User Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Name -->
                            <div class="mb-3">
                                <label for="modal_name" class="form-label">Name</label>
                                <input type="text" name="name" id="modal_name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="modal_email" class="form-label">Email</label>
                                <input type="email" name="email" id="modal_email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <!-- Mobile -->
                            <div class="mb-3">
                                <label for="modal_mobile" class="form-label">Mobile</label>
                                <input type="text" name="mobile" id="modal_mobile" class="form-control" value="{{ $user->mobile }}" required>
                            </div>
                            <!-- Block Status -->
                            <div class="mb-3">
                                <label for="modal_is_block" class="form-label">Block Status</label>
                                <select name="is_block" id="modal_is_block" class="form-control" required>
                                    <option value="0" {{ $user->is_block ? '' : 'selected' }}>Unblocked</option>
                                    <option value="1" {{ $user->is_block ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
                



@endsection
