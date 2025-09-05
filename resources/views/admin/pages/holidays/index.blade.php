@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Weekly Holiday Settings</h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Day</th>
                <th>Is Holiday?</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($holidays as $holiday)
                <tr>
                    <td>{{ $holiday->day }}</td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" class="toggle-status" data-id="{{ $holiday->id }}" {{ $holiday->status == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                        <span class="spinner-container" id="spinner-{{ $holiday->id }}" style="display: none;"></span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Toggle Switch & Spinner CSS --}}
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 19px;
            width: 19px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #28a745;
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        /* Spinner */
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #28a745;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-left: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .spinner-container {
            display: inline-block;
        }
    </style>

    {{-- AJAX Toggle Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.toggle-status').on('change', function () {
            var checkbox = $(this);
            var id = checkbox.data('id');
            var status = checkbox.is(':checked') ? 1 : 0;
            var spinner = $('#spinner-' + id);

            // Show loading spinner
            spinner.html('<span class="loading-spinner"></span>').show();

            $.ajax({
                url: "{{ route('holidays.toggle') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function (response) {
                    if(response.success){
                        console.log(response.message);
                    }
                },
                complete: function () {
                    // Hide spinner
                    spinner.fadeOut();
                }
            });
        });
    </script>
@endsection
