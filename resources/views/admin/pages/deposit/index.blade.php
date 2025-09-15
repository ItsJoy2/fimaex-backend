@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">All Deposit</h4>
        </div>

        <div class="card-body table-responsive">
            {{-- <form method="GET" action="{{ route('deposit.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <select name="filter" class="form-control">
                            <option value="">-- Filter Status --</option>
                            <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="rejected" {{ request('filter') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">Filter</button>
                        <a href="{{ route('deposit.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form> --}}
            <form method="GET" action="{{ route('deposit.index') }}" class="d-flex justify-content-end mb-3" style="max-width: 300px; margin-left: auto;">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <table class="table table-striped table-hover mt-3">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>TrxID:</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                    {{-- <th>Action</th> --}}
                </tr>
                </thead>
                <tbody>
                @forelse ($deposits as $index => $deposit)
                    <tr>
                        <td>{{ $index + $deposits->firstItem() }}</td>
                        <td class="d-flex">
                            <span id="details-{{ $deposit->transaction_id }}">{{ $deposit->transaction_id }}</span>
                            <button class="btn btn-sm copy-btn"
                                    data-copy-target="details-{{ $deposit->transaction_id }}"
                                    title="Copy"
                                    style="margin-left: 5px; padding-bottom: 23px;">
                                <i class="fas fa-copy" style="line-height: 0;"></i>
                            </button>
                        </td>
                        <td>{{ $deposit->user->name ?? 'N/A' }}</td>
                        <td>${{$deposit->amount}}</td>

                        <td>
                            <span class="badge
                                @if($deposit->status == 0) badge-warning
                                @elseif($deposit->status == 1) badge-success
                                @else badge-danger @endif">
                                {{ $deposit->status == 0 ? 'Pending' : ($deposit->status == 1 ? 'Completed' : 'Rejected') }}
                            </span>
                        </td>
                        <td>{{ $deposit->created_at?->format('Y-m-d H:i') }}</td>
                       {{-- @if($deposit->status == 'Pending')
                            <td>
                                <button type="button"
                                        class="btn btn-sm btn-primary"
                                        data-toggle="modal"
                                        data-target="#actionModal{{ $deposit->id }}">
                                    <i class="fas fa-edit"></i> Manage
                                </button>
                            </td>
                       @endif --}}
                    </tr>

                    <!-- Modal -->
                    {{-- <div class="modal fade" id="actionModal{{ $deposit->id }}" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="POST" action="{{ route('deposit.update', $deposit->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Status</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="{{ $deposit->id }}">
                                        <div class="form-group">
                                            <label>Transaction ID</label>
                                            <input type="text" class="form-control" value="{{ $deposit->details }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="pending" {{ $deposit->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="rejected" {{ $deposit->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                <option value="completed" {{ $deposit->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> --}}

                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Deposits found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $deposits->appends(request()->query())->links('admin.layouts.partials.__pagination') }}
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
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const copyButtons = document.querySelectorAll('.copy-btn');

        copyButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-copy-target');
                const textToCopy = document.getElementById(targetId).innerText;
                navigator.clipboard.writeText(textToCopy).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Deposit address copied to clipboard!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }).catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to copy!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            });
        });
    });
</script>
