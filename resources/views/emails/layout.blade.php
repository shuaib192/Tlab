<!DOCTYPE html>
<html><head><meta charset="utf-8"><style>
body{margin:0;padding:0;background:#f4f4f4;font-family:Helvetica,Arial,sans-serif}
table{border-collapse:collapse}
.container{max-width:600px;margin:0 auto;padding:20px}
.header{background:#0F172A;padding:30px 40px;text-align:center}
.header h1{color:#16A34A;font-size:24px;margin:0}
.header p{color:#94a3b8;font-size:14px;margin:5px 0 0}
.body{background:#fff;padding:40px}
.body h2{color:#0F172A;font-size:20px;margin:0 0 20px}
.body p{color:#475569;font-size:15px;line-height:1.6;margin:0 0 15px}
.details{background:#f8fafc;border-radius:12px;padding:20px;margin:20px 0}
.details dt{font-size:12px;color:#94a3b8;text-transform:uppercase;font-weight:700}
.details dd{font-size:16px;color:#0F172A;font-weight:700;margin:0 0 12px}
.btn{display:inline-block;background:#16A34A;color:#fff!important;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:700;font-size:15px}
.footer{background:#0F172A;padding:20px 40px;text-align:center}
.footer p{color:#64748b;font-size:12px;margin:0}
</style></head><body>
<table class="container"><tr><td>
<div class="header"><h1>TLab by Edfrica</h1><p>@yield('subtitle', '')</p></div>
<div class="body">
@yield('content')
<p style="color:#94a3b8;font-size:13px;margin-top:30px">If you have any questions, contact us at support@tlab.edfrica.org</p>
</div>
<div class="footer"><p>&copy; {{ date('Y') }} TLab by Edfrica. All rights reserved.</p></div>
</td></tr></table>
</body></html>
