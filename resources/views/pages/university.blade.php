@extends('layouts.app')
@section('title', $university->university_name)

@section('content')
<div class="wrap" style="padding-top:28px">

  <a href="javascript:history.back()" class="back-link fade-up">← Back</a>

  <div class="detail-hero fade-up">
    <h1>{{ $university->university_name }}</h1>

    <div class="detail-meta-row">
      {!! \App\Services\UniversityService::typeBadge($university->type_code, $university->type_name) !!}
      <span class="badge badge-outline">{{ $university->accreditation ?? 'CHED Recognized' }}</span>
      @if($university->is_free_tuition)
        <span class="badge" style="background:rgba(34,197,94,.2);color:#86efac;border:1px solid rgba(34,197,94,.3)"> Free Tuition</span>
      @endif
      
      @if($university->region_code)
        <span class="badge badge-outline">{{ $university->region_code }}</span>
      @endif
    </div>

    @if($university->accred_desc)
      <p style="font-size:.85rem;color:var(--text3)">{{ $university->accred_desc }}</p>
    @endif

    <div class="detail-info-grid">
      <div class="info-item">
        <label>Location</label>
        <div class="val">{{ $university->city }}, {{ $university->province_name }}</div>
      </div>
      <div class="info-item">
        <label>Region</label>
        <div class="val">{{ $university->region_name }}</div>
      </div>
      @if($university->year_established)
      <div class="info-item">
        <label>Established</label>
        <div class="val">{{ $university->year_established }}</div>
      </div>
      @endif
      @if($university->website)
      <div class="info-item">
        <label>Website</label>
        <div class="val">
          <a href="{{ $university->website }}" target="_blank" rel="noopener">
            {{ preg_replace('#^https?://#', '', $university->website) }} ↗
          </a>
        </div>
      </div>
      @endif
      @if($university->email)
      <div class="info-item">
        <label>Email</label>
        <div class="val"><a href="mailto:{{ $university->email }}">{{ $university->email }}</a></div>
      </div>
      @endif
      <div class="info-item">
        <label>Programs Offered</label>
        <div class="val">{{ $courses->count() }} programs</div>
      </div>
    </div>
  </div>

  {{-- ── Programs ─────────────────────────────────────────── --}}
  @if($courses->isNotEmpty())
  <div class="section-head fade-up">
    <h2>Programs Offered</h2>
    <span class="count">{{ $courses->count() }} courses</span>
  </div>

  <div class="fade-up fade-up-d1">
    @php
      $degreeOrder = ['Professional','Doctorate','Master','Bachelor','Associate','Certificate'];
     
    @endphp

    @foreach($degreeOrder as $deg)
      @if(isset($coursesByDegree[$deg]))
      @php $grp = $coursesByDegree[$deg]; @endphp
      <div class="degree-section">
        <h3>{{ $deg }} Programs <span class="cnt">{{ count($grp) }} courses</span></h3>
        <div style="overflow-x:auto;border-radius:var(--radius);border:1px solid var(--border)">
          <table class="courses-table">
            <thead>
              <tr>
                <th>Code</th><th>Course Name</th><th>Duration</th>
                <th>Tuition/Sem</th><th>Misc/Sem</th><th>Slots/Year</th><th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($grp as $c)
              <tr>
                <td><code style="font-size:.82rem;color:var(--accent)">{{ $c->course_code }}</code></td>
                <td>{{ $c->course_name }}</td>
                <td style="white-space:nowrap;color:var(--text2)">{{ $c->years }} yr{{ $c->years > 1 ? 's' : '' }}</td>
                <td class="{{ $c->tuition_fee_per_semester == 0 ? 'tuition-free' : 'tuition-paid' }}">
                  {{ \App\Services\UniversityService::formatTuition($c->tuition_fee_per_semester) }}
                </td>
                <td style="color:var(--text3)">{{ $c->misc_fees > 0 ? '₱'.number_format($c->misc_fees) : '—' }}</td>
                <td style="color:var(--text2)">{{ $c->slots_per_year }}</td>
                <td>@if($c->board_exam)<span class="board-pill">PRC Board</span>@endif</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @endif
    @endforeach
  </div>
  @endif

  {{-- ── Scholarships ──────────────────────────────────────── --}}
  @if($scholarships->isNotEmpty())
  <div class="section-head fade-up">
    <h2>Available Scholarships</h2>
    <span class="count">{{ $scholarships->count() }}</span>
  </div>
  <div class="schol-grid fade-up fade-up-d1">
    @foreach($scholarships as $s)
    <div class="schol-card">
      <h4>{{ $s->scholarship_name }}</h4>
      <div class="provider">by {{ $s->provider }}</div>
      <span class="schol-type-badge {{ $s->scholarship_type }}">{{ $s->scholarship_type }}</span>
      @if($s->coverage)
        <p><strong style="color:var(--text);font-size:.78rem">Coverage:</strong> {{ $s->coverage }}</p>
      @endif
      @if($s->eligibility)
        <p style="margin-top:6px"><strong style="color:var(--text);font-size:.78rem">Eligibility:</strong> {{ $s->eligibility }}</p>
      @endif
      @if($s->website)
        <a href="https://{{ $s->website }}" target="_blank" rel="noopener" style="display:inline-block;margin-top:8px">
          <i class="bi bi-link-45deg"></i> {{ $s->website }}
        </a>
      @endif
    </div>
    @endforeach
  </div>
  @endif

</div>
@endsection
