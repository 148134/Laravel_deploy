@extends('layouts.app')
@section('title', 'Course Finder')

@section('content')
<div class="wrap" style="padding-top:32px">

  <div class="section-head fade-up">
    <h2>Course Finder</h2>
    @if($results->isNotEmpty())
      <span class="count">{{ $results->count() }} results</span>
    @endif
  </div>

  <div class="filter-bar fade-up fade-up-d1">
    <form method="GET" action="{{ route('courses') }}">
      <div class="fgroup" style="flex:2;min-width:240px">
        <label>Select a Program</label>
        <select name="course" required>
          <option value="">— Choose a course —</option>
          @php $prevDeg = '' @endphp
          @foreach($courses as $c)
            @if($c->degree_type !== $prevDeg)
              @if($prevDeg) </optgroup> @endif
              <optgroup label="{{ $c->degree_type }}">
              @php $prevDeg = $c->degree_type @endphp
            @endif
            <option value="{{ $c->course_id }}" {{ ($filters['course'] ?? '') == $c->course_id ? 'selected' : '' }}>
              {{ $c->course_code }} – {{ $c->course_name }}
            </option>
          @endforeach
          @if($prevDeg) </optgroup> @endif
        </select>
      </div>

      <div class="fgroup">
        <label>Region</label>
        <select name="region">
          <option value="">All Regions</option>
          @foreach($regions as $r)
            <option value="{{ $r->region_id }}" {{ ($filters['region'] ?? '') == $r->region_id ? 'selected' : '' }}>
              {{ $r->region_code }}
            </option>
          @endforeach
        </select>
      </div>

      <div style="display:flex;flex-direction:column;gap:8px;justify-content:flex-end;padding-bottom:2px">
        <div class="fcheck">
          <input type="checkbox" name="free" id="freeOnlyCF" value="1" {{ !empty($filters['free']) ? 'checked' : '' }}>
          <label for="freeOnlyCF">Free Tuition Only</label>
        </div>
        <div class="fcheck">
          <input type="checkbox" name="board" id="boardOnly" value="1" {{ !empty($filters['board']) ? 'checked' : '' }}>
          <label for="boardOnly">Board Exam Programs</label>
        </div>
        <button type="submit" class="btn btn-primary"
          style="background:#ba95f9;border-radius:25px;border:1.5px solid var(--border2);border-bottom:2.5px solid var(--border2)">
          Find Schools
        </button>
      </div>
    </form>
  </div>

  @if($results->isNotEmpty())
  <div class="cf-table-wrap fade-up fade-up-d2">
    <table class="cf-table">
      <thead>
        <tr>
          <th>University / College</th>
          <th>Program</th>
          <th>Type</th>
          <th>Accreditation</th>
          <th>Location</th>
          <th>Tuition / Sem</th>
          <th>Duration</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($results as $r)
        <tr>
          <td>
            <a href="{{ route('university', $r->university_id) }}">{{ $r->university_name }}</a>
            @if($r->abbreviation)
              <div style="font-size:.75rem;color:var(--text3)">{{ $r->abbreviation }}</div>
            @endif
          </td>
          <td>
            <code style="font-size:.8rem;color:var(--accent)">{{ $r->course_code }}</code><br>
            <span style="font-size:.82rem;color:var(--text2)">{{ $r->course_name }}</span>
          </td>
          <td>
            @php $colors = \App\Services\UniversityService::TYPE_COLORS; @endphp
            <span class="badge" style="background:{{ $colors[$r->type_code] ?? '#475569' }};font-size:.68rem">
              {{ $r->type_code }}
            </span>
          </td>
          <td style="font-size:.8rem;color:var(--text2)">{{ $r->accreditation ?? '—' }}</td>
          <td style="font-size:.82rem;color:var(--text3)">{{ $r->province_name }}<br>{{ $r->region_name }}</td>
          <td class="{{ $r->tuition_fee_per_semester == 0 ? 'tuition-free' : 'tuition-paid' }}">
            {{ \App\Services\UniversityService::formatTuition($r->tuition_fee_per_semester) }}
          </td>
          <td style="color:var(--text2);white-space:nowrap">{{ $r->years }} yr{{ $r->years > 1 ? 's' : '' }}</td>
          <td>@if($r->board_exam)<span class="board-pill">PRC</span>@endif</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <div class="empty">
    <div class="icon"><i class="bi bi-book"></i></div>
    <p>Select a course above to see which schools offer it and compare tuition fees.</p>
  </div>
  @endif

</div>
@endsection
