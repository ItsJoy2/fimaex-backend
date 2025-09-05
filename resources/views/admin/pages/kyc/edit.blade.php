@extends('admin.layouts.app')

@section('content')
    <div class="card shadow-sm">

        <div class="card-body">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">NID Front</label>
                    <div class="border rounded p-2 mb-3 text-center bg-light">
                        <a href="{{ $kyc->nid_front }}" target="_blank">
                            <img src="{{ $kyc->nid_front }}" alt="NID Front" class="img-fluid rounded" style="max-height: 250px; object-fit: contain;">
                        </a>
                        <div class="small text-muted mt-1">Click image to view full size</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Selfie</label>
                    <div class="border rounded p-2 mb-3 text-center bg-light">
                        <a href="{{ $kyc->selfie }}" target="_blank">
                            <img src="{{ $kyc->selfie }}" alt="Selfie" class="img-fluid rounded" style="max-height: 250px; object-fit: contain;">
                        </a>
                        <div class="small text-muted mt-1">Click image to view full size</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('kyc.update', $kyc->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending" {{ $kyc->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $kyc->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $kyc->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="details" class="form-label fw-semibold">Details / Remarks</label>
                    <textarea name="details" id="details" rows="5" class="form-control" placeholder="Optional remarks...">{{ old('details', $kyc->details) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Update KYC
                    </button>
                    <a href="{{ route('kyc.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
