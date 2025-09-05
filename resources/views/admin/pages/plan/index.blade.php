@extends('admin.layouts.app')

@section('content')
    {{-- SweetAlert success message --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Founder Plans</h4>
            {{-- <a href="{{ route('all-plan.create') }}" class="btn btn-success btn-sm">+ Add New Plan</a> --}}
        </div>

        <div class="card-body table-responsive">
            {{-- <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <select name="filter" class="form-control">
                            <option value="">-- Filter Plans --</option>
                            <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Active Plans</option>
                            <option value="inactive" {{ request('filter') == 'inactive' ? 'selected' : '' }}>Inactive Plans</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">Filter</button>
                        <a href="{{ route('all-plan.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form> --}}

            <table class="table table-striped table-hover mt-3">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Badge</th>
                    <th>Amount</th>
                    <th>Referral Commission</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($plans as $index => $plan)
                    <tr>
                        <td>{{ $index + $plans->firstItem() }}</td>
                        <td>{{ $plan->name }}</td>
                        <td>@if($plan->icon)
                                <img src="{{ asset('storage/' . $plan->icon) }}" alt="Icon" style="width:40px; height:40px; object-fit:cover; border-radius:5px;">
                            @else
                                <span class="text-muted">No Icon</span>
                            @endif
                        </td>
                        <td>${{ number_format($plan->amount, 2) }}</td>
                        <td>${{ $plan->refer_bonus }}</td>
                        <td>
                                <span class="badge {{ $plan->active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $plan->active ? 'Active' : 'Inactive' }}
                                </span>
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('all-plan.edit', $plan->id) }}" class="btn btn-sm btn-info">Edit</a>
{{--                            <form action="{{ route('all-plan.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button class="btn btn-sm btn-danger">Delete</button>--}}
{{--                            </form>--}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No plans found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $plans->links('admin.layouts.partials.__pagination') }}
            </div>
        </div>
    </div>
@endsection
