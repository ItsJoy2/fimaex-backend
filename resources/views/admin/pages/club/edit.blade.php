@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Club</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('clubs.update', $club->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.pages.club.form')

                <button type="submit" class="btn btn-success">Update Club</button>
                <a href="{{ route('clubs.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
