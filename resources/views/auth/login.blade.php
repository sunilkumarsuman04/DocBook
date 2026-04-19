<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — DocBook</title>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --teal: #0f766e; --teal-dark: #065e55; --teal-light: #ccfbf1;
      --red: #dc2626;
      --s50: #f8fafc; --s100: #f1f5f9; --s200: #e2e8f0;
      --s400: #94a3b8; --s500: #64748b; --s700: #334155; --s900: #0f172a;
    }
    body {
      font-family: 'Inter', system-ui, sans-serif;
      background: var(--s100);
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 20px;
    }
    .card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 4px 32px rgba(0,0,0,.10);
      width: 100%;
      max-width: 440px;
      overflow: hidden;
    }
    .card-header {
      background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
      padding: 28px 32px;
      text-align: center;
    }
    .logo { font-size: 24px; font-weight: 800; color: #fff; }
    .logo span { color: #5eead4; }
    .card-header p { color: rgba(255,255,255,.7); font-size: 13px; margin-top: 4px; }
    .card-body { padding: 28px 32px; }

    /* Alerts */
    .alert {
      padding: 11px 14px; border-radius: 10px; font-size: 13.5px;
      line-height: 1.5; margin-bottom: 16px; display: none; align-items: flex-start; gap: 8px;
    }
    .alert.show { display: flex; }
    .alert-success { background: #f0fdf4; border: 1.5px solid #86efac; color: #166534; }
    .alert-error   { background: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; }

    /* Blade flash messages — always show */
    .alert-flash { display: flex !important; }

    /* Tabs */
    .tab-bar {
      display: flex; background: var(--s100);
      border-radius: 10px; padding: 4px; margin-bottom: 22px; gap: 4px;
    }
    .tab-btn {
      flex: 1; padding: 8px; border: none; background: transparent;
      border-radius: 8px; font-size: 13px; font-weight: 600;
      color: var(--s500); cursor: pointer; transition: all .18s;
      font-family: 'Inter', sans-serif;
    }
    .tab-btn.active { background: #fff; color: var(--teal); box-shadow: 0 1px 6px rgba(0,0,0,.08); }

    /* Fields */
    label {
      display: block; font-size: 12px; font-weight: 600;
      color: var(--s700); text-transform: uppercase;
      letter-spacing: .04em; margin-bottom: 6px;
    }
    .req { color: var(--red); margin-left: 2px; }
    .field-wrap { position: relative; margin-bottom: 16px; }
    input[type="email"], input[type="password"],
    input[type="text"], input[type="number"] {
      width: 100%; padding: 11px 14px;
      border: 2px solid var(--s200); border-radius: 10px;
      font-size: 14.5px; font-family: 'Inter', sans-serif;
      color: var(--s900); background: #fff;
      transition: border-color .18s, box-shadow .18s; outline: none;
    }
    input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(15,118,110,.12); }
    input.is-error { border-color: var(--red); }
    .field-err { font-size: 12px; color: var(--red); margin-top: 4px; display: none; }
    .field-err.show { display: block; }

    /* Eye button */
    .eye-btn {
      position: absolute; right: 12px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: var(--s400); font-size: 16px; padding: 4px;
    }

    /* Buttons */
    .btn {
      display: inline-flex; align-items: center; justify-content: center;
      gap: 8px; font-family: 'Inter', sans-serif; font-weight: 600;
      font-size: 14.5px; border: none; border-radius: 10px;
      cursor: pointer; transition: all .18s; padding: 11px 20px;
    }
    .btn:disabled { opacity: .6; pointer-events: none; }
    .btn-primary {
      width: 100%;
      background: linear-gradient(135deg, var(--teal) 0%, var(--teal-dark) 100%);
      color: #fff;
      box-shadow: 0 4px 14px rgba(15,118,110,.35);
    }
    .btn-primary:hover { opacity: .92; }

    /* Spinner inside button */
    .btn .spinner {
      width: 16px; height: 16px;
      border: 2px solid rgba(255,255,255,.35);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin .7s linear infinite;
      display: none; flex-shrink: 0;
    }
    .btn.loading .spinner { display: inline-block; }
    .btn.loading .btn-label { display: none; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Remember row */
    .remember-row {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 18px;
    }
    .remember-row label {
      display: flex; align-items: center; gap: 7px;
      font-size: 13px; font-weight: 500;
      text-transform: none; letter-spacing: 0; cursor: pointer; color: var(--s700);
    }
    .remember-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--teal); }
    .forgot-link { font-size: 12.5px; color: var(--teal); font-weight: 600; text-decoration: none; }

    /* OTP info box */
    .otp-sent-box {
      background: #f0fdf4; border: 1.5px solid #86efac;
      border-radius: 10px; padding: 11px 14px;
      font-size: 13.5px; color: #166534;
      margin-bottom: 16px; display: none;
    }
    .otp-sent-box.show { display: block; }

    /* Countdown timer */
    .otp-timer {
      font-size: 12.5px; color: var(--red);
      font-weight: 600; text-align: center;
      margin-bottom: 14px; display: none;
    }
    .otp-timer.show { display: block; }

    /* OTP hint links */
    .otp-links {
      text-align: center; font-size: 12.5px;
      color: var(--s500); margin-top: 12px;
    }
    .otp-links a { color: var(--teal); font-weight: 600; cursor: pointer; text-decoration: none; }
    .otp-links a:hover { text-decoration: underline; }

    .register-link {
      text-align: center; font-size: 13px;
      color: var(--s500); margin-top: 20px;
    }
    .register-link a { color: var(--teal); font-weight: 600; text-decoration: none; }
  </style>
</head>
<body>

<div class="card">
  <div class="card-header">
    <div class="logo">Doc<span>Book</span></div>
    <p>Sign in to your account</p>
  </div>

  <div class="card-body">

    {{-- Blade flash messages --}}
    @if(session('success'))
      <div class="alert alert-success alert-flash">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error alert-flash">❌ {{ session('error') }}</div>
    @endif

    {{-- JS-controlled global messages --}}
    <div id="msg-error"   class="alert alert-error"></div>
    <div id="msg-success" class="alert alert-success"></div>

    {{-- Tab bar --}}
    <div class="tab-bar">
      <button class="tab-btn active" id="tab-pw"  onclick="switchTab('pw')">🔒 Password</button>
      <button class="tab-btn"        id="tab-otp" onclick="switchTab('otp')">📱 OTP Login</button>
    </div>

    {{-- ================================================================ --}}
    {{-- PANEL A: Password login                                          --}}
    {{-- ================================================================ --}}
    <div id="panel-pw">
      <form method="POST" action="{{ route('login.submit') }}" novalidate>
        @csrf

        <div class="field-wrap">
          <label for="pw-email">Email Address <span class="req">*</span></label>
          <input type="email" id="pw-email" name="email"
            value="{{ old('email') }}"
            placeholder="you@example.com"
            autocomplete="email"
            class="{{ $errors->has('email') ? 'is-error' : '' }}"
            required/>
          @error('email')
            <div class="field-err show">{{ $message }}</div>
          @enderror
        </div>

        <div class="field-wrap">
          <label for="pw-password">Password <span class="req">*</span></label>
          <input type="password" id="pw-password" name="password"
            placeholder="Your password"
            autocomplete="current-password"
            class="{{ $errors->has('password') ? 'is-error' : '' }}"
            required/>
          <button type="button" class="eye-btn" onclick="togglePw('pw-password')" tabindex="-1">👁</button>
          @error('password')
            <div class="field-err show">{{ $message }}</div>
          @enderror
        </div>

        <div class="remember-row">
          <label>
            <input type="checkbox" name="remember" id="remember"/>
            Remember me
          </label>
          <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary">
          <span class="spinner"></span>
          <span class="btn-label">Sign In</span>
        </button>
      </form>
    </div>

    {{-- ================================================================ --}}
    {{-- PANEL B: OTP login                                               --}}
    {{-- ================================================================ --}}
    <div id="panel-otp" style="display:none;">

      {{-- Step 1: Enter email --}}
      <div id="otp-step1">
        <div class="field-wrap">
          <label for="otp-email">Email Address <span class="req">*</span></label>
          <input type="email" id="otp-email"
            placeholder="Enter your registered email"
            autocomplete="email"/>
          <div class="field-err" id="otp-email-err"></div>
        </div>

        <button type="button" class="btn btn-primary" id="btn-send-otp" onclick="sendOtp()">
          <span class="spinner"></span>
          <span class="btn-label">📨 Send OTP</span>
        </button>
      </div>

      {{-- Step 2: Enter OTP (hidden until OTP is sent) --}}
      <div id="otp-step2" style="display:none;">

        <div class="otp-sent-box" id="otp-sent-box"></div>

        <div class="field-wrap">
          <label for="otp-code">Enter 6-Digit OTP <span class="req">*</span></label>
          <input type="text" id="otp-code"
            maxlength="6"
            inputmode="numeric"
            placeholder="0 0 0 0 0 0"
            autocomplete="one-time-code"
            style="font-size:26px;font-weight:700;letter-spacing:.4em;text-align:center;padding:14px;"/>
          <div class="field-err" id="otp-code-err"></div>
        </div>

        {{-- BUG FIX: timer starts hidden, JS adds class 'show' --}}
        <div class="otp-timer" id="otp-timer"></div>

        <button type="button" class="btn btn-primary" id="btn-verify-otp" onclick="verifyOtp()">
          <span class="spinner"></span>
          <span class="btn-label">✅ Verify &amp; Login</span>
        </button>

        <div class="otp-links">
          Didn't get it? <a onclick="resendOtp()">Resend OTP</a>
          &nbsp;·&nbsp;
          <a onclick="resetOtp()">Change Email</a>
        </div>
      </div>

    </div>{{-- /panel-otp --}}

    <p class="register-link">
      No account? <a href="{{ route('register') }}">Create one free</a>
    </p>

  </div>{{-- /card-body --}}
</div>

<script>
// ============================================================================
// HELPERS
// ============================================================================
const eid  = id => document.getElementById(id);
let countdownTimer = null;
let isRedirecting  = false;   // BUG FIX: prevent double-fire of finally block

function showMsg(type, text) {
  const err = eid('msg-error');
  const ok  = eid('msg-success');
  err.classList.remove('show'); ok.classList.remove('show');
  if (type === 'error')   { err.textContent = text; err.classList.add('show'); }
  if (type === 'success') { ok.textContent  = text; ok.classList.add('show'); }
}
function clearMsg() {
  eid('msg-error').classList.remove('show');
  eid('msg-success').classList.remove('show');
}

function showFieldErr(id, msg) {
  const el = eid(id);
  if (el) { el.textContent = msg; el.classList.add('show'); }
}
function clearFieldErr(id) {
  const el = eid(id);
  if (el) { el.textContent = ''; el.classList.remove('show'); }
}

function setLoading(btnId, on) {
  const btn = eid(btnId);
  if (!btn) return;
  btn.disabled = on;
  btn.classList.toggle('loading', on);
}

// ============================================================================
// TABS
// ============================================================================
function switchTab(tab) {
  const isPw = (tab === 'pw');
  eid('panel-pw').style.display  = isPw ? 'block' : 'none';
  eid('panel-otp').style.display = isPw ? 'none'  : 'block';
  eid('tab-pw').classList.toggle('active', isPw);
  eid('tab-otp').classList.toggle('active', !isPw);
  clearMsg();
}

// ============================================================================
// PASSWORD VISIBILITY
// ============================================================================
function togglePw(inputId) {
  const inp = eid(inputId);
  inp.type = (inp.type === 'password') ? 'text' : 'password';
}

// ============================================================================
// OTP — SEND
// ============================================================================
async function sendOtp() {
  clearMsg();
  clearFieldErr('otp-email-err');

  const email = eid('otp-email').value.trim();

  // Client-side validation
  if (!email) {
    showFieldErr('otp-email-err', 'Please enter your email address.'); return;
  }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    showFieldErr('otp-email-err', 'Please enter a valid email address.'); return;
  }

  setLoading('btn-send-otp', true);

  try {
    const res = await fetch('{{ route("auth.otp.send") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept':       'application/json',
      },
      body: JSON.stringify({ email }),
    });

    const data = await res.json();

    if (res.ok && data.success) {
      // BUG FIX: transition from step1 to step2 properly
      eid('otp-step1').style.display = 'none';
      eid('otp-step2').style.display = 'block';

      // Show confirmation
      const box = eid('otp-sent-box');
      box.innerHTML = `✅ OTP sent to <strong>${email}</strong>. Check your inbox.`;
      box.classList.add('show');

      // Clear previous OTP input
      eid('otp-code').value = '';
      clearFieldErr('otp-code-err');

      // BUG FIX: re-enable verify button (may have been disabled by expired timer)
      eid('btn-verify-otp').disabled = false;

      // Start 5-minute countdown
      startCountdown(300);

      // Focus OTP field
      setTimeout(() => eid('otp-code').focus(), 100);
    } else {
      showFieldErr('otp-email-err', data.message || 'Failed to send OTP. Please try again.');
    }
  } catch (err) {
    showFieldErr('otp-email-err', 'Network error. Please check your connection and try again.');
    console.error('sendOtp error:', err);
  } finally {
    setLoading('btn-send-otp', false);
  }
}

// ============================================================================
// OTP — VERIFY  ← main bug fix
// ============================================================================
async function verifyOtp() {
  // Prevent double-submit if already redirecting
  if (isRedirecting) return;

  clearMsg();
  clearFieldErr('otp-code-err');

  const email = eid('otp-email').value.trim();
  const otp   = eid('otp-code').value.trim();

  if (!otp || otp.length !== 6 || !/^\d{6}$/.test(otp)) {
    showFieldErr('otp-code-err', 'Please enter the full 6-digit OTP from your email.');
    return;
  }

  setLoading('btn-verify-otp', true);

  try {
    const res = await fetch('{{ route("auth.otp.verify") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept':       'application/json',
      },
      body: JSON.stringify({ email, otp }),
    });

    const data = await res.json();

    if (res.ok && data.success) {
      // BUG FIX: set flag before redirect so finally block doesn't re-enable btn
      isRedirecting = true;
      stopCountdown();
      showMsg('success', '✅ Login successful! Redirecting…');

      // BUG FIX: use data.redirect (set by server from user's ACTUAL role)
      const redirectUrl = data.redirect;

      if (!redirectUrl) {
        console.error('DocBook: no redirect URL in response!', data);
        showMsg('error', 'Login succeeded but redirect failed. Please go to your dashboard manually.');
        isRedirecting = false;
        setLoading('btn-verify-otp', false);
        return;
      }

      // Small delay so user sees the success message, then redirect
      setTimeout(() => {
        window.location.href = redirectUrl;
      }, 1000);

    } else {
      // Show error message
      showFieldErr('otp-code-err', data.message || 'Invalid OTP. Please try again.');
    }
  } catch (err) {
    showFieldErr('otp-code-err', 'Network error. Please check your connection.');
    console.error('verifyOtp error:', err);
  } finally {
    // BUG FIX: only re-enable button if we are NOT redirecting
    if (!isRedirecting) {
      setLoading('btn-verify-otp', false);
    }
  }
}

// ============================================================================
// OTP — RESEND
// BUG FIX: properly show step1 to let user see email, then call sendOtp
// ============================================================================
function resendOtp() {
  // Go back to step1 briefly, then auto-resend using existing email
  stopCountdown();
  clearMsg();

  const email = eid('otp-email').value.trim();
  if (!email) {
    // No email — show step1 so user can enter it
    resetOtp(); return;
  }

  // Email already entered — resend immediately (show step1 just for feedback)
  eid('otp-step2').style.display = 'none';
  eid('otp-step1').style.display = 'block';

  // Short delay then auto-send
  setTimeout(() => sendOtp(), 300);
}

// ============================================================================
// OTP — RESET (change email)
// ============================================================================
function resetOtp() {
  stopCountdown();
  clearMsg();
  isRedirecting = false;
  eid('otp-step1').style.display = 'block';
  eid('otp-step2').style.display = 'none';
  eid('otp-sent-box').classList.remove('show');
  clearFieldErr('otp-email-err');
  clearFieldErr('otp-code-err');
  eid('otp-code').value = '';
  eid('otp-email').focus();
}

// ============================================================================
// COUNTDOWN TIMER
// BUG FIX: timer div starts with no 'show' class — it is hidden by default
// ============================================================================
function startCountdown(seconds) {
  stopCountdown(); // clear any existing timer

  const el = eid('otp-timer');
  el.classList.add('show');
  let remaining = seconds;

  function tick() {
    if (remaining <= 0) {
      stopCountdown();
      el.textContent = '❌ OTP expired. Please click Resend OTP.';
      // Disable verify button since OTP is expired
      if (eid('btn-verify-otp')) eid('btn-verify-otp').disabled = true;
      return;
    }
    const m = String(Math.floor(remaining / 60)).padStart(2, '0');
    const s = String(remaining % 60).padStart(2, '0');
    el.textContent = `⏱ OTP expires in ${m}:${s}`;
    remaining--;
  }

  tick(); // show immediately
  countdownTimer = setInterval(tick, 1000);
}

function stopCountdown() {
  if (countdownTimer) { clearInterval(countdownTimer); countdownTimer = null; }
  const el = eid('otp-timer');
  if (el) { el.classList.remove('show'); el.textContent = ''; }
}

// ============================================================================
// OTP INPUT — digits only + Enter to submit
// ============================================================================
document.addEventListener('DOMContentLoaded', function () {
  const otpInput = eid('otp-code');
  if (!otpInput) return;

  otpInput.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 6);
  });

  otpInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); verifyOtp(); }
  });

  // Auto-submit when 6 digits entered
  otpInput.addEventListener('input', function () {
    if (this.value.length === 6) {
      setTimeout(verifyOtp, 200); // small delay for UX
    }
  });
});
</script>

</body>
</html>