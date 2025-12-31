<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Loops Version Service</title>
    <meta name="description" content="Internal service for Loops that caches GitHub release metadata and serves a JSON version endpoint.">

    <style>
        :root {
            --bg: #0b0b0f;
            --card: rgba(255,255,255,.06);
            --border: rgba(255,255,255,.10);
            --text: rgba(255,255,255,.92);
            --muted: rgba(255,255,255,.72);
            --muted2: rgba(255,255,255,.60);
            --link: rgba(255,255,255,.92);
            --shadow: 0 20px 60px rgba(0,0,0,.45);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
            background:
                radial-gradient(900px 420px at 25% 10%, rgba(255, 120, 60, .20), transparent 60%),
                radial-gradient(900px 420px at 80% 35%, rgba(255, 40, 160, .14), transparent 60%),
                radial-gradient(800px 420px at 55% 90%, rgba(120, 160, 255, .10), transparent 60%),
                var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 16px;
        }
        .wrap { width: 100%; max-width: 920px; }
        .top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text);
        }
        .brand img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            filter: drop-shadow(0 6px 18px rgba(0,0,0,.35));
        }
        .brand strong { font-size: 14px; letter-spacing: .2px; }
        .pill {
            border: 1px solid var(--border);
            background: rgba(255,255,255,.05);
            padding: 8px 10px;
            border-radius: 999px;
            color: var(--muted);
            font-size: 12px;
            white-space: nowrap;
        }
        .card {
            border: 1px solid var(--border);
            background: var(--card);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 26px;
            backdrop-filter: blur(10px);
        }
        h1 {
            margin: 0 0 8px;
            font-size: 28px;
            line-height: 1.15;
            letter-spacing: -0.3px;
        }
        p { margin: 0; color: var(--muted); line-height: 1.6; }
        .grid {
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 18px;
            margin-top: 18px;
        }
        @media (max-width: 860px) {
            .grid { grid-template-columns: 1fr; }
            .top { flex-direction: column; align-items: flex-start; }
        }
        .section {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            background: rgba(0,0,0,.18);
        }
        .section h2 {
            margin: 0 0 8px;
            font-size: 14px;
            color: var(--text);
            letter-spacing: .2px;
        }
        code, pre {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }
        pre {
            margin: 0;
            padding: 12px;
            border-radius: 12px;
            word-break: break-all;
            white-space: pre-wrap;
            border: 1px solid var(--border);
            background: rgba(0,0,0,.35);
            overflow: auto;
            color: rgba(255,255,255,.86);
            font-size: 12.5px;
            line-height: 1.5;
        }
        a { color: var(--link); text-decoration: underline; text-decoration-color: rgba(255,255,255,.35); }
        a:hover { text-decoration-color: rgba(255,255,255,.8); }
        .warn {
            margin-top: 14px;
            border: 1px solid rgba(255, 180, 80, .28);
            background: rgba(255, 180, 80, .08);
            border-radius: 12px;
            padding: 12px 14px;
            color: rgba(255,255,255,.88);
        }
        .warn strong { display: inline-block; margin-right: 6px; }
        .footer {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 12px;
            color: var(--muted2);
            font-size: 12px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="top">
        <a class="brand" href="https://joinloops.org" target="_blank">
            <img src="https://joinloops.org/img/logo-small.png" alt="Loops logo">
            <strong>Loops</strong>
        </a>

        <div class="pill" title="This endpoint is intended for internal use only.">
            Internal Service
        </div>
    </div>

    <div class="card">
        <h1>Loops Version Service</h1>
        <p>
            This is an internal utility used by Loops infrastructure and clients to fetch the latest Loops release
            information from GitHub, cache it, and serve a small JSON payload indicating the current version and whether
            it is up to date.
        </p>

        <div class="warn">
            <strong>Note:</strong>
            This service is not intended for public use. For the Loops project, documentation, and downloads, visit
            <a href="https://joinloops.org" target="_blank">joinloops.org</a>.
        </div>

        <div class="grid">
            <div class="section">
                <h2>What it does</h2>
                <p style="margin-bottom: 10px;">
                    - Uses a GitHub token server-side to query release metadata<br>
                    - Caches release/version info to reduce API calls<br>
                    - Serves a JSON response for consumers
                </p>

                <h2>Example response</h2>
                <pre>{
  "name": "v1.0.0-beta.6 - For You Feed, Better Mobile & Bookmarks",
  "version": "1.0.0-beta.6",
  "url": "https://github.com/joinloops/loops-server/releases/tag/v1.0.0-beta.6",
  "published_at": "2025-12-15T10:59:59Z"
}</pre>
            </div>

            <div class="section">
                <h2>Endpoints</h2>
                <p style="margin-bottom: 10px;">
                    If enabled in this app, consumers can call:
                </p>
                <pre>GET <a href="{{ url('/latest.json') }}">/latest.json</a></pre>
                <p style="margin-top: 10px;">
                    Version details:
                </p>
                <pre>GET <a href="{{ url('/versions.json') }}">/versions.json</a></pre>

                <p style="margin-top: 10px;">
                    If you are looking for Loops:
                    <a href="https://joinloops.org" target="_blank" rel="noopener noreferrer">joinloops.org</a>
                </p>
            </div>
        </div>

        <div class="footer">
            <span>Copyright © {{ date('Y') }} JoinLoops.org. All Rights Reserved.</span>
        </div>
    </div>
</div>
</body>
</html>
