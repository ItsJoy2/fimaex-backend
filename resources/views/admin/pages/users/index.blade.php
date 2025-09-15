@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">All Users</h4>
        </div>

        <div class="card-body table-responsive">
            <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <select name="filter" class="form-control">
                            <option value="">-- Filter Users --</option>
                            <option value="founder" {{ request('filter') == 'founder' ? 'selected' : '' }}>Founder Users</option>
                            <option value="member" {{ request('filter') == 'member' ? 'selected' : '' }}>Member Users</option>
                            <option value="blocked" {{ request('filter') == 'blocked' ? 'selected' : '' }}>Blocked Users</option>
                            <option value="unblocked" {{ request('filter') == 'unblocked' ? 'selected' : '' }}>Unblocked Users</option>
                        </select>

                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">Filter</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-end mb-3">
                <form method="GET" action="{{ route('users.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by email" value="{{ request('search') }}">
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                    <button type="submit" class="btn btn-primary me-2">Search</button>
                    @if(request('search'))
                        <a href="{{ route('users.index', ['filter' => request('filter')]) }}" class="btn btn-secondary">Reset</a>
                    @endif
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-head-bg-primary mt-3">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Wallet Balance</th>
                        <th>Profit Wallet</th>
                        <th>Referred By</th>
                        <th>Status</th>
                        <th>Block Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + $users->firstItem() }}</td>
                            <td>{{ $user->created_at->format('d-m-y') }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>${{ number_format($user->main_wallet ?? 0, 2) }}</td>
                            <td>${{ number_format($user->profit_wallet ?? 0, 2) }}</td>
                            <td>{{ $user->referredBy->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $user->is_founder ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->is_founder ? 'Founder' : 'Member' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->is_block ? 'bg-danger' : 'bg-success' }}">
                                    {{ $user->is_block ? 'Blocked' : 'Unblocked' }}
                                </span>
                            </td>
                            {{-- <td>
                                <button type="button"
                                        class="btn btn-sm btn-primary updateStatusBtn"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-wallet="{{ number_format($user->main_wallet ?? 0, 2) }}"
                                        data-block="{{ $user->is_block }}"
                                        data-toggle="modal"
                                        data-target="#actionModal">
                                    <i class="fas fa-edit"></i> Manage
                                </button>
                            </td> --}}

                            <td> <a href="{{ route('users.show', $user->id) }}"><button type="button"
                                        class="btn btn-sm btn-primary updateStatusBtn">
                                    <i class="fas fa-edit"></i> View
                                </button></a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links('admin.layouts.partials.__pagination') }}
            </div>
        </div>
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>
        @endif

    </div>

    @include('admin.modal.userblockmodal')
@endsection
