<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Appointment Request Rejected — DocBook</title>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Segoe UI',Helvetica,Arial,sans-serif;background-color:#f1f5f9;color:#1e293b;-webkit-font-smoothing:antialiased}
    .email-wrapper{max-width:600px;margin:32px auto;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}
    .header{background:linear-gradient(135deg,#991b1b 0%,#7f1d1d 100%);padding:36px 40px;text-align:center}
    .header .logo{font-size:28px;font-weight:800;color:#ffffff;letter-spacing:-0.5px}
    .header .logo span{color:#fca5a5}
    .header .tagline{color:rgba(255,255,255,.7);font-size:13px;margin-top:4px}
    .hero{background:#fff7f7;border-bottom:1px solid #fecaca;padding:32px 40px;text-align:center}
    .cross{display:inline-flex;align-items:center;justify-content:center;width:64px;height:64px;background:#ef4444;border-radius:50%;font-size:28px;margin-bottom:16px;box-shadow:0 8px 24px rgba(239,68,68,.35)}
    .hero h1{font-size:22px;font-weight:700;color:#991b1b;margin-bottom:8px}
    .hero p{font-size:14px;color:#475569;line-height:1.6}
    .body{padding:36px 40px}
    .greeting{font-size:16px;color:#1e293b;margin-bottom:24px;line-height:1.6}
    .info-box{background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;padding:20px;margin:24px 0}
    .info-box p{font-size:14px;color:#991b1b;line-height:1.7}
    .cta-section{text-align:center;margin:28px 0}
    .btn{display:inline-block;background:linear-gradient(135deg,#0f766e 0%,#065e55 100%);color:#ffffff!important;text-decoration:none;font-size:15px;font-weight:600;padding:14px 36px;border-radius:10px}
    .footer{background:#f8fafc;border-top:1px solid #e2e8f0;padding:24px 40px;text-align:center}
    .footer p{font-size:12px;color:#94a3b8;line-height:1.6}
    .footer a{color:#0f766e;text-decoration:none}
  </style>
</head>
<body>
<div class="email-wrapper">
  <div class="header">
    <div class="logo">Doc<span>Book</span></div>
    <div class="tagline">Smart Healthcare · At Your Fingertips</div>
  </div>
  <div class="hero">
    <div class="cross">❌</div>
    <h1>Appointment Request Rejected</h1>
    <p>Unfortunately your appointment request could not be accommodated at this time.</p>
  </div>
  <div class="body">
    <p class="greeting">Dear <strong><?php echo e($patientName); ?></strong>,</p>
    <p class="greeting" style="margin-top:8px;color:#475569;font-size:14px;">
      We regret to inform you that your appointment request with
      <strong>Dr. <?php echo e($doctorName); ?></strong> on
      <strong><?php echo e(\Carbon\Carbon::parse($appointmentDate)->format('l, d F Y')); ?></strong>
      has been <strong style="color:#991b1b;">rejected</strong>.
    </p>
    <div class="info-box">
      <p>You may search for another available doctor or try booking on a different date. We're sorry for the inconvenience.</p>
    </div>
    <div class="cta-section">
      <a href="<?php echo e(config('app.url')); ?>/patient/search" class="btn">Find Another Doctor</a>
    </div>
    <p style="font-size:14px;margin-top:20px;color:#1e293b;">
      Warm regards,<br/>
      <strong style="color:#0f766e;">The DocBook Team</strong>
    </p>
  </div>
  <div class="footer">
    <p>This email was sent from <a href="<?php echo e(config('app.url')); ?>">DocBook</a> — Smart Healthcare Platform.<br/>
    © <?php echo e(date('Y')); ?> DocBook. All rights reserved.</p>
  </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\User\Downloads\docbook1_final\docbook1\docbook1\resources\views/emails/appointment_rejected.blade.php ENDPATH**/ ?>