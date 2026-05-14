@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card p-4">
            <h3 class="mb-1 text-center fw-bold" style="color:var(--brand-text);">
                {{-- Inline SVG: envelope-at --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="me-2" style="color:var(--brand);" viewBox="0 0 16 16">
                    <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
                    <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.03v.214C9 13.43 10.01 14.5 11.771 14.5h.087a1.5 1.5 0 0 0 1.077-.417l.004.016c0 .352.23.508.504.508.41 0 .805-.383.805-1.078v-2.096c0-1.26-.636-2.041-1.966-2.041h-.088c-.978 0-1.72.57-2.023 1.434h-.016C9.987 9.863 10.686 9 12 9c1.32 0 2.04.844 2.04 2.04v.357c0 .91-.577 1.541-1.308 1.541-.55 0-.944-.365-.944-.89v-.35c0-.875.613-1.541 1.435-1.541h.264c.52 0 .964.249 1.132.64h.016v-.5c0-.35-.233-.508-.504-.508h-.077c-.347 0-.706.295-.815.66h-.016c.018-.148.025-.317.025-.5 0-1.41-1.003-2.38-2.328-2.38h-.063C9.23 7.95 8 9.077 8 11.01v.285C8 13.163 9.217 15 11.8 15c1.21 0 2.16-.43 2.447-1.065v-.016c-.3.568-1.034 1.025-2.16 1.025-.928 0-1.576-.386-1.576-1.287v-.148c0-.93.598-1.518 1.463-1.518h.087c.867 0 1.308.5 1.308 1.39v.103c0 .603-.31.875-.875.875z"/>
                </svg>
                Forgot Password
            </h3>
            <p class="text-center text-muted mb-4" style="font-size:.9rem;">
                No worries! Enter your email and we'll send you a reset link.
            </p>

            {{-- server-side errors --}}
            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" novalidate id="forgotForm">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark w-100 d-flex align-items-center justify-content-center gap-2">
                    {{-- Inline SVG: send --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                    </svg>
                    Send Reset Link
                </button>
            </form>

            <hr>
            <p class="text-center mb-0">
                Remembered it?
                <a href="{{ route('login') }}" style="color:var(--brand);">Back to Login</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('forgotForm').addEventListener('submit', function (e) {
    const email = document.getElementById('email').value.trim();
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('email').classList.add('is-invalid');
        e.preventDefault();
    }
});
</script>
@endpush
@endsection
