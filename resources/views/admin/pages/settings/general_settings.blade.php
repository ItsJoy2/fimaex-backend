@extends('admin.layouts.app')

@section('content')
<div class="container">

    <h2>General Settings</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.general.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="app_name">App Name</label>
            <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $generalSettings->app_name) }}" required class="form-control">
        </div>


        <div class="mb-3">
            <label for="favicon">Favicon(200x200px)</label>
            <input type="file" id="favicon" name="favicon" class="form-control">
            @if($generalSettings->favicon)
                <img src="{{ asset('storage/' . str_replace('public/', '', $generalSettings->favicon)) }}" alt="Current Favicon" style="max-width: 32px; max-height: 32px;">
            @endif
        </div>


        <div class="mb-3">
            <label for="logo">Logo(300x45px)</label>
            <input type="file" id="logo" name="logo" class="form-control">
            @if($generalSettings->logo)
                <img src="{{ asset('storage/' . str_replace('public/', '', $generalSettings->logo)) }}" alt="Current Logo" style="max-width: 300px; max-height: 45px;">
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
