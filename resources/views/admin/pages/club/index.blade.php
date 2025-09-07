@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Club List</h4>
        <a href="{{ route('clubs.create') }}" class="btn btn-primary">+ Add Club</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover mt-3 text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Club Name</th>
                        <th>Image</th>
                        <th>Required Refers</th>
                        <th>Bonus %</th>
                        <th>Incentive</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clubs as $club)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $club->name }}</td>
                            <td>
                                @if($club->image)
                                    <img src="{{ asset('storage/'.$club->image) }}" width="60" height="60" class="rounded">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $club->required_refers }}</td>
                            <td>{{ $club->bonus_percent }}%</td>
                            <td>{{ $club->incentive ?? 'N/A' }}</td>
                            <td>
                                @if($club->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('clubs.edit', $club->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('clubs.destroy', $club->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this club?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No Clubs Found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
