@extends('admin.layouts.app')
@section('title', 'Edit Scholarship')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <a href="{{ route('admin.scholarships.index') }}">scholarships</a> / <span>edit</span></div>
  <h1>{{ $scholarship->scholarship_name }}</h1>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Edit Scholarship</div>
    <a href="{{ route('admin.scholarships.index') }}" class="btn btn-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>
  @include('admin.scholarships._form', [
    'formAction' => route('admin.scholarships.update', $scholarship->scholarship_id),
    'formMethod' => 'PUT',
  ])
</div>
@endsection
