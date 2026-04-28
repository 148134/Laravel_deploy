@extends('admin.layouts.app')
@section('title', 'Edit University')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <a href="{{ route('admin.universities.index') }}">universities</a> / <span>edit</span></div>
  <h1>{{ $university->university_name }}</h1>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Edit University</div>
    <div style="display:flex;gap:8px">
      <a href="{{ route('admin.tuition.edit', $university->university_id) }}" class="btn btn-success btn-sm">
        <i class="bi bi-cash-coin"></i> Tuition &amp; Fees
      </a>
      <a href="{{ route('admin.universities.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
      </a>
    </div>
  </div>

  @include('admin.universities._form', [
    'formAction' => route('admin.universities.update', $university->university_id),
    'formMethod' => 'PUT',
  ])
</div>
@endsection
