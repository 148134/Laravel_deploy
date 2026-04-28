{{-- Shared form for course create & edit --}}
<form method="POST" action="{{ $formAction }}">
  @csrf
  @if($formMethod === 'PUT') @method('PUT') @endif

  <div class="form-grid cols3">

    <div class="form-group">
      <label>Course Code *</label>
      <input type="text" name="course_code" required
             placeholder="e.g. BSCS"
             value="{{ old('course_code', optional($course)->course_code) }}">
      @error('course_code')
        <span class="field-error">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group full">
      <label>Course Name *</label>
      <input type="text" name="course_name" required
             placeholder="Bachelor of Science in Computer Science"
             value="{{ old('course_name', optional($course)->course_name) }}">
      @error('course_name')
        <span class="field-error">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label>Degree Type</label>
      <select name="degree_type">
        @foreach(['Certificate','Associate','Bachelor','Master','Doctorate','Professional'] as $dt)
          <option value="{{ $dt }}"
            {{ old('degree_type', optional($course)->degree_type ?? 'Bachelor') === $dt ? 'selected' : '' }}>
            {{ $dt }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Years to Complete</label>
      <input type="number" name="years" min="1" max="8"
             value="{{ old('years', optional($course)->years ?? 4) }}">
    </div>

  </div>

  <div class="checkbox-row" style="margin-top:10px">
    <input type="checkbox" name="board_exam" id="board_exam" value="1"
           {{ old('board_exam', optional($course)->board_exam) ? 'checked' : '' }}>
    <label for="board_exam">Requires Board Examination (PRC)</label>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">
      <i class="bi bi-check-lg"></i>
      {{ $course ? 'Update Course' : 'Create Course' }}
    </button>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
  </div>

</form>
