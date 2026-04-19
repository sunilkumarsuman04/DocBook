<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Appointment Confirmed — DocBook</title>
  <!--[if mso]><noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript><![endif]-->
  <style>
    /* Reset */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
      background-color: #f1f5f9;
      color: #1e293b;
      -webkit-font-smoothing: antialiased;
    }

    /* Wrapper */
    .email-wrapper {
      max-width: 600px;
      margin: 32px auto;
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 24px rgba(0,0,0,.08);
    }

    /* Header */
    .header {
      background: linear-gradient(135deg, #0f766e 0%, #065e55 100%);
      padding: 36px 40px;
      text-align: center;
    }
    .header .logo {
      font-size: 28px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.5px;
    }
    .header .logo span { color: #5eead4; }
    .header .tagline {
      color: rgba(255,255,255,.7);
      font-size: 13px;
      margin-top: 4px;
    }

    /* Hero badge */
    .hero {
      background: #f0fdfa;
      border-bottom: 1px solid #ccfbf1;
      padding: 32px 40px;
      text-align: center;
    }
    .checkmark {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 64px;
      height: 64px;
      background: #14b8a6;
      border-radius: 50%;
      font-size: 28px;
      margin-bottom: 16px;
      box-shadow: 0 8px 24px rgba(20,184,166,.35);
    }
    .hero h1 {
      font-size: 22px;
      font-weight: 700;
      color: #0f766e;
      margin-bottom: 8px;
    }
    .hero p {
      font-size: 14px;
      color: #475569;
      line-height: 1.6;
    }

    /* Body */
    .body {
      padding: 36px 40px;
    }

    /* Greeting */
    .greeting {
      font-size: 16px;
      color: #1e293b;
      margin-bottom: 24px;
      line-height: 1.6;
    }
    .greeting strong { color: #0f766e; }

    /* Detail card */
    .detail-card {
      background: #f8fafc;
      border: 1.5px solid #e2e8f0;
      border-radius: 12px;
      overflow: hidden;
      margin: 24px 0;
    }
    .detail-card-header {
      background: #0f766e;
      color: #ffffff;
      font-weight: 600;
      font-size: 13px;
      padding: 10px 20px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .detail-row {
      display: flex;
      align-items: center;
      padding: 14px 20px;
      border-bottom: 1px solid #e2e8f0;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-icon {
      font-size: 18px;
      width: 32px;
      flex-shrink: 0;
    }
    .detail-label {
      font-size: 12px;
      font-weight: 600;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      width: 120px;
      flex-shrink: 0;
    }
    .detail-value {
      font-size: 15px;
      font-weight: 600;
      color: #1e293b;
    }

    /* Confirmation note */
    .confirmation-box {
      background: linear-gradient(135deg, #f0fdf4, #dcfce7);
      border: 1.5px solid #86efac;
      border-radius: 12px;
      padding: 20px;
      margin: 24px 0;
    }
    .confirmation-box p {
      font-size: 14px;
      color: #15803d;
      line-height: 1.7;
    }
    .confirmation-box strong { font-weight: 700; }

    /* CTA button */
    .cta-section {
      text-align: center;
      margin: 28px 0;
    }
    .btn {
      display: inline-block;
      background: linear-gradient(135deg, #0f766e 0%, #065e55 100%);
      color: #ffffff !important;
      text-decoration: none;
      font-size: 15px;
      font-weight: 600;
      padding: 14px 36px;
      border-radius: 10px;
      box-shadow: 0 4px 14px rgba(15,118,110,.4);
    }

    /* Footer */
    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 24px 40px;
      text-align: center;
    }
    .footer p {
      font-size: 12px;
      color: #94a3b8;
      line-height: 1.6;
    }
    .footer a { color: #0f766e; text-decoration: none; }

    /* Divider */
    .divider {
      height: 1px;
      background: #e2e8f0;
      margin: 0 40px;
    }
  </style>
</head>
<body>

<div class="email-wrapper">

  <!-- Header -->
  <div class="header">
    <div class="logo">Doc<span>Book</span></div>
    <div class="tagline">Smart Healthcare · At Your Fingertips</div>
  </div>

  <!-- Hero -->
  <div class="hero">
    <div class="checkmark">✅</div>
    <h1>Appointment Confirmed!</h1>
    <p>
      Your appointment has been approved by your doctor.<br/>
      Please review the details below.
    </p>
  </div>

  <!-- Body -->
  <div class="body">

    <p class="greeting">
      Dear <strong><?php echo e($patientName); ?></strong>,
    </p>
    <p class="greeting" style="margin-top: 8px; color: #475569; font-size: 14px;">
      We're pleased to inform you that your appointment has been
      <strong style="color: #0f766e;">approved and confirmed</strong>.
      Here are your appointment details:
    </p>

    <!-- Detail card -->
    <div class="detail-card">
      <div class="detail-card-header">📋 Appointment Details</div>

      <div class="detail-row">
        <span class="detail-icon">🩺</span>
        <span class="detail-label">Doctor</span>
        <span class="detail-value">Dr. <?php echo e($doctorName); ?></span>
      </div>

      <div class="detail-row">
        <span class="detail-icon">👤</span>
        <span class="detail-label">Patient</span>
        <span class="detail-value"><?php echo e($patientName); ?></span>
      </div>

      <div class="detail-row">
        <span class="detail-icon">📅</span>
        <span class="detail-label">Date</span>
        <span class="detail-value">
          <?php echo e(\Carbon\Carbon::parse($appointmentDate)->format('l, d F Y')); ?>

        </span>
      </div>

      <div class="detail-row">
        <span class="detail-icon">🕐</span>
        <span class="detail-label">Time</span>
        <span class="detail-value">
          <?php echo e($appointmentTime); ?>

        </span>
      </div>

      <div class="detail-row">
        <span class="detail-icon">🆔</span>
        <span class="detail-label">Booking Ref</span>
        <span class="detail-value">#<?php echo e(str_pad($appointmentId, 6, '0', STR_PAD_LEFT)); ?></span>
      </div>

      <div class="detail-row">
        <span class="detail-icon">✅</span>
        <span class="detail-label">Status</span>
        <span class="detail-value" style="color: #15803d;">Approved</span>
      </div>
    </div>

    <!-- Confirmation note -->
    <div class="confirmation-box">
      <p>
        <strong>📌 Important:</strong> Please arrive <strong>10–15 minutes early</strong>
        for your appointment. If you need to cancel or reschedule, please do so at least
        <strong>2 hours in advance</strong> through the DocBook portal.
      </p>
    </div>

    <!-- CTA -->
    <div class="cta-section">
      <a href="<?php echo e(config('app.url')); ?>/patient/appointments/<?php echo e($appointmentId); ?>" class="btn">
        View Appointment
      </a>
    </div>

    <p style="font-size: 13px; color: #64748b; line-height: 1.7;">
      If you have any questions, please don't hesitate to contact us through the DocBook platform.
      We look forward to helping you with your healthcare needs.
    </p>

    <p style="font-size: 14px; margin-top: 20px; color: #1e293b;">
      Warm regards,<br/>
      <strong style="color: #0f766e;">The DocBook Team</strong>
    </p>

  </div>

  <div class="divider"></div>

  <!-- Footer -->
  <div class="footer">
    <p>
      This email was sent from <a href="<?php echo e(config('app.url')); ?>">DocBook</a> — Smart Healthcare Platform.<br/>
      © <?php echo e(date('Y')); ?> DocBook. All rights reserved.
    </p>
    <p style="margin-top: 8px;">
      <a href="<?php echo e(config('app.url')); ?>/patient/appointments">My Appointments</a>
      &nbsp;·&nbsp;
      <a href="<?php echo e(config('app.url')); ?>/contact">Help & Support</a>
    </p>
    <p style="margin-top: 8px; font-size: 11px; color: #cbd5e1;">
      Booking Reference: #<?php echo e(str_pad($appointmentId, 6, '0', STR_PAD_LEFT)); ?>

    </p>
  </div>

</div>
</body>
</html><?php /**PATH C:\Users\User\Downloads\docbook1_final\docbook1\docbook1\resources\views/emails/appointment_approved.blade.php ENDPATH**/ ?>