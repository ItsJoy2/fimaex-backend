<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>{{ $generalSettings->app_name ?? 'petroxcin admin panel' }}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="https://www.petroxcin.com/_next/static/media/logo.beb988fc.png">

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
