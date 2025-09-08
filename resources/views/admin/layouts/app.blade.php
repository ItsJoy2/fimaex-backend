<!DOCTYPE html>
<html lang="en">
<head>
    @php
        use App\Models\GeneralSetting;
        $generalSettings = GeneralSetting::first();
    @endphp
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ $generalSettings->app_name ?? 'Laravel Admin' }}</title>
        @if($generalSettings && $generalSettings->favicon)
            <link rel="icon" type="image/png" href="{{ asset('storage/' . $generalSettings->favicon) }}">
            <link rel="apple-touch-icon" href="{{ asset('storage/' . $generalSettings->favicon) }}">
        @else
            <link rel="icon" type="image/png" href="{{ asset('default-favicon.png') }}">
            <link rel="apple-touch-icon" href="{{ asset('default-favicon.png') }}">
        @endif

    {{--	<link rel="icon" href="{{ Storage::url($generalSettings->favicon) ?? asset('default_favicon.ico') }}">--}}
{{--    <link rel="apple-touch-icon" href="{{ Storage::url($generalSettings->favicon) ?? asset('default_favicon.ico') }}">--}}


@include('admin.layouts.partials.__style')

</head>
<body>
	<div class="wrapper">
@include('admin.layouts.partials.__sidebar')

		<div class="main-panel">
			<div class="main-header">
				<div class="main-header-logo">
@include('admin.layouts.partials.__header')
				</div>
@include('admin.layouts.partials.__navbar')
			</div>

			<div class="container">
			@yield('content')
			</div>
		</div>

{{-- @include('admin.layouts.partials.__themeSettings') --}}

	</div>
@include('admin.layouts.partials.__script')
</body>
</html>
