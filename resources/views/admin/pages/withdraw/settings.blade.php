@extends('admin.layouts.app')

@section('content')
    <div class="container w-50 p-5 bg-warning">
        <h2 class="mb-4">Withdraw Settings</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.withdraw.settings.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="min_withdraw" class="form-label">Minimum Withdraw Amount</label>
                <input type="number" name="min_withdraw" id="min_withdraw" class="form-control" step="0.01" value="{{ old('min_withdraw', $settings->min_withdraw) }}" required>
            </div>

            <div class="mb-3">
                <label for="max_withdraw" class="form-label">Maximum Withdraw Amount</label>
                <input type="number" name="max_withdraw" id="max_withdraw" class="form-control" step="0.01" value="{{ old('max_withdraw', $settings->max_withdraw) }}" required>
            </div>

            <div class="mb-3">
                <label for="charge" class="form-label">Withdraw Charge (%)</label>
                <input type="number" name="charge" id="charge" class="form-control" step="0.01" value="{{ old('charge', $settings->charge) }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="1" {{ $settings->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $settings->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Settings</button>
        </form>
    </div>
@endsection
