@extends('admin.layouts.app')
@section('title', 'Courses')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <span>courses</span></div>
  <h1>Courses</h1>
  <p>Manage CHED-recognized degree programs.</p>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">
      All Courses
      <span class="count-badge">{{ $courses->count() }}</span>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-lg"></i> Add New
    </a>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th><th>Code</th><th>Course Name</th>
          <th>Degree</th><th>Years</th><th>Board Exam</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($courses as $c)
        <tr>
          <td><span class="mono-id">{{ $c->course_id }}</span></td>
          <td><span class="badge badge-blue">{{ $c->course_code }}</span></td>
          <td>{{ $c->course_name }}</td>
          <td><span class="badge badge-gray">{{ $c->degree_type }}</span></td>
          <td>{{ $c->years }} yrs</td>
          <td>
            @if($c->board_exam)
              <span class="badge badge-yellow">Yes</span>
            @else
              <span style="color:var(--text3)">No</span>
            @endif
          </td>
          <td>
            <div class="td-actions">
              <a href="{{ route('admin.courses.edit', $c->course_id) }}"
                 class="btn btn-secondary btn-xs">
                <i class="bi bi-pencil"></i> Edit
              </a>
              <form method="POST"
                    action="{{ route('admin.courses.destroy', $c->course_id) }}"
                    onsubmit="return confirm('Delete this course? This removes it from all university listings.')">
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
          <td colspan="7"><div class="empty-state">No courses found.</div></td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
