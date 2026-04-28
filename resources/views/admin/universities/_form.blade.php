{{--
  Shared form partial for create & edit.
  Variables expected: $university (nullable), $univTypes, $provinces, $accredLevels
  $formAction  = route string
  $formMethod  = 'POST' | 'PUT'
--}}

<form method="POST" action="{{ $formAction }}">
  @csrf
  @if($formMethod === 'PUT') @method('PUT') @endif

  <div class="form-grid">

    <div class="form-group full">
      <label>University Name *</label>
      <input type="text" name="university_name" required
             value="{{ old('university_name', optional($university)->university_name) }}">
      @error('university_name')
        <span class="field-error">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label>Abbreviation</label>
      <input type="text" name="abbreviation"
             value="{{ old('abbreviation', optional($university)->abbreviation) }}">
    </div>

    <div class="form-group">
      <label>City / Municipality</label>
      <input type="text" name="city"
             value="{{ old('city', optional($university)->city) }}">
    </div>

    <div class="form-group">
      <label>University Type</label>
      <select name="type_id">
        <option value="">— Select Type —</option>
        @foreach($univTypes as $t)
          <option value="{{ $t->type_id }}"
            {{ old('type_id', optional($university)->type_id) == $t->type_id ? 'selected' : '' }}>
            {{ $t->type_code }} – {{ $t->type_name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Province</label>
      <select name="province_id">
        <option value="">— Select Province —</option>
        @foreach($provinces as $p)
          <option value="{{ $p->province_id }}"
            {{ old('province_id', optional($university)->province_id) == $p->province_id ? 'selected' : '' }}>
            {{ $p->province_name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Year Established</label>
      <input type="number" name="year_established" min="1800" max="2025"
             value="{{ old('year_established', optional($university)->year_established) }}">
    </div>

    <div class="form-group">
      <label>Accreditation Level</label>
      <select name="accred_id">
        @foreach($accredLevels as $al)
          <option value="{{ $al->accred_id }}"
            {{ old('accred_id', optional($university)->accred_id ?? 1) == $al->accred_id ? 'selected' : '' }}>
            {{ $al->level_name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Website</label>
      <input type="url" name="website"
             value="{{ old('website', optional($university)->website) }}">
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email"
             value="{{ old('email', optional($university)->email) }}">
    </div>

    <div class="form-group">
      <label>Phone</label>
      <input type="text" name="phone"
             value="{{ old('phone', optional($university)->phone) }}">
    </div>

  

    <div class="form-group full">
      <label>Description</label>
      <textarea name="description">{{ old('description', optional($university)->description) }}</textarea>
    </div>

  </div>

  <div class="checkbox-row" style="margin-top:8px">
    <input type="checkbox" name="is_active" id="is_active" value="1"
           {{ old('is_active', optional($university)->is_active ?? true) ? 'checked' : '' }}>
    <label for="is_active">Active (visible in portal)</label>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">
      <i class="bi bi-check-lg"></i>
      {{ $university ? 'Update University' : 'Create University' }}
    </button>
    <a href="{{ route('admin.universities.index') }}" class="btn btn-secondary">Cancel</a>
  </div>

</form>
