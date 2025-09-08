<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $generalSettings->app_name ?? 'Laravel Admin' }}</title>
    @php
        use App\Models\GeneralSetting;
        $generalSettings = GeneralSetting::first();
    @endphp
    @if($generalSettings && $generalSettings->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $generalSettings->favicon) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $generalSettings->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('default-favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('default-favicon.png') }}">
    @endif

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-wrapper {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-wrapper .logo img {
            max-height: 60px;
            margin-bottom: 15px;
        }

        .login-wrapper h2 {
            margin: 0 0 20px;
            font-weight: 600;
            color: #333;
        }

        .form-field {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            background: #f1f1f1;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .form-field i {
            margin-right: 10px;
            color: #888;
        }

        .form-field input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 16px;
        }

        .btn {
            width: 100%;
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #0056b3;
        }

        .alert {
            margin-bottom: 20px;
            color: #fff;
            padding: 10px;
            background: #dc3545;
            border-radius: 6px;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="logo">
        @if($generalSettings && $generalSettings->logo)
            <img src="{{ asset('storage/' . $generalSettings->logo) }}" alt="{{ $generalSettings->app_name ?? 'App Name' }}" class="navbar-brand" height="50">
        @endif
    </div>
    <h2>Admin Login</h2>

    {{-- Session error (for non-admin users) --}}
    @if(session('error'))
        <div class="alert">{{ session('error') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-field">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div class="form-field">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
</div>
</body>
</html>
