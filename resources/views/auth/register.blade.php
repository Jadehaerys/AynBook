@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h3 class="mb-1 text-center fw-bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="var(--brand)" viewBox="0 0 16 16" class="me-1">
                    <path d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                </svg>
                AynBook
            </h3>
            <p class="text-center mb-4" style="font-size:.85rem; color:var(--brand-text)">Create your account</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div><i class="bi bi-x-circle me-1"></i>{{ e($error) }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" novalidate id="registerForm">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                        maxlength="255"
                        placeholder="Juan dela Cruz"
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ e($message) }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                        maxlength="255"
                        placeholder="you@example.com"
                        autocomplete="email"
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
                            minlength="8"
                            placeholder="Min. 8 characters"
                            autocomplete="new-password"
                        >
                        <button class="btn btn-outline-secondary" type="button" id="togglePwd" tabindex="-1">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ e($message) }}</div>
                        @enderror
                    </div>
                    {{-- Visual password strength indicator --}}
                    <div class="progress mt-2" style="height:5px">
                        <div class="progress-bar" id="strengthBar" role="progressbar" style="width:0%"></div>
                    </div>
                    <small id="strengthText" class="text-muted"></small>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        required
                        placeholder="Re-enter password"
                        autocomplete="new-password"
                    >
                    <div class="invalid-feedback" id="confirmError"></div>
                </div>

                <button type="submit" class="btn btn-dark w-100 d-flex justify-content-center align-items-center gap-2">
                    {{-- Inline SVG: person-check --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                    </svg>
                    Register
                </button>
            </form>

            <hr>
            <p class="text-center mb-0">
                Already have an account?
                <a href="{{ route('login') }}">Log in here</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Password strength meter ────────────────────────────────────────────
    document.getElementById('password').addEventListener('input', function () {
        const val = this.value;
        let strength = 0;
        if (val.length >= 8)              strength++;
        if (/[A-Z]/.test(val))            strength++;
        if (/[0-9]/.test(val))            strength++;
        if (/[^A-Za-z0-9]/.test(val))     strength++;

        const bar  = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        const map  = [
            { w: '25%', cls: 'bg-danger',  label: 'Weak' },
            { w: '50%', cls: 'bg-warning', label: 'Fair' },
            { w: '75%', cls: 'bg-info',    label: 'Good' },
            { w: '100%',cls: 'bg-success', label: 'Strong' },
        ];
        const s = map[strength - 1] || { w: '0%', cls: '', label: '' };
        bar.style.width = s.w;
        bar.className   = `progress-bar ${s.cls}`;
        text.textContent = s.label ? `Strength: ${s.label}` : '';
    });

    // ── Client-side validation ──────────────────────────────────────────────
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        let valid = true;
        const name  = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const pwd   = document.getElementById('password').value;
        const conf  = document.getElementById('password_confirmation').value;

        if (!name) { document.getElementById('name').classList.add('is-invalid'); valid = false; }
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('email').classList.add('is-invalid'); valid = false;
        }
        if (pwd.length < 8) { document.getElementById('password').classList.add('is-invalid'); valid = false; }
        if (pwd !== conf) {
            const c = document.getElementById('password_confirmation');
            c.classList.add('is-invalid');
            document.getElementById('confirmError').textContent = 'Passwords do not match.';
            c.nextElementSibling; // reference to show feedback
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

    // Remove is-invalid on re-type
    document.querySelectorAll('.form-control').forEach(el => {
        el.addEventListener('input', () => el.classList.remove('is-invalid'));
    });
</script>
@endpush
