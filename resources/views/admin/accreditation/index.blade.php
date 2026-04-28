@extends('admin.layouts.app')
@section('title', 'Accreditation Levels')

@section('content')
<div class="page-header">
  <div class="breadcrumb">admin / <span>accreditation</span></div>
  <h1>Accreditation Levels</h1>
  <p>Edit accreditation level names, bodies, and base tuition. Add/delete via database migrations.</p>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">
      All Levels
      <span class="count-badge">{{ $levels->count() }}</span>
    </div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th><th>Level Name</th><th>Accrediting Body</th>
          <th>Base Tuition / Sem</th><th>Description</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($levels as $al)
        <tr>
          <td><span class="mono-id">{{ $al->accred_id }}</span></td>
          <td><strong>{{ $al->level_name }}</strong></td>
          <td>{{ $al->body ?? '—' }}</td>
          <td>
            @if($al->base_tuition == 0)
              <span class="badge badge-green">Free (RA 10931)</span>
            @else
              ₱{{ number_format($al->base_tuition) }}
            @endif
          </td>
          <td style="font-size:.8rem;color:var(--text2)">{{ $al->description ?? '' }}</td>
          <td>
            <a href="{{ route('admin.accreditation.edit', $al->accred_id) }}"
               class="btn btn-secondary btn-xs">
              <i class="bi bi-pencil"></i> Edit
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
