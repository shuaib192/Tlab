@php
    // Dynamic brand theme configuration based on the client or redirect URI
    $brandName = $client->name ?? 'Edfrica Client';
    $redirectUrl = $client->redirect ?? '';
    
    // Normalize string for checks
    $brandLower = strtolower($brandName);
    $urlLower = strtolower($redirectUrl);

    // Default Edfrica Identity Theme (Edfrica Emerald Green)
    $primaryColor = '#10b981'; 
    $primaryDark = '#059669';
    $secondaryColor = '#3b82f6'; // Indigo Blue
    $glowColor = 'rgba(16, 185, 129, 0.15)';
    $logoText = 'Edfrica';
    
    // 1. Detect Premium Brand Themes
    if (str_contains($brandLower, 'tlab') || str_contains($urlLower, 'tlab')) {
        $primaryColor = '#10b981'; // TLab Emerald Green
        $primaryDark = '#059669';
        $secondaryColor = '#3b82f6';
        $glowColor = 'rgba(16, 185, 129, 0.15)';
        $logoText = 'TLab';
    } elseif (str_contains($brandLower, 'buyniger') || str_contains($urlLower, 'buyniger')) {
        $primaryColor = '#f97316'; // BuyNiger Vibrant Orange
        $primaryDark = '#ea580c';
        $secondaryColor = '#ef4444'; // Coral Red
        $glowColor = 'rgba(249, 115, 22, 0.15)';
        $logoText = 'BuyNiger';
    } elseif (str_contains($brandLower, 'brandloomia') || str_contains($urlLower, 'brandloomia')) {
        $primaryColor = '#8b5cf6'; // Brandloomia Royal Violet
        $primaryDark = '#7c3aed';
        $secondaryColor = '#ec4899'; // Hot Pink
        $glowColor = 'rgba(139, 92, 246, 0.15)';
        $logoText = 'Brandloomia';
    } elseif (!empty($brandName) && $brandLower !== 'edfrica' && $brandLower !== 'edfrica identity') {
        // 2. Dynamic Adaptive Brand Theme Generation (Fallback for new clients)
        // Hash the brand name to generate a stable, unique Hue (0-360)
        $hue = abs(crc32($brandName)) % 360;
        
        $primaryColor = "hsl({$hue}, 75%, 52%)";
        $primaryDark = "hsl({$hue}, 75%, 42%)";
        // Secondary color is an adjacent harmonious color (shifted hue)
        $secondaryColor = "hsl(" . (($hue + 35) % 360) . ", 75%, 50%)";
        $glowColor = "hsla({$hue}, 75%, 52%, 0.15)";
        $logoText = $brandName;
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorize {{ $brandName }} - Edfrica Identity</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: {{ $primaryColor }};
            --primary-dark: {{ $primaryDark }};
            --secondary: {{ $secondaryColor }};
            --bg-dark: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --glass-bg: rgba(15, 23, 42, 0.45);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glow: {{ $glowColor }};
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        .ambient-glow-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--glow) 0%, rgba(0, 0, 0, 0) 70%);
            top: -10%;
            left: -10%;
            z-index: 0;
            pointer-events: none;
        }

        .ambient-glow-2 {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--glow) 0%, rgba(0, 0, 0, 0) 70%);
            bottom: -15%;
            right: -10%;
            z-index: 0;
            pointer-events: none;
        }

        .container {
            width: 100%;
            max-width: 520px;
            padding: 24px;
            z-index: 10;
        }

        .auth-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .header-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .app-badges {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .badge-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .badge-icon.primary-brand {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 8px 16px var(--glow);
            border: none;
        }

        .badge-icon svg {
            width: 28px;
            height: 28px;
            color: white;
            fill: white;
        }

        .arrow-divider {
            color: var(--text-muted);
            font-size: 20px;
            font-weight: 300;
        }

        .card-title {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .card-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 6px;
        }

        .request-message {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 28px;
            font-size: 15px;
            line-height: 1.5;
            text-align: center;
        }

        .request-message strong {
            color: var(--primary);
        }

        .scopes-section {
            margin-bottom: 32px;
        }

        .scopes-title {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .scopes-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .scope-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            color: var(--text-main);
        }

        .scope-item-icon {
            color: var(--primary);
            flex-shrink: 0;
            margin-top: 2px;
            width: 16px;
            height: 16px;
        }

        .buttons-group {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-action {
            flex: 1;
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-approve {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 12px var(--glow);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--glow);
        }

        .btn-deny {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .btn-deny:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .footer a {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="container">
        <div class="auth-card">
            <div class="header-section">
                <div class="app-badges">
                    <div class="badge-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                    </div>
                    <div class="arrow-divider">➔</div>
                    <div class="badge-icon primary-brand">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                </div>
                <h1 class="card-title">Access Request</h1>
                <p class="card-subtitle">SSO Authorization via Edfrica Identity</p>
            </div>

            <div class="request-message">
                <strong>{{ $client->name }}</strong> is requesting permission to access your Edfrica account.
            </div>

            <div class="scopes-section">
                <h2 class="scopes-title">This application will be able to:</h2>
                <ul class="scopes-list">
                    <li class="scope-item">
                        <svg class="scope-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Read your public profile details (Name, Username, Avatar).</span>
                    </li>
                    <li class="scope-item">
                        <svg class="scope-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Access your verified email address.</span>
                    </li>
                    @if (count($scopes) > 0)
                        @foreach ($scopes as $scope)
                            <li class="scope-item">
                                <svg class="scope-item-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span>{{ $scope->description }}</span>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="buttons-group">
                <!-- Deny Button -->
                <form method="post" action="{{ route('passport.authorizations.deny') }}" style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="state" value="{{ $request->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                    <button type="submit" class="btn-action btn-deny">Deny</button>
                </form>

                <!-- Authorize Button -->
                <form method="post" action="{{ route('passport.authorizations.approve') }}" style="flex: 1;">
                    @csrf
                    <input type="hidden" name="state" value="{{ $request->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">
                    <button type="submit" class="btn-action btn-approve">
                        <span>Authorize</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="footer">
            Logged in securely. Need help? Contact <a href="https://edfrica.org">Edfrica Support</a>.
        </div>
    </div>
</body>
</html>
