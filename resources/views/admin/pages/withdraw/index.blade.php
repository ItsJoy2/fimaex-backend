@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">All Withdrawals</h4>
        </div>

        <div class="card-body table-responsive">
            <form method="GET" action="{{ route('withdraw.index') }}" class="mb-3">
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
                        <a href="{{ route('withdraw.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-hover mt-3">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Wallet Address</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Charge</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($withdrawals as $index => $withdraw)
                    <tr>
                        <td>{{ $index + $withdrawals->firstItem() }}</td>
                        <td class="d-flex">
                            <span id="details-{{ $withdraw->id }}">{{ $withdraw->details }}</span>
                            <button class="btn btn-sm copy-btn"
                                    data-copy-target="details-{{ $withdraw->id }}"
                                    title="Copy"
                                    style="margin-left: 5px; padding-bottom: 23px;">
                                <i class="fas fa-copy" style="line-height: 0;"></i>
                            </button>
                        </td>

                        <td>{{ $withdraw->user->name ?? 'N/A' }}</td>
                        <td>${{ number_format($withdraw->amount, 3) }}</td>
                        <td>${{ number_format($withdraw->charge, 3) }}</td>

                        <td>
                            <span class="badge
                                @if($withdraw->status == 'Pending') badge-warning
                                @elseif($withdraw->status == 'Rejected') badge-danger
                                @else badge-success @endif">
                                {{ ucfirst($withdraw->status) }}
                            </span>
                        </td>
                        <td>{{ $withdraw->created_at?->format('Y-m-d H:i') }}</td>
                       @if($withdraw->status == 'Pending')
                            <td>
                                <button type="button"
                                        class="btn btn-sm btn-primary"
                                        data-toggle="modal"
                                        data-target="#actionModal{{ $withdraw->id }}">
                                    <i class="fas fa-edit"></i> Manage
                                </button>
                            </td>
                       @endif
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="actionModal{{ $withdraw->id }}" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="POST" action="{{ route('withdraw.update', $withdraw->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Withdrawal Status</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="{{ $withdraw->id }}">
                                        <div class="form-group">
                                            <label>Withdrawal Address</label>
                                            <input type="text" class="form-control" value="{{ $withdraw->details }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Transaction ID</label>
                                            <input type="text" class="form-control" value="{{ $withdraw->transaction_id }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="pending" {{ $withdraw->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="rejected" {{ $withdraw->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                <option value="completed" {{ $withdraw->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="8" class="text-center">No withdrawals found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $withdrawals->appends(request()->query())->links('admin.layouts.partials.__pagination') }}
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

                // কপি টেক্সট
                navigator.clipboard.writeText(textToCopy).then(() => {
                    // SweetAlert2 ব্যবহার করলে এই অংশ কাজ করবে
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Wallet address copied to clipboard!',
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
