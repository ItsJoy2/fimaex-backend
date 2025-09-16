@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">KYC Applications</h4>
        </div>

        <div class="card-body table-responsive">
            <form method="GET" action="{{ route('kyc.index') }}" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="status">Filter by Status</label>
                        <select name="status" class="form-control">
                            <option value="">-- All Status --</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-md-0 mt-2">
                        <button class="btn btn-primary" type="submit">Filter</button>
                        <a href="{{ route('kyc.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-bordered mt-3">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>User Name</th>
                    <th>NID Front</th>
                    <th>Selfie</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($kycs as $index => $kyc)
                    <tr>
                        <td>{{ $kycs->firstItem() + $index }}</td>
                        <td>{{ $kyc->created_at ? $kyc->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                        <td>{{ $kyc->name }}</td>
                        <td>
                            <a href="{{ Storage::url($kyc->nid_front) }}" target="_blank">
                                <img src="{{ Storage::url($kyc->nid_front) }}" alt="NID Front" width="60" class="img-thumbnail">
                            </a>
                        </td>
                        <td>
                            <a href="{{ asset('storage/' . $kyc->selfie) }}" target="_blank">
                                <img src="{{ asset('storage/' . $kyc->selfie) }}" alt="Selfie" width="60" class="img-thumbnail">
                            </a>
                        </td>
                        <td>{{ $kyc->details ?? 'N/A' }}</td>
                        <td>
                            <span class="badge
                                {{ $kyc->status === 'approved' ? 'bg-success' :
                                    ($kyc->status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($kyc->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('kyc.edit', $kyc->id) }}" class="btn btn-sm btn-primary">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No KYC applications found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $kycs->withQueryString()->links('admin.layouts.partials.__pagination') }}
            </div>
        </div>
    </div>
@endsection
