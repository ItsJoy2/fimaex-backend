@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0" style="max-width: 400px;">
            <div class="card-body d-flex align-items-center">
                {{-- Smaller Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                     stroke="currentColor" stroke-width="2" class="me-3 text-primary"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>

                <div>
                    <h6 class="mb-1 text-muted">Last Cron Run</h6>
                    @if ($cron)
                        <p class="mb-0 fw-semibold text-dark">{{ $cron->last_cron->diffForHumans() }}</p>
                    @else
                        <p class="mb-0 text-danger">No cron record found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

