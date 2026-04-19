<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Email Verification — DocBook</title>

<style>
  body {
    font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
    background-color: #f1f5f9;
    color: #1e293b;
  }

  .email-wrapper {
    max-width: 600px;
    margin: 20px auto;
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,.08);
  }

  .header {
    background: linear-gradient(135deg, #0f766e 0%, #065e55 100%);
    padding: 28px;
    text-align: center;
  }

  .logo {
    font-size: 26px;
    font-weight: 800;
    color: #ffffff;
  }

  .tagline {
    color: rgba(255,255,255,.7);
    font-size: 12px;
    margin-top: 4px;
  }

  .hero {
    background: #f0fdfa;
    padding: 20px;
    text-align: center;
  }

  .hero h1 {
    font-size: 20px;
    color: #0f766e;
    margin-bottom: 6px;
  }

  .hero p {
    font-size: 13px;
    color: #475569;
  }

  .body {
    padding: 24px;
  }

  .greeting {
    font-size: 14px;
    margin-bottom: 14px;
  }

  /* OTP CARD */
  .detail-card {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    margin: 18px 0;
    text-align: center;
  }

  .detail-card-header {
    background: #0f766e;
    color: #ffffff;
    font-weight: 600;
    font-size: 13px;
    padding: 10px;
    text-transform: uppercase;
  }

  .otp {
    font-size: 32px;
    font-weight: bold;
    letter-spacing: 8px;
    color: #0f766e;
    padding: 18px;
  }

  .expiry {
    font-size: 12px;
    color: #ef4444;
    padding-bottom: 12px;
  }

  .footer {
    background: #f8fafc;
    padding: 16px;
    text-align: center;
    font-size: 11px;
    color: #94a3b8;
  }

</style>

</head>

<body>

<div class="email-wrapper">

  <!-- HEADER -->

  <div class="header">
    <div class="logo">DocBook</div>
    <div class="tagline">Smart Healthcare · At Your Fingertips</div>
  </div>

  <!-- HERO -->

  <div class="hero">
    <h1>Email Verification</h1>
    <p>Use the OTP below to securely login</p>
  </div>

  <!-- BODY -->

  <div class="body">

```
<p class="greeting">
  Dear <strong>{{ $user->name ?? 'User' }}</strong>,
</p>

<!-- OTP CARD -->
<div class="detail-card">
  <div class="detail-card-header">🔐 Your OTP</div>

  <div class="otp">{{ $otp }}</div>
  <div class="expiry">Valid for 5 minutes</div>
</div>

<p style="font-size:13px; color:#64748b;">
  Please do not share this OTP with anyone.
</p>

<p style="margin-top:14px; font-size:13px;">
  Regards,<br/>
  <strong style="color:#0f766e;">DocBook Team</strong>
</p>
```

  </div>

  <!-- FOOTER -->

  <div class="footer">
    © {{ date('Y') }} DocBook. All rights reserved.
  </div>

</div>

</body>
</html>
