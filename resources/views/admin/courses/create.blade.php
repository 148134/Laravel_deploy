@extends('admin.layouts.app')
@section('title', 'Add Course')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <a href="{{ route('admin.courses.index') }}">courses</a> / <span>new</span></div>
  <h1>Add New Course</h1>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Course Details</div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>
  @include('admin.courses._form', [
    'course'     => null,
    'formAction' => route('admin.courses.store'),
    'formMethod' => 'POST',
  ])
</div>
@endsection
