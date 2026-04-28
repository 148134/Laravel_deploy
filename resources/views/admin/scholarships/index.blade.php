@extends('admin.layouts.app')
@section('title', 'Scholarships')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <span>scholarships</span></div>
  <h1>Scholarships</h1>
  <p>Manage scholarship programs linked to institutions.</p>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">
      All Scholarships
      <span class="count-badge">{{ $scholarships->count() }}</span>
    </div>
    <a href="{{ route('admin.scholarships.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-lg"></i> Add New
    </a>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Name</th><th>Provider</th><th>Type</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($scholarships as $s)
        <tr>
          <td><span class="mono-id">{{ $s->scholarship_id }}</span></td>
          <td>{{ $s->scholarship_name }}</td>
          <td>{{ $s->provider }}</td>
          <td>
            @php
              $badgeClass = match($s->scholarship_type) {
                'Government'   => 'badge-green',
                'Institutional'=> 'badge-blue',
                'Private'      => 'badge-yellow',
                default        => 'badge-gray',
              };
            @endphp
            <span class="badge {{ $badgeClass }}">{{ $s->scholarship_type }}</span>
          </td>
          <td>
            @if($s->is_active)
              <span class="badge badge-green">Active</span>
            @else
              <span class="badge badge-red">Inactive</span>
            @endif
          </td>
          <td>
            <div class="td-actions">
              <a href="{{ route('admin.scholarships.edit', $s->scholarship_id) }}"
                 class="btn btn-secondary btn-xs">
                <i class="bi bi-pencil"></i> Edit
              </a>
              <form method="POST"
                    action="{{ route('admin.scholarships.destroy', $s->scholarship_id) }}"
                    onsubmit="return confirm('Delete this scholarship?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-xs">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6"><div class="empty-state">No scholarships found.</div></td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
