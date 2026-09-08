<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $session->title }} — TLab LIVE</title>
    <script>
        window.JITSI = {
            domain: "{{ $jitsi->domain() }}",
            room: "{{ $session->room_name }}",
            jwt: @json($jwt),
            displayName: @json($identity['name']),
            email: @json($identity['email'] ?? null),
            moderator: @json($moderator),
            observer: @json($observer),
            forceLobby: @json($jitsi->shouldForceLobby()),
            enrollmentId: {{ (int) request('enrollment', 0) }},
            attendanceUrl: "{{ route('live.attendance', $session) }}",
            csrf: "{{ csrf_token() }}"
        };
    </script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{height:100%}
        body{background:#0B0D10;color:#FAF5E8;font-family:ui-monospace,SFMono-Regular,Menlo,monospace;display:flex;flex-direction:column;overflow:hidden}
        header{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 16px;background:#11141A;border-bottom:2px solid #00FF88;flex-wrap:wrap}
        .brand{display:flex;align-items:center;gap:10px;min-width:0}
        .badge-live{background:#00FF8820;color:#00FF88;border:1px solid #00FF8833;font-weight:800;font-size:10px;letter-spacing:2px;padding:4px 8px;border-radius:6px;white-space:nowrap}
        .title{font-weight:800;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .sub{color:#00E5FF;font-size:10px;letter-spacing:1px;text-transform:uppercase;white-space:nowrap}
        .chip{display:inline-flex;align-items:center;gap:6px;font-size:10px;font-weight:700;padding:5px 10px;border-radius:999px;white-space:nowrap}
        .chip-lobby-on{background:#FFB80020;color:#FFB800;border:1px solid #FFB80044}
        .chip-lobby-off{background:#FAF5E820;color:#FAF5E880;border:1px solid #FAF5E833}
        .chip-moderator{background:#00E5FF15;color:#00E5FF;border:1px solid #00E5FF44}
        .chip-observer{background:#FF007F15;color:#FF007F;border:1px solid #FF007F44}
        nav{display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:flex-end}
        .btn{font:inherit;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:7px 12px;border-radius:8px;cursor:pointer;border:1px solid transparent;transition:all .15s}
        .btn-mint{background:#00FF88;color:#0B0D10;border-color:#00FF88}
        .btn-mint:hover{filter:brightness(1.1)}
        .btn-outline{background:transparent;color:#FAF5E8cc;border-color:#FAF5E833}
        .btn-outline:hover{border-color:#FAF5E866}
        .btn-danger{background:transparent;color:#FF6B6B;border-color:#FF6B6B55}
        .btn-danger:hover{background:#FF6B6B22}
        #meet{flex:1;min-height:0}
        .notice{position:fixed;bottom:16px;left:50%;transform:translateX(-50%);z-index:10;background:#11141A;border:2px solid #00E5FF;color:#00E5FF;font-size:10px;font-weight:700;letter-spacing:1px;padding:8px 14px;border-radius:8px;display:none}
        @media(max-width:640px){
            .title{font-size:12px;max-width:38vw}
            .sub{display:none}
            .hide-xs{display:none}
        }
    </style>
</head>
<body>
<header>
    <div class="brand">
        <span class="badge-live">● TLAB LIVE</span>
        <div>
            <div class="title">{{ $session->title }}</div>
            <div class="sub">{{ $jitsi->domain() }}</div>
        </div>
    </div>
    <nav>
        @if($moderator)
            <span class="chip hide-xs chip-moderator">⚡ MODERATOR</span>
            <button class="btn btn-mint" id="lobbyBtn">Enable Lobby</button>
        @elseif($observer)
            <span class="chip chip-observer">👁 OBSERVER</span>
        @endif
        <button class="btn btn-outline" id="copyLink" title="Copy private join link">
            <span class="hide-xs">Copy Link</span>🔗
        </button>
        <a class="btn btn-danger no-underline" href="@if(session('active_child_id')){{ route('child.dashboard') }}@elseif(auth()->user()?->role === 'teacher'){{ route('teacher.dashboard') }}@elseif(auth()->user()?->isParent()){{ route('parent.dashboard') }}@else{{ route('admin.dashboard') }}@endif">
            Leave
        </a>
    </nav>
</header>
<div id="meet"></div>
<div class="notice" id="notice"></div>

<script src="{{ $jitsi->externalApiUrl() }}"></script>
<script>
    (function () {
        const C = window.JITSI;
        const container = document.getElementById('meet');

        const configOverwrite = {
            prejoinConfig: { enabled: true },
            disableDeepLinking: true,
            defaultLanguage: 'en',
            enableClosePage: false,
            liveStreamingEnabled: false,
            recordingEnabled: false,
            hideInviteMoreHeader: true,
            startWithAudioMuted: C.observer || !C.moderator,
            startWithVideoMuted: C.observer || !C.moderator,
            startAudioOnly: C.observer,
            toolbarButtons: [
                'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                'livestreaming', 'etherpad', 'sharedvideo', 'shareaudio',
                'embedmeeting', 'raisehand', 'videoquality', 'filmstrip',
                'invite', 'feedback', 'stats', 'shortcuts', 'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone', 'security'
            ]
        };

        const interfaceConfigOverwrite = {
            TOOLBAR_BUTTONS: [
                'microphone', 'camera', 'fullscreen', 'hangup', 'profile',
                'chat', 'raisehand', 'recording', 'tileview', 'security'
            ],
            SHOW_JITSI_WATERMARK: false,
            SHOW_WATERMARK_FOR_GUESTS: false,
            SHOW_BRAND_WATERMARK: false,
            HIDE_INVITE_MORE_HEADER: true,
            TILE_VIEW_MAX_COLUMNS: 5,
            DEFAULT_BACKGROUND: '#0B0D10',
            MOBILE_APP_PROMO: false,
            DISABLE_JOIN_LEAVE_NOTIFICATIONS: false
        };

        const options = {
            roomName: C.room,
            width: '100%',
            height: '100%',
            parentNode: container,
            configOverwrite,
            interfaceConfigOverwrite,
            userInfo: {
                displayName: C.displayName,
                email: C.email || '',
            },
            lang: 'en'
        };

        if (C.jwt) {
            options.jwt = C.jwt;
        }

        const api = new JitsiMeetExternalAPI(C.domain, options);
        let lobbyOn = C.forceLobby && C.moderator;
        let attendanceSent = false;

        const notice = document.getElementById('notice');
        function flash(msg, ms) {
            notice.textContent = msg;
            notice.style.display = 'block';
            clearTimeout(flash.t);
            flash.t = setTimeout(() => { notice.style.display = 'none'; }, ms || 2600);
        }

        const lobbyBtn = document.getElementById('lobbyBtn');
        function renderLobbyChip() {
            if (!lobbyBtn) return;
            lobbyBtn.textContent = lobbyOn ? 'Lobby ON' : 'Enable Lobby';
            lobbyBtn.style.background = lobbyOn ? '#FFB800' : '#00FF88';
            lobbyBtn.style.borderColor = lobbyOn ? '#FFB800' : '#00FF88';
        }
        renderLobbyChip();

        function sendAttendance() {
            if (attendanceSent || !C.enrollmentId) return;
            attendanceSent = true;
            fetch(C.attendanceUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': C.csrf
                },
                body: JSON.stringify({ enrollment_id: C.enrollmentId })
            }).catch(() => {});
        }

        api.addEventListeners({
            readyToClose: () => {
                window.location.href = document.querySelector('.btn-danger').href;
            },
            videoConferenceJoined: () => {
                sendAttendance();
                if (C.moderator && C.forceLobby && lobbyOn) {
                    try { api.executeCommand('toggleLobby'); } catch (e) {}
                }
                if (C.moderator) {
                    flash('You are the presenter. Students wait in the lobby until you admit them.', 5000);
                } else if (C.observer) {
                    flash('Observer mode — watching only.', 3000);
                }
            },
            lobbyToggled: (e) => {
                lobbyOn = e.lobbyEnabled;
                renderLobbyChip();
            },
            participantRoleChanged: () => {},
            errorOccurred: (e) => {
                if (e && e.error === 200) {
                    flash('Connection error — try reconnecting.', 4000);
                }
            }
        });

        if (C.moderator && lobbyBtn) {
            lobbyBtn.addEventListener('click', () => {
                lobbyOn = !lobbyOn;
                renderLobbyChip();
                try { api.executeCommand('toggleLobby'); } catch (e) {}
            });
        }

        if (document.getElementById('copyLink')) {
            document.getElementById('copyLink').addEventListener('click', () => {
                navigator.clipboard.writeText(window.location.href)
                    .then(() => flash('Join link copied.', 1800));
            });
        }
    })();
</script>
</body>
</html>