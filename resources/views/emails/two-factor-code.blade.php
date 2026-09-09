<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f4f6f5;margin:0;padding:40px 16px}
        .box{max-width:440px;margin:0 auto;background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:32px}
        .brand{font-size:20px;font-weight:800;color:#1a2e22;margin-bottom:4px}
        .sub{color:#6b7280;font-size:14px;margin-bottom:24px}
        .code{font-size:32px;font-weight:800;letter-spacing:8px;color:#166534;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:16px;text-align:center}
        .note{color:#6b7280;font-size:13px;margin-top:16px;line-height:1.5}
        .dim{color:#9ca3af;font-size:12px;margin-top:8px}
    </style>
</head>
<body>
    <div class="box">
        <div class="brand">TLab by Edfrica</div>
        <div class="sub">Two-factor verification code for {{ $userName }}</div>
        <div class="code">{{ $code }}</div>
        <div class="note">Enter this code on the login screen to verify your identity.</div>
        <div class="dim">This code expires in 10 minutes. If you did not attempt to sign in, someone may be trying to access your account — please contact TLab support.</div>
    </div>
</body>
</html>