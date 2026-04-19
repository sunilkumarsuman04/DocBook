<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome — DocBook</title>

<style>
  body {
    font-family: Arial, sans-serif;
    background:#f3f4f6;
    margin:0;
  }

  .card {
    max-width:420px;
    margin:15px auto;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
  }

  .header {
    background:#0f766e;
    color:#fff;
    text-align:center;
    padding:18px;
    font-size:18px;
    font-weight:bold;
  }

  .body {
    padding:20px;
    text-align:center;
    color:#111827;
  }

  .title {
    font-size:18px;
    margin-bottom:10px;
  }

  .text {
    font-size:13px;
    color:#6b7280;
    margin-bottom:12px;
  }

  .note {
    background:#fff7ed;
    color:#92400e;
    font-size:12px;
    padding:10px;
    border-radius:8px;
    margin-top:10px;
  }

  .footer {
    font-size:10px;
    color:#9ca3af;
    text-align:center;
    padding:10px;
  }

</style>

</head>

<body>

<div class="card">

  <!-- HEADER -->

  <div class="header">
    DocBook
  </div>

  <!-- BODY -->

  <div class="body">

```
<div class="title">
  Welcome {{ $user->name }} 👋
</div>

<div class="text">
  Your account has been successfully created.
</div>

@if($user->role === 'doctor')
<div class="note">
  Your account will be reviewed by admin before accepting patients.
</div>
@endif

<div style="margin-top:15px; font-size:13px;">
  — <strong style="color:#0f766e;">DocBook Team</strong>
</div>
```

  </div>

  <!-- FOOTER -->

  <div class="footer">
    © {{ date('Y') }} DocBook
  </div>

</div>

</body>
</html>
