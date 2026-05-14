<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF meta tag – used by JS if needed --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AynBook') – AynBook</title>

    {{-- Bootstrap 5 CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    {{-- Bootstrap Icons (SVG icon font — vectors under the hood) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* ── Brand palette: dusty rose + nude cream ───────────────────── */
        :root {
            --brand:        #c4748a;   /* dusty rose */
            --brand-dark:   #a85d75;   /* hover / pressed */
            --brand-light:  #f5dde3;   /* blush tint */
            --nude-bg:      #fdf0f3;   /* page background */
            --nude-card:    #fff9fb;   /* card background */
            --brand-text:   #5a2d3a;   /* dark rose for text */
        }

        /* ── Base ─────────────────────────────────────────────────────── */
        body {
            background-color: var(--nude-bg);
            color: #2d1f23;
        }

        /* ── Navbar ───────────────────────────────────────────────────── */
        .navbar {
            background-color: var(--brand) !important;
            box-shadow: 0 2px 8px rgba(196,116,138,.25);
        }
        .navbar-brand { font-weight: 700; letter-spacing: .5px; }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.9%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ── Cards ────────────────────────────────────────────────────── */
        .card {
            border: none;
            background-color: var(--nude-card);
            box-shadow: 0 4px 20px rgba(196,116,138,.12);
            border-radius: 14px;
        }

        /* ── Table ────────────────────────────────────────────────────── */
        .table th {
            background-color: var(--brand);
            color: #fff;
        }
        .table-hover tbody tr:hover {
            background-color: var(--brand-light);
        }

        /* ── Buttons: remap btn-dark and btn-primary to brand ─────────── */
        .btn-dark,
        .btn-primary {
            background-color: var(--brand) !important;
            border-color:     var(--brand) !important;
            color: #fff !important;
        }
        .btn-dark:hover,
        .btn-primary:hover {
            background-color: var(--brand-dark) !important;
            border-color:     var(--brand-dark) !important;
        }
        .btn-outline-primary {
            color:        var(--brand) !important;
            border-color: var(--brand) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--brand-light) !important;
            color:            var(--brand-dark) !important;
        }
        .btn-outline-secondary {
            color:        var(--brand-text);
            border-color: #d9b0bb;
        }
        .btn-outline-secondary:hover {
            background-color: var(--brand-light);
            color:            var(--brand-dark);
            border-color:     var(--brand);
        }
        /* Logout button in navbar */
        .btn-outline-light:hover {
            background-color: rgba(255,255,255,.2) !important;
        }

        /* ── Form controls ────────────────────────────────────────────── */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .25rem rgba(196,116,138,.2);
        }
        .form-check-input:checked {
            background-color: var(--brand);
            border-color:     var(--brand);
        }

        /* ── Alerts ───────────────────────────────────────────────────── */
        .alert-success {
            background-color: #fce8ee;
            border-color:     #f0c4cf;
            color:            var(--brand-text);
        }
        .alert-danger {
            background-color: #fdf0f0;
            border-color:     #f5c6c6;
            color:            #7a2d2d;
        }

        /* ── Pagination ───────────────────────────────────────────────── */
        .page-link {
            color: var(--brand);
            border-color: #f0d0d8;
        }
        .page-link:hover {
            background-color: var(--brand-light);
            color: var(--brand-dark);
            border-color: var(--brand);
        }
        .page-item.active .page-link {
            background-color: var(--brand);
            border-color:     var(--brand);
        }

        /* ── Misc ─────────────────────────────────────────────────────── */
        hr { border-color: #f0d0d8; }
    </style>
</head>
<body>

    {{-- Navigation bar (only shown to authenticated users) --}}
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                {{-- Inline SVG: journal with heart bookmark --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                </svg>
                AynBook
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <span class="nav-link text-white d-flex align-items-center gap-1">
                            {{-- Inline SVG: person circle --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                            </svg>
                            {{-- e() escapes output to prevent XSS --}}
                            {{ e(Auth::user()->name) }}
                            {{-- show role badge so it's clear who's admin --}}
                            @if(Auth::user()->role === 'admin')
                                <span class="badge ms-1" style="background-color:var(--brand-dark);font-size:.65rem;">admin</span>
                            @endif
                        </span>
                    </li>
                    {{-- Admin panel link — only visible to admins --}}
                    @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center gap-1" href="{{ route('admin.index') }}">
                            {{-- Inline SVG: shield-lock --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56l.09.022c1.106.31 2.233.68 2.917.9a1.48 1.48 0 0 1 1.018 1.21 13.3 13.3 0 0 1-2.33 9.65 11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.064.625c-.28.132-.581.24-.878.24s-.598-.108-.878-.24a7 7 0 0 1-1.064-.625 11.8 11.8 0 0 1-2.518-2.453 13.3 13.3 0 0 1-2.33-9.65 1.48 1.48 0 0 1 1.019-1.21C2.49 1.265 3.6.9 4.982.56z"/>
                                <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 1 1 9.5 6.5"/>
                            </svg>
                            Admin
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        {{-- POST logout with CSRF token --}}
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm ms-2 d-flex align-items-center gap-1">
                                {{-- Inline SVG: box-arrow-right --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <div class="container py-2">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                {{-- Escape to prevent XSS in flash messages --}}
                {{ e(session('success')) }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" onclick="this.closest('.alert').remove()"></button>
            </div>
        @endif

        {{-- status is what Laravel's Password facade sends back (e.g., "We have emailed your password reset link!") --}}
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                {{ e(session('status')) }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" onclick="this.closest('.alert').remove()"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
                {{ e(session('error')) }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" onclick="this.closest('.alert').remove()"></button>
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Bootstrap 5 JS Bundle (includes Popper) — no SRI so jsDelivr CDN updates don't break it --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
