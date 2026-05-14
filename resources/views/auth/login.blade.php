@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card p-4">
            <h3 class="mb-1 text-center fw-bold">
                {{-- Inline SVG: journal-bookmark heart --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="var(--brand)" viewBox="0 0 16 16" class="me-1">
                    <path d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                </svg>
                AynBook
            </h3>
            <p class="text-center mb-4" style="font-size:.85rem; color:var(--brand-text)">Welcome back</p>

            {{-- Server-side error bag --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div><i class="bi bi-x-circle me-1"></i>{{ e($error) }}</div>
                    @endforeach
                </div>
            @endif

            {{-- POST request for sensitive data (security requirement) --}}
            <form method="POST" action="{{ route('login') }}" novalidate id="loginForm">
                {{-- CSRF token – protects against CSRF attacks --}}
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ e($message) }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                        <button class="btn btn-outline-secondary" type="button" id="togglePwd" tabindex="-1">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ e($message) }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-2">
                    {{-- Inline SVG: box-arrow-in-right --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg>
                    Sign In
                </button>
            </form>

            <hr>
            <p class="text-center mb-1">
                Don't have an account?
                <a href="{{ route('register') }}" style="color:var(--brand);">Register here</a>
            </p>
            <p class="text-center mb-0" style="font-size:.88rem;">
                <a href="{{ route('password.request') }}" style="color:var(--brand);">Forgot your password?</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Client-side validation ──────────────────────────────────────────────
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        let valid = true;

        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('email').classList.add('is-invalid');
            valid = false;
        }
        if (password.length < 1) {
            document.getElementById('password').classList.add('is-invalid');
            valid = false;
        }
        if (!valid) e.preventDefault();
    });

    // ── Password visibility toggle ─────────────────────────────────────────
    document.getElementById('togglePwd').addEventListener('click', function () {
        const pwd  = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        const show = pwd.type === 'password';
        pwd.type   = show ? 'text' : 'password';
        icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
</script>
@endpush
