@extends('layouts.app')
@section('title', 'By Region')

@section('content')
<div class="wrap" style="padding-top:32px">

  <div class="section-head fade-up">
    <h2>Universities by Region</h2>
    <span class="count">{{ $regionStats->count() }} regions</span>
  </div>

  @if($regionStats->isNotEmpty())
  @php $maxUni = max($regionStats->pluck('total_universities')->toArray() ?: [1]); @endphp

  <div class="region-table-wrap fade-up fade-up-d1">
    <table class="region-table">
      <thead>
        <tr>
          <th>Region</th>
          <th>Total HEIs</th>
          <th style="min-width:200px">Distribution</th>
          <th>Free Tuition</th>
          <th>Private</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($regionStats as $rs)
        @php $pct = $maxUni > 0 ? round(($rs->total_universities / $maxUni) * 100) : 0; @endphp
        <tr onclick="window.location='{{ route('universities', ['region' => $rs->region_id]) }}'" style="cursor:pointer">
          <td>
            <div style="font-weight:600;color:var(--text)">{{ $rs->region_code }}</div>
            <div style="font-size:.78rem;color:var(--text3)">
              {{ Str::after($rs->region_name, '–') ?: $rs->region_name }}
            </div>
          </td>
          <td>
            <span style="font-size:1.2rem;font-weight:700;color:var(--accent)">
              {{ number_format($rs->total_universities) }}
            </span>
          </td>
          <td>
            <div class="bar-wrap">
              <div class="bar" style="width:{{ $pct }}%"></div>
            </div>
          </td>
          <td><span style="color:var(--green);font-weight:600">{{ number_format($rs->free_tuition_schools) }}</span></td>
          <td><span style="color:var(--text2)">{{ number_format($rs->private_schools) }}</span></td>
          <td>
            <a href="{{ route('universities', ['region' => $rs->region_id]) }}"
               class="btn btn-ghost"
               style="padding:5px 12px;font-size:.78rem"
               onclick="event.stopPropagation()">View →</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

</div>
@endsection
