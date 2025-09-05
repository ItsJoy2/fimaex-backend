@extends('admin.layouts.app')


@section('content')
<div class="container w-50 bg-warning p-3">
    <h2>Referral Settings</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.referral.settings.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Invest Level 1 ($)</label>
            <input type="number" step="0.01" name="invest_level_1" value="{{ $settings->invest_level_1 }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>ROI level 1 Bonus: (%)</label>
            <input type="number" step="0.01" name="roi_level_1" value="{{ $settings->roi_level_1 }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>ROI level 2 Bonus: (%)</label>
            <input type="number" name="roi_level_2" value="{{ $settings->roi_level_2 }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>ROI level 3 Bonus: (%)</label>
            <input type="number" name="roi_level_3" value="{{ $settings->roi_level_3 }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
