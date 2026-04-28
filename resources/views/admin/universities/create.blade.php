@extends('admin.layouts.app')
@section('title', 'Add University')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <a href="{{ route('admin.universities.index') }}">universities</a> / <span>new</span></div>
  <h1>Add New University</h1>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">University Details</div>
    <a href="{{ route('admin.universities.index') }}" class="btn btn-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>

  @include('admin.universities._form', [
    'university'  => null,
    'formAction'  => route('admin.universities.store'),
    'formMethod'  => 'POST',
  ])
</div>
@endsection
