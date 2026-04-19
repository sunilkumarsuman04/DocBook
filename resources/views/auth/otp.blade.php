<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your DocBook Login OTP</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
      background-color: #f1f5f9;
      color: #1e293b;
      -webkit-font-smoothing: antialiased;
    }
    .wrapper {
      max-width: 520px;
      margin: 32px auto;
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 24px rgba(0,0,0,.08);
    }
    .header {
      background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
      padding: 30px 40px;
      text-align: center;
    }
    .logo { font-size: 26px; font-weight: 800; color: #fff; }
    .logo span { color: #93c5fd; }

    .body { padding: 36px 40px; }

    .otp-label {
      font-size: 13px;
      font-weight: 600;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      text-align: center;
      margin-bottom: 12px;
    }

    /* Big OTP display */
    .otp-box {
      background: #f8fafc;
      border: 2px dashed #cbd5e1;
      border-radius: 14px;
      padding: 28px 20px;
      text-align: center;
      margin: 20px 0;
    }
    .otp-code {
      font-size: 48px;
      font-weight: 800;
      letter-spacing: 0.25em;
      color: #1e40af;
      font-family: 'Courier New', Courier, monospace;
      /* Separate each digit visually */
      word-spacing: 8px;
    }
    .otp-expiry {
      font-size: 12px;
      color: #ef4444;
      margin-top: 10px;
      font-weight: 600;
    }

    .info-text {
      font-size: 14px;
      color: #475569;
      line-height: 1.7;
      margin-bottom: 20px;
    }

    /* Warning box */
    .warning-box {
      background: #fff7ed;
      border: 1.5px solid #fed7aa;
      border-radius: 10px;
      padding: 14px 18px;
      margin: 20px 0;
    }
    .warning-box p {
      font-size: 13px;
      color: #92400e;
      line-height: 1.6;
    }

    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 20px 40px;
      text-align: center;
    }
    .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    .footer a { color: #1e40af; text-decoration: none; }
  </style>
</head>
<body>
<div class="wrapper">

  <!-- Header -->
  <div class="header">
    <div class="logo">Doc<span>Book</span></div>
  </div>

  <!-- Body -->
  <div class="body">

    <p class="info-text">
      Hello! You requested a one-time login code for your DocBook account
      (<strong>{{ $email }}</strong>).
      Use the code below to complete your login:
    </p>

    <div class="otp-label">🔐 Your One-Time Password</div>

    <div class="otp-box">
      <div class="otp-code">{{ $otp }}</div>
      <div class="otp-expiry">⏱ Expires in 5 minutes</div>
    </div>

    <p class="info-text">
      Enter this 6-digit code on the login page to access your account.
      Do <strong>not</strong> share this code with anyone.
    </p>

    <div class="warning-box">
      <p>
        ⚠️ <strong>Security Notice:</strong> DocBook will never call or message you
        asking for this code. If you didn't request this OTP, please ignore this email.
        Your account remains secure.
      </p>
    </div>

    <p style="font-size: 13px; color: #64748b; margin-top: 20px;">
      — The DocBook Team
    </p>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>
      © {{ date('Y') }} <a href="{{ config('app.url') }}">DocBook</a>. All rights reserved.<br/>
      This is an automated message, please do not reply.
    </p>
  </div>

</div>
</body>
</html>