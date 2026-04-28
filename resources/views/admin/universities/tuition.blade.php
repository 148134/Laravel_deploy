@extends('admin.layouts.app')
@section('title', 'Tuition & Fees — ' . $university->university_name)

@section('content')
    <div class="page-header">
        <div class="breadcrumb">
            admin /
            <a href="{{ route('admin.universities.index') }}">universities</a> /
            <a
                href="{{ route('admin.universities.edit', $university->university_id) }}">{{ $university->abbreviation ?? Str::limit($university->university_name, 30) }}</a>
            /
            <span>tuition &amp; fees</span>
        </div>
        <h1>Tuition &amp; Fees</h1>
        <p>{{ $university->university_name }}</p>
    </div>

    {{-- ── Summary strip ──────────────────────────────────────────── --}}
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px">
        @php
            $allOfferings = $offerings->flatten();
            $totalCourses = $allOfferings->count();
            $freeCount = $allOfferings->where('tuition_fee_per_semester', 0)->count();
            $avgTuition = $allOfferings->where('tuition_fee_per_semester', '>', 0)->avg('tuition_fee_per_semester');
        @endphp
        <div class="stat-card" style="flex:1;min-width:140px;text-align:center">
            <div class="stat-label">Total Programs</div>
            <div class="stat-value blue">{{ $totalCourses }}</div>
        </div>
        <div class="stat-card" style="flex:1;min-width:140px;text-align:center">
            <div class="stat-label">Free Tuition</div>
            <div class="stat-value green">{{ $freeCount }}</div>
        </div>
        <div class="stat-card" style="flex:1;min-width:140px;text-align:center">
            <div class="stat-label">Avg Tuition/Sem</div>
            <div class="stat-value">{{ $avgTuition ? '₱' . number_format($avgTuition) : '—' }}</div>
        </div>
        <div class="stat-card" style="flex:1;min-width:140px;text-align:center">
            <div class="stat-label">Active Programs</div>
            <div class="stat-value">{{ $allOfferings->where('is_available', true)->count() }}</div>
        </div>
    </div>

    {{-- ── Bulk-save form ─────────────────────────────────────────── --}}
    <form method="POST" action="{{ route('admin.tuition.update', $university->university_id) }}" id="feesForm">
        @csrf @method('POST')

        @foreach ($offerings as $degreeType => $rows)
            <div class="card" style="margin-bottom:18px">
                <div class="card-header">
                    <div class="card-title">

                        {{ $degreeType }} Programs
                        <span class="count-badge">{{ $rows->count() }}</span>
                    </div>
                    {{-- Quick-fill for the whole group --}}
                    {{-- <div style="display:flex;gap:8px;align-items:center">
                        <span style="font-size:.75rem;color:var(--text3)">Set all tuition:</span>
                        <input type="number" min="0" class="quick-fill" data-degree="{{ $degreeType }}"
                            placeholder="₱ amount"
                            style="width:120px;padding:5px 10px;border-radius:8px;border:1.5px solid var(--border2);font-size:.82rem">
                        <button type="button" class="btn btn-secondary btn-xs apply-fill"
                            data-degree="{{ $degreeType }}">Apply</button>
                    </div> --}}
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:36px">On</th>
                                <th>Code</th>
                                <th>Course Name</th>
                                <th style="width:160px">Tuition / Sem (₱)</th>
                                <th style="width:150px">Misc Fees / Sem (₱)</th>
                                <th style="width:110px">Slots / Year</th>
                                <th>Notes</th>
                                <th style="width:52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $uc)
                                @php $course = $uc->course; @endphp
                                <tr class="{{ $uc->is_available ? '' : 'row-inactive' }}" data-uc="{{ $uc->uc_id }}">

                                    {{-- Available toggle --}}
                                    <td style="text-align:center">
                                        <input type="checkbox" name="fees[{{ $uc->uc_id }}][is_available]"
                                            value="1" {{ $uc->is_available ? 'checked' : '' }}
                                            style="accent-color:var(--accent);width:16px;height:16px;cursor:pointer"
                                            title="Mark as available">
                                    </td>

                                    {{-- Course code --}}
                                    <td>
                                        <code
                                            style="font-size:.82rem;color:var(--accent)">{{ $course->course_code ?? '—' }}</code>
                                    </td>

                                    {{-- Course name --}}
                                    <td style="font-weight:500">{{ $course->course_name ?? '—' }}</td>

                                    {{-- Tuition --}}
                                    <td>
                                        <div style="position:relative">
                                            <span
                                                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text3);font-size:.85rem;pointer-events:none">₱</span>
                                            <input type="number"
                                                name="fees[{{ $uc->uc_id }}][tuition_fee_per_semester]"
                                                value="{{ $uc->tuition_fee_per_semester }}" min="0" max="9999999"
                                                class="fee-input tuition-input degree-{{ Str::slug($degreeType) }}"
                                                style="padding-left:26px">
                                        </div>
                                        @if ($uc->tuition_fee_per_semester == 0)
                                            <div style="font-size:.7rem;color:var(--green);margin-top:2px">✓ Free (RA 10931)
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Misc fees --}}
                                    <td>
                                        <div style="position:relative">
                                            <span
                                                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text3);font-size:.85rem;pointer-events:none">₱</span>
                                            <input type="number" name="fees[{{ $uc->uc_id }}][misc_fees]"
                                                value="{{ $uc->misc_fees }}" min="0" max="9999999"
                                                class="fee-input" style="padding-left:26px">
                                        </div>
                                    </td>

                                    {{-- Slots --}}
                                    <td>
                                        <input type="number" name="fees[{{ $uc->uc_id }}][slots_per_year]"
                                            value="{{ $uc->slots_per_year }}" min="0" max="9999"
                                            class="fee-input">
                                    </td>

                                    {{-- Notes --}}
                                    <td>
                                        <input type="text" name="fees[{{ $uc->uc_id }}][notes]"
                                            value="{{ $uc->notes }}" placeholder="Optional note…" maxlength="255"
                                            class="fee-input">
                                    </td>

                                    {{-- Remove — standalone form OUTSIDE the bulk-save form --}}
                                    {{-- <td>
                                        <button type="button" class="btn btn-danger btn-xs" title="I miss her"
                                            onclick="removeCourse({{ $uc->uc_id }}, '{{ addslashes($course->course_name ?? '') }}')">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </td> --}}

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        @if ($offerings->isEmpty())
            <div class="card">
                <div class="empty-state" style="padding:40px">
                    <div style="font-size:2rem;margin-bottom:8px">📋</div>
                    <p>No course offerings yet. Add courses below.</p>
                </div>
            </div>
        @endif

        {{-- ── Sticky save bar ─────────────────────────────────────── --}}
        <div class="sticky-save">
            <span id="changeCount" style="font-size:.82rem;color:var(--text2)"></span>
            <a href="{{ route('admin.universities.edit', $university->university_id) }}" class="btn btn-secondary">← Back
                to Edit</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Save All Changes
            </button>
        </div>
    </form>

    {{-- ── Hidden remove form (POST, outside bulk form) ─────────── --}}
    <form method="POST" id="removeForm" action="" style="display:none">
        @csrf
    </form>
    @if ($availableCourses->isNotEmpty())
        <div class="card" style="margin-top:24px;margin-bottom:60px">
            <div class="card-header">
                <div class="card-title"><i class="bi bi-plus-circle"></i> Add Course to Offerings</div>
            </div>

            <form method="POST" action="{{ route('admin.tuition.add-course', $university->university_id) }}">
                @csrf
                <div class="form-grid" style="grid-template-columns:2fr 1fr 1fr 1fr auto;align-items:end;gap:12px">

                    <div class="form-group">
                        <label>Course</label>
                        <select name="course_id" required>
                            <option value="">— Select a course to add —</option>
                            @php $prevDeg = '' @endphp
                            @foreach ($availableCourses as $c)
                                @if ($c->degree_type !== $prevDeg)
                                    @if ($prevDeg)
                                        </optgroup>
                                    @endif
                                    <optgroup label="{{ $c->degree_type }}">
                                        @php $prevDeg = $c->degree_type @endphp
                                @endif
                                <option value="{{ $c->course_id }}">{{ $c->course_code }} – {{ $c->course_name }}
                                </option>
                            @endforeach
                            @if ($prevDeg)
                                </optgroup>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tuition / Sem (₱)</label>
                        <input type="number" name="tuition_fee_per_semester" min="0" placeholder="0 = Free">
                    </div>

                    <div class="form-group">
                        <label>Misc Fees / Sem (₱)</label>
                        <input type="number" name="misc_fees" min="0" placeholder="0">
                    </div>

                    <div class="form-group">
                        <label>Slots / Year</label>
                        <input type="number" name="slots_per_year" min="0" placeholder="50" value="50">
                    </div>

                    <div class="form-group" style="padding-top:22px">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    {{-- ── Styles ─────────────────────────────────────────────────── --}}
    <style>
        .fee-input {
            width: 100%;
            padding: 7px 10px;
            border: 1.5px solid var(--border2);
            border-bottom: 2.5px solid var(--border2);
            border-radius: 8px;
            font-size: .85rem;
            font-family: var(--sans);
            color: var(--text);
            background: var(--bg2);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .fee-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(29, 63, 137, .1);
        }

        .fee-input.dirty {
            border-color: var(--yellow);
            background: var(--yellow-lt);
        }

        .row-inactive td {
            opacity: .45;
        }

        .row-inactive td:first-child {
            opacity: 1;
        }

        .sticky-save {
            position: sticky;
            bottom: 0;
            background: var(--bg2);
            border-top: 2px solid var(--border2);
            padding: 14px 20px;
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: flex-end;
            z-index: 100;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, .08);
            border-radius: var(--radius) var(--radius) 0 0;
            margin: 0 -22px;
        }
    </style>

    @push('scripts')
        <script>
            // ── Remove course via hidden POST form ────────────────────────
            /*function removeCourse(ucId, courseName) {
                if (!confirm('Remove "' + courseName + '" from this university?')) return;
                const form = document.getElementById('removeForm');
                const routes = @json(collect($offerings->flatten())->mapWithKeys(fn($uc) => [$uc->uc_id => route('admin.tuition.remove-course', [$university->university_id, $uc->uc_id])]));
                form.action = routes[ucId];
                window.removeEventListener('beforeunload', () => {}); // don't warn on intentional submit
                form.submit();
            }*/
            let dirtyCount = 0;
            const counter = document.getElementById('changeCount');

            document.querySelectorAll('.fee-input').forEach(input => {
                const orig = input.value;
                input.addEventListener('input', () => {
                    const wasDirty = input.classList.contains('dirty');
                    const isDirty = input.value !== orig;
                    if (isDirty && !wasDirty) {
                        input.classList.add('dirty');
                        dirtyCount++;
                    }
                    if (!isDirty && wasDirty) {
                        input.classList.remove('dirty');
                        dirtyCount--;
                    }
                    counter.textContent = dirtyCount > 0 ? dirtyCount + ' unsaved change' + (dirtyCount > 1 ?
                        's' : '') : '';
                });
            });

            // ── Checkbox row dim ───────────────────────────────────────────
            document.querySelectorAll('input[type=checkbox]').forEach(cb => {
                cb.addEventListener('change', () => {
                    cb.closest('tr').classList.toggle('row-inactive', !cb.checked);
                });
            });

            // ── Tuition free label live update ────────────────────────────
            document.querySelectorAll('.tuition-input').forEach(input => {
                input.addEventListener('input', () => {
                    let hint = input.parentElement.nextElementSibling;
                    if (!hint) {
                        hint = document.createElement('div');
                        hint.style.cssText = 'font-size:.7rem;color:var(--green);margin-top:2px';
                        input.parentElement.after(hint);
                    }
                    hint.textContent = parseInt(input.value) === 0 ? '✓ Free (RA 10931)' : '';
                });
            });

            // ── Quick-fill by degree group ─────────────────────────────────
            document.querySelectorAll('.apply-fill').forEach(btn => {
                btn.addEventListener('click', () => {
                    const deg = btn.dataset.degree;
                    const amt = btn.previousElementSibling.value;
                    const slug = deg.toLowerCase().replace(/[^a-z0-9]/g, '-');
                    document.querySelectorAll('.degree-' + slug).forEach(inp => {
                        if (inp.value !== amt) {
                            inp.value = amt;
                            inp.dispatchEvent(new Event('input'));
                        }
                    });
                });
            });

            // ── Warn before leaving with unsaved changes ───────────────────
            window.addEventListener('beforeunload', e => {
                if (dirtyCount > 0) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
            document.getElementById('feesForm').addEventListener('submit', () => {
                window.removeEventListener('beforeunload', () => {});
            });
        </script>
    @endpush
@endsection
