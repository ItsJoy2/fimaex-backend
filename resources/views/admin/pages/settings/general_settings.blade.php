@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>General Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mt-4 pt-4">
        <form action="{{ route('admin.general.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="row">
                <!-- Left Sidebar Navigation -->
                <div class="col-md-4">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-founder-tab" data-bs-toggle="pill" data-bs-target="#v-pills-founder" type="button" role="tab" aria-controls="v-pills-founder" aria-selected="true">
                            <i class="fas fa-user-tie me-2"></i> Founder Settings
                        </button>
                        <button class="nav-link" id="v-pills-app-tab" data-bs-toggle="pill" data-bs-target="#v-pills-app" type="button" role="tab" aria-controls="v-pills-app" aria-selected="false">
                            <i class="fas fa-cog me-2"></i> App Settings
                        </button>
                    </div>
                </div>

                <!-- Right Content Area -->
                <div class="col-md-8">
                    <div class="tab-content" id="v-pills-tabContent">

                        <!-- Founder Settings Tab -->
                        <div class="tab-pane fade show active" id="v-pills-founder" role="tabpanel" aria-labelledby="v-pills-founder-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-user-tie me-2"></i> Founder Settings</h5>

                                    <div class="mb-3">
                                        <label for="total_founder">Total Founder Slots</label>
                                        <input type="number" id="total_founder" name="total_founder"
                                            value="{{ old('total_founder', $generalSettings->total_founder) }}"
                                            required class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="available_founder_slot">Available Founder Slots</label>
                                        <input type="number" id="available_founder_slot" name="available_founder_slot"
                                            value="{{ old('available_founder_slot', $generalSettings->available_founder_slot) }}"
                                            required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- App Settings Tab -->
                        <div class="tab-pane fade" id="v-pills-app" role="tabpanel" aria-labelledby="v-pills-app-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-cog me-2"></i> App Settings</h5>

                                    <div class="mb-3">
                                        <label for="app_name">App Name</label>
                                        <input type="text" id="app_name" name="app_name"
                                            value="{{ old('app_name', $generalSettings->app_name) }}"
                                            required class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="favicon">Favicon (200x200px)</label>
                                        <input type="file" id="favicon" name="favicon" class="form-control">
                                        @if(isset($generalSettings->favicon))
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $generalSettings->favicon) }}"
                                                    alt="Current Favicon"
                                                    style="max-width: 32px; max-height: 32px;">
                                                <span class="ms-2">Current favicon</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="logo">Logo (300x45px)</label>
                                        <input type="file" id="logo" name="logo" class="form-control">
                                        @if(isset($generalSettings->logo))
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $generalSettings->logo) }}"
                                                    alt="Current Logo"
                                                    style="max-width: 300px; max-height: 45px;">
                                                <span class="ms-2">Current logo</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    form{
        width: 70% !important;
    }
    .nav-pills .nav-link {
        border-radius: 0.25rem;
        margin-bottom: 0.5rem;
        text-align: left;
        padding: 0.75rem 1rem;
        color: #495057;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: white;
    }

    .nav-pills .nav-link:hover:not(.active) {
        background-color: #f8f9fa;
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-title {
        color: #343a40;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
</style>
@endsection
