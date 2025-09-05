@extends('admin.layouts.app')
@section('content')
 <div class="p-5">
     <h4>Edit Plan</h4>
     <form method="POST" action="{{ route('all-plan.update', $plan->id) }}" enctype="multipart/form-data">
         @csrf
         @method('PUT')
         @include('admin.pages.plan.form', ['plan' => $plan])
         <button type="submit" class="btn btn-success">Update</button>
     </form>
 </div>
@endsection
