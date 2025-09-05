@extends('admin.layouts.app')
@section('content')
<div class="p-5">
    <h4>Create New Plan</h4>
    <form method="POST" action="{{ route('all-plan.store') }}">
        @csrf
        @include('admin.pages.plan.form')
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
