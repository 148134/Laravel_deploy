@extends('admin.layouts.app')
@section('title', 'Edit Course')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <a href="{{ route('admin.courses.index') }}">courses</a> / <span>edit</span></div>
  <h1>{{ $course->course_code }} — {{ $course->course_name }}</h1>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Edit Course</div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>
  @include('admin.courses._form', [
    'formAction' => route('admin.courses.update', $course->course_id),
    'formMethod' => 'PUT',
  ])
</div>
@endsection
