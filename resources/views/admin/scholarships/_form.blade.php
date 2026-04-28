{{-- Shared form for scholarship create & edit --}}
<form method="POST" action="{{ $formAction }}">
  @csrf
  @if($formMethod === 'PUT') @method('PUT') @endif

  <div class="form-grid">

    <div class="form-group full">
      <label>Scholarship Name *</label>
      <input type="text" name="scholarship_name" required
             value="{{ old('scholarship_name', optional($scholarship)->scholarship_name) }}">
      @error('scholarship_name')
        <span class="field-error">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label>Provider / Agency *</label>
      <input type="text" name="provider" required
             value="{{ old('provider', optional($scholarship)->provider) }}">
      @error('provider')
        <span class="field-error">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label>Type</label>
      <select name="scholarship_type">
        @foreach(['Government','Institutional','Private','External'] as $st)
          <option value="{{ $st }}"
            {{ old('scholarship_type', optional($scholarship)->scholarship_type ?? 'Government') === $st ? 'selected' : '' }}>
            {{ $st }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group full">
      <label>Coverage (what it covers)</label>
      <textarea name="coverage">{{ old('coverage', optional($scholarship)->coverage) }}</textarea>
    </div>

    <div class="form-group full">
      <label>Eligibility Requirements</label>
      <textarea name="eligibility">{{ old('eligibility', optional($scholarship)->eligibility) }}</textarea>
    </div>

    <div class="form-group">
      <label>Website / Application URL</label>
      <input type="url" name="website"
             value="{{ old('website', optional($scholarship)->website) }}">
      @error('website')
        <span class="field-error">{{ $message }}</span>
      @enderror
    </div>

  </div>

  <div class="checkbox-row" style="margin-top:8px">
    <input type="checkbox" name="is_active" id="schol_active" value="1"
           {{ old('is_active', optional($scholarship)->is_active ?? true) ? 'checked' : '' }}>
    <label for="schol_active">Active (visible in portal)</label>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">
      <i class="bi bi-check-lg"></i>
      {{ $scholarship ? 'Update Scholarship' : 'Create Scholarship' }}
    </button>
    <a href="{{ route('admin.scholarships.index') }}" class="btn btn-secondary">Cancel</a>
  </div>

</form>
