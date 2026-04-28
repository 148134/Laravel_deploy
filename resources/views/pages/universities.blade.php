@extends('layouts.app')
@section('title', 'Universities & Colleges')

@section('content')
<div class="wrap" style="padding-top:32px">

  <div class="section-head fade-up">
    <h2>Universities &amp; Colleges</h2>
    @if($universities->isNotEmpty())
      <span class="count">{{ $universities->count() }} found</span>
    @endif
  </div>

  {{-- Filter Bar --}}
  <div class="filter-bar fade-up fade-up-d1">
    <form method="GET" action="{{ route('universities') }}">
      <div class="fgroup" style="flex:2;min-width:220px">
        <label>Search</label>
        <input type="text" name="q" placeholder="University name or city…" value="{{ $filters['q'] ?? '' }}">
      </div>

      <div class="fgroup">
        <label>Region</label>
        <select name="region" onchange="this.form.submit()">
          <option value="">All Regions</option>
          @foreach($regions as $r)
            <option value="{{ $r->region_id }}" {{ ($filters['region'] ?? '') == $r->region_id ? 'selected' : '' }}>
              {{ $r->region_code }} – {{ Str::before($r->region_name, '–') }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="fgroup">
        <label>School Type</label>
        <select name="type">
          <option value="">All Types</option>
          @foreach($univTypes as $t)
            <option value="{{ $t->type_id }}" {{ ($filters['type'] ?? '') == $t->type_id ? 'selected' : '' }}>
              {{ $t->type_code }} – {{ $t->type_name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="fgroup">
        <label>Offers Course</label>
        <select name="course">
          <option value="">Any Course</option>
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
        <label>Accreditation</label>
        <select name="accred">
          <option value="">Any Level</option>
          @foreach($accredLevels as $a)
            <option value="{{ $a->accred_id }}" {{ ($filters['accred'] ?? '') == $a->accred_id ? 'selected' : '' }}>
              {{ $a->level_name }}
            </option>
          @endforeach
        </select>
      </div>

      <div style="display:flex;flex-direction:column;gap:8px;justify-content:flex-end;padding-bottom:2px">
        <div class="fcheck">
          <input type="checkbox" name="free" id="freeOnly" value="1" {{ !empty($filters['free']) ? 'checked' : '' }}>
          <label for="freeOnly">Free Tuition Only</label>
        </div>
        <div style="display:flex;gap:8px">
          <button type="submit" class="btn btn-primary" style="flex:1">Search</button>
          <a href="{{ route('universities') }}" class="btn btn-ghost">Reset</a>
        </div>
      </div>
    </form>
  </div>

  {{-- Results Grid --}}
  @if($universities->isNotEmpty())
  <div class="cards-grid fade-up fade-up-d2">
    @foreach($universities as $u)
    <a href="{{ route('university', $u->university_id) }}" class="u-card">
      <div class="u-card-name">{{ $u->university_name }}</div>
      <div class="u-card-meta">
        {!! \App\Services\UniversityService::typeBadge($u->type_code, $u->type_name) !!}
        @if(($u->accred_id ?? 0) >= 3)
          <span class="badge badge-outline" style="font-size:.68rem">{{ $u->accreditation }}</span>
        @endif
      </div>
      <div class="u-card-loc">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
          <circle cx="12" cy="10" r="3"/>
        </svg>
        {{ $u->province_name }} &bull; {{ $u->region_code }}
      </div>
      <div class="u-card-footer">
        @if($u->is_free_tuition)
          <span class="free-tag">✓ Free Tuition (RA 10931)</span>
        @else
          <span style="color:var(--text3)">Private Institution</span>
        @endif
        <span class="courses-tag">{{ $u->courses_offered }} programs</span>
      </div>
    </a>
    @endforeach
  </div>
  @else
  <div class="empty">
    <div class="icon"><i class="bi bi-search"></i></div>
    <p>Enter a search term or select filters above to browse universities and colleges.</p>
  </div>
  @endif

</div>
@endsection
