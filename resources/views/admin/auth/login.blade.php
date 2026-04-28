<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In — EduPH Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="login-wrap">
  <div class="login-box">
    <div class="login-logo">EduPH<span> Admin</span></div>
    <div class="login-title">Philippines Education Database</div>

    @if($errors->has('auth'))
      <div class="login-error"><i class="bi bi-shield-exclamation"></i> {{ $errors->first('auth') }}</div>
    @endif

    @if(session('error'))
      <div class="login-error"><i class="bi bi-shield-exclamation"></i> {{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
      @csrf

      <div class="form-group" style="margin-bottom:14px">
        <label for="username">Username</label>
        <input type="text" id="username" name="username"
               value="{{ old('username') }}"
               autocomplete="username" autofocus required>
        @error('username')
          <span style="color:var(--red);font-size:.78rem">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group" style="margin-bottom:22px">
        <label for="password">Password</label>
        <input type="password" id="password" name="password"
               autocomplete="current-password" required>
        @error('password')
          <span style="color:var(--red);font-size:.78rem">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
        <i class="bi bi-box-arrow-in-right"></i> Sign In
      </button>
    </form>
  </div>
</div>

</body>
</html>
