@extends('admin.layouts.app')
@section('title', 'Add Scholarship')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <a href="{{ route('admin.scholarships.index') }}">scholarships</a> / <span>new</span></div>
  <h1>Add New Scholarship</h1>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Scholarship Details</div>
    <a href="{{ route('admin.scholarships.index') }}" class="btn btn-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>
  @include('admin.scholarships._form', [
    'scholarship' => null,
    'formAction'  => route('admin.scholarships.store'),
    'formMethod'  => 'POST',
  ])
</div>
@endsection
