@extends('admin.layouts.app')
@section('title', 'Edit Accreditation Level')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <a href="{{ route('admin.accreditation.index') }}">accreditation</a> / <span>edit</span></div>
  <h1>{{ $level->level_name }}</h1>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Edit Accreditation Level</div>
    <a href="{{ route('admin.accreditation.index') }}" class="btn btn-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>

  <form method="POST" action="{{ route('admin.accreditation.update', $level->accred_id) }}">
    @csrf @method('PUT')

    <div class="form-grid">

      <div class="form-group">
        <label>Level Name *</label>
        <input type="text" name="level_name" required
               value="{{ old('level_name', $level->level_name) }}">
        @error('level_name')
          <span class="field-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label>Accrediting Body</label>
        <input type="text" name="body"
               value="{{ old('body', $level->body) }}">
      </div>

      <div class="form-group">
        <label>Base Tuition / Semester (PHP)</label>
        <input type="number" name="base_tuition" min="0"
               value="{{ old('base_tuition', $level->base_tuition) }}">
        @error('base_tuition')
          <span class="field-error">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group full">
        <label>Description</label>
        <textarea name="description" style="min-height:60px">{{ old('description', $level->description) }}</textarea>
      </div>

    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-lg"></i> Update Level
      </button>
      <a href="{{ route('admin.accreditation.index') }}" class="btn btn-secondary">Cancel</a>
    </div>

  </form>
</div>
@endsection
