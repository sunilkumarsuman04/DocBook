
<?php $__env->startSection('title', 'Verify OTP'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-7">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-12 h-12 rounded-2xl bg-brand-500 flex items-center justify-center shadow-lg shadow-brand-500/30">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Verify your OTP</h1>
            <p class="text-slate-400 text-sm">We'll send a 6-digit code to your email</p>
        </div>
    </div>
</div>


<div id="alert-box" class="hidden mb-5 px-4 py-3 rounded-xl text-sm font-medium border flex items-start gap-2.5">
    <svg id="alert-icon" class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    <span id="alert-text"></span>
</div>


<div id="step-1">
    <p class="text-slate-500 text-sm mb-5 leading-relaxed">
        Enter your registered email address. We'll send you a one-time password to sign in without a password.
    </p>

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email address</label>
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <input type="email" id="otp-email" placeholder="you@example.com" autocomplete="email"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-900 transition-all
                           focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
            </div>
        </div>

        <button id="send-btn" onclick="sendOtp()"
            class="w-full flex items-center justify-center gap-2 py-3 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all duration-150 active:scale-[.98] shadow-sm hover:shadow-md text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
            <span id="send-btn-text">Send OTP</span>
        </button>
    </div>

    <p class="text-center text-sm text-slate-400 mt-6">
        Know your password? <a href="/login" class="text-brand-600 font-semibold hover:text-brand-700">Sign in</a>
    </p>
</div>


<div id="step-2" class="hidden">

    
    <div class="flex items-center gap-3 p-3 bg-brand-50 border border-brand-100 rounded-xl mb-6">
        <div class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-xs text-slate-500">OTP sent to</p>
            <p class="text-sm font-semibold text-slate-900 truncate" id="email-display">—</p>
        </div>
        <button onclick="goBack()" class="text-xs text-brand-600 hover:text-brand-700 font-semibold flex-shrink-0">
            Change
        </button>
    </div>

    <p class="text-slate-500 text-sm mb-5">
        Enter the 6-digit code from your email. It expires in <strong class="text-slate-700">5 minutes</strong>.
    </p>

    
    <div class="flex gap-2 justify-center mb-6" id="otp-boxes">
        <?php for($i = 0; $i < 6; $i++): ?>
        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
            id="otp-digit-<?php echo e($i); ?>"
            class="otp-digit w-12 h-14 rounded-xl border-2 border-slate-200 text-center text-xl font-bold text-slate-900
                   transition-all focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-400/30
                   bg-white shadow-sm hover:border-slate-300">
        <?php endfor; ?>
    </div>

    
    <button id="verify-btn" onclick="verifyOtp()"
        class="w-full flex items-center justify-center gap-2 py-3 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl transition-all duration-150 active:scale-[.98] shadow-sm hover:shadow-md text-sm mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span id="verify-btn-text">Verify & Sign In</span>
    </button>

    
    <div class="text-center">
        <p class="text-sm text-slate-400">
            Didn't receive it?
            <button id="resend-btn" onclick="sendOtp(true)"
                class="text-brand-600 font-semibold hover:text-brand-700 ml-1 disabled:opacity-40 disabled:cursor-not-allowed"
                disabled>
                Resend OTP
            </button>
        </p>
        <p id="resend-timer" class="text-xs text-slate-400 mt-1">Resend available in <span id="timer-count">30</span>s</p>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// ── State ──────────────────────────────────────────────────────────────
let userEmail      = '';
let resendInterval = null;

// ── Helpers ────────────────────────────────────────────────────────────
function showAlert(msg, type = 'error') {
    const box  = document.getElementById('alert-box');
    const text = document.getElementById('alert-text');
    const icon = document.getElementById('alert-icon');

    text.textContent = msg;
    box.classList.remove('hidden',
        'bg-emerald-50','border-emerald-200','text-emerald-700',
        'bg-red-50','border-red-200','text-red-700');

    if (type === 'success') {
        box.classList.add('bg-emerald-50','border-emerald-200','text-emerald-700');
        icon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
    } else {
        box.classList.add('bg-red-50','border-red-200','text-red-700');
        icon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
    }
}

function setLoading(btnId, textId, loading, loadingText, defaultText) {
    const btn  = document.getElementById(btnId);
    const span = document.getElementById(textId);
    btn.disabled    = loading;
    span.textContent = loading ? loadingText : defaultText;
    btn.classList.toggle('opacity-70', loading);
    btn.classList.toggle('cursor-not-allowed', loading);
}

function startResendTimer() {
    let seconds = 30;
    const resendBtn   = document.getElementById('resend-btn');
    const timerEl     = document.getElementById('timer-count');
    const timerText   = document.getElementById('resend-timer');

    resendBtn.disabled = true;
    timerText.classList.remove('hidden');

    clearInterval(resendInterval);
    resendInterval = setInterval(() => {
        seconds--;
        timerEl.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(resendInterval);
            resendBtn.disabled = false;
            timerText.classList.add('hidden');
        }
    }, 1000);
}

// ── OTP digit box navigation ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const digits = document.querySelectorAll('.otp-digit');

    digits.forEach((input, idx) => {
        input.addEventListener('input', e => {
            const val = e.target.value.replace(/\D/g, '');
            e.target.value = val.slice(-1);                // keep last char
            if (val && idx < digits.length - 1) {
                digits[idx + 1].focus();
            }
            highlightFilledBoxes();
        });

        input.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                digits[idx - 1].focus();
                digits[idx - 1].value = '';
            }
            if (e.key === 'Enter') verifyOtp();
        });

        // Handle paste on any box
        input.addEventListener('paste', e => {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((ch, i) => {
                if (digits[i]) digits[i].value = ch;
            });
            // Focus the next empty or last
            const nextEmpty = [...digits].findIndex(d => !d.value);
            (digits[nextEmpty] || digits[digits.length - 1]).focus();
            highlightFilledBoxes();
        });
    });
});

function highlightFilledBoxes() {
    document.querySelectorAll('.otp-digit').forEach(d => {
        d.classList.toggle('border-brand-400', d.value !== '');
        d.classList.toggle('bg-brand-50', d.value !== '');
    });
}

function getOtpValue() {
    return [...document.querySelectorAll('.otp-digit')].map(d => d.value).join('');
}

function clearOtpBoxes() {
    document.querySelectorAll('.otp-digit').forEach(d => {
        d.value = '';
        d.classList.remove('border-brand-400', 'bg-brand-50', 'border-red-400', 'bg-red-50');
    });
}

function shakeOtpBoxes() {
    const boxes = document.getElementById('otp-boxes');
    boxes.classList.add('shake');
    document.querySelectorAll('.otp-digit').forEach(d => {
        d.classList.add('border-red-400','bg-red-50');
    });
    setTimeout(() => {
        boxes.classList.remove('shake');
        setTimeout(clearOtpBoxes, 400);
        document.getElementById('otp-digit-0').focus();
    }, 500);
}

// ── API Calls ──────────────────────────────────────────────────────────
async function sendOtp(isResend = false) {
    const emailInput = document.getElementById('otp-email');
    const email      = isResend ? userEmail : emailInput.value.trim();

    if (!email) {
        showAlert('Please enter your email address.');
        emailInput?.focus();
        return;
    }

    setLoading('send-btn', 'send-btn-text', true, 'Sending…', 'Send OTP');

    try {
        const res  = await fetch('/auth/otp/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ email }),
        });
        const data = await res.json();

        if (data.success) {
            userEmail = email;
            document.getElementById('email-display').textContent = email;

            // Switch to step 2
            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');

            showAlert(data.message || 'OTP sent successfully!', 'success');
            startResendTimer();

            // Focus first digit
            setTimeout(() => document.getElementById('otp-digit-0').focus(), 100);
        } else {
            showAlert(data.message || 'Failed to send OTP. Please try again.');
        }
    } catch (err) {
        showAlert('Network error. Please check your connection and try again.');
    } finally {
        setLoading('send-btn', 'send-btn-text', false, 'Sending…', 'Send OTP');
    }
}

async function verifyOtp() {
    const otp = getOtpValue();

    if (otp.length < 6) {
        showAlert('Please enter all 6 digits of your OTP.');
        document.querySelector('.otp-digit:not([value]),.otp-digit[value=""]')?.focus();
        return;
    }

    setLoading('verify-btn', 'verify-btn-text', true, 'Verifying…', 'Verify & Sign In');

    try {
        const res  = await fetch('/auth/otp/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ email: userEmail, otp }),
        });
        const data = await res.json();

        if (data.success) {
            showAlert('✓ Login successful! Redirecting…', 'success');

            // Brief pause so user sees the success state
            setTimeout(() => {
                window.location.href = data.redirect || '/';
            }, 700);
        } else {
            showAlert(data.message || 'Invalid OTP. Please try again.');
            shakeOtpBoxes();
            setLoading('verify-btn', 'verify-btn-text', false, 'Verifying…', 'Verify & Sign In');
        }
    } catch (err) {
        showAlert('Network error. Please check your connection and try again.');
        setLoading('verify-btn', 'verify-btn-text', false, 'Verifying…', 'Verify & Sign In');
    }
}

function goBack() {
    document.getElementById('step-2').classList.add('hidden');
    document.getElementById('step-1').classList.remove('hidden');
    document.getElementById('alert-box').classList.add('hidden');
    clearOtpBoxes();
    clearInterval(resendInterval);
    document.getElementById('otp-email').focus();
}

// Allow Enter key on email field
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('otp-email')?.addEventListener('keydown', e => {
        if (e.key === 'Enter') sendOtp();
    });
});
</script>

<style>
@keyframes shake {
    0%,100% { transform: translateX(0); }
    15%      { transform: translateX(-6px); }
    30%      { transform: translateX(6px); }
    45%      { transform: translateX(-4px); }
    60%      { transform: translateX(4px); }
    75%      { transform: translateX(-2px); }
    90%      { transform: translateX(2px); }
}
.shake { animation: shake .5s cubic-bezier(.36,.07,.19,.97) both; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Downloads\docbook1_final\docbook1\docbook1\resources\views/emails/otp.blade.php ENDPATH**/ ?>