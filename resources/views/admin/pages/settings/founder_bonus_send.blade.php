@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Send Founder Bonus</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.founder.bonus.send') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Bonus Amount($)</label>
                <input type="number" name="amount" id="amount" step="0.01" class="form-control" required>
                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Send Bonus</button>
        </form>
    </div>
</div>
@endsection
