<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $certificate->title }}</title>
    <style>
        @page { margin: 0; padding: 0; }
        body {
            margin: 0; padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background: #f8fafc;
        }
        .certificate-wrapper {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            box-sizing: border-box;
        }
        .certificate {
            width: 900px;
            background: white;
            border: 12px solid #16A34A;
            border-radius: 24px;
            padding: 50px 60px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        }
        .certificate::before {
            content: '';
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border: 2px solid #16A34A20;
            border-radius: 16px;
            pointer-events: none;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #16A34A;
            margin: 0 0 5px;
        }
        .header h2 {
            font-size: 36px;
            font-weight: 900;
            color: #0F172A;
            margin: 0;
        }
        .header .subtitle {
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 5px;
        }
        .body {
            text-align: center;
            padding: 30px 0;
        }
        .body .awarded-to {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 5px;
        }
        .body .child-name {
            font-size: 42px;
            font-weight: 900;
            color: #0F172A;
            margin: 0 0 5px;
        }
        .body .for-text {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 5px;
        }
        .body .course-name {
            font-size: 28px;
            font-weight: 700;
            color: #16A34A;
            margin: 0 0 20px;
        }
        .body .details {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 20px;
        }
        .body .details div {
            text-align: center;
        }
        .body .details .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
        }
        .body .details .value {
            font-size: 16px;
            font-weight: 700;
            color: #0F172A;
            margin-top: 2px;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: end;
            margin-top: 30px;
            padding-top: 20px;
        }
        .footer .qr {
            text-align: center;
        }
        .footer .qr img {
            width: 80px;
            height: 80px;
        }
        .footer .qr span {
            display: block;
            font-size: 9px;
            color: #94a3b8;
            margin-top: 4px;
        }
        .footer .id {
            font-size: 11px;
            color: #94a3b8;
        }
        .footer .id strong {
            color: #0F172A;
        }
        .seal {
            width: 60px;
            height: 60px;
            background: #16A34A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 900;
            font-size: 24px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <div class="certificate">
            <div class="header">
                <h1>TLab by Edfrica</h1>
                <h2>Certificate of Completion</h2>
                <div class="subtitle">Awarded for successful course completion</div>
            </div>
            <div class="body">
                <div class="awarded-to">This certificate is proudly awarded to</div>
                <div class="child-name">{{ $certificate->child->name }}</div>
                <div class="for-text">for successfully completing the course</div>
                <div class="course-name">{{ $certificate->course->title }}</div>
                <div class="details">
                    <div>
                        <div class="label">Grade</div>
                        <div class="value">{{ $certificate->grade ?? 'Pass' }}</div>
                    </div>
                    <div>
                        <div class="label">Rank</div>
                        <div class="value">{{ $certificate->child->rank }}</div>
                    </div>
                    <div>
                        <div class="label">Date</div>
                        <div class="value">{{ $certificate->issued_at->format('F j, Y') }}</div>
                    </div>
                    <div>
                        <div class="label">Total XP</div>
                        <div class="value">{{ number_format($certificate->child->xp) }}</div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div>
                    <div class="seal">T</div>
                    <div style="font-size:10px;color:#16A34A;font-weight:700;margin-top:4px;text-align:center">TLab</div>
                </div>
                <div class="qr">
                    <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
                    <span>Scan to verify</span>
                </div>
                <div class="id">
                    ID: <strong>{{ $certificate->certificate_id }}</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
