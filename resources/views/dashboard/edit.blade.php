@extends('layouts.app')
@section('title', 'Edit Record')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            <h4 class="fw-bold mb-4 d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--brand)" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                </svg>
                Edit Contact
            </h4>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div class="d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                            </svg>
                            {{ e($error) }}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- PUT method via POST (HTML forms only support GET/POST) --}}
            <form method="POST" action="{{ route('records.update', $record) }}" novalidate id="editForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', e($record->name)) }}" required maxlength="255">
                    @error('name')
                        <div class="invalid-feedback">{{ e($message) }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', e($record->email)) }}" maxlength="255">
                    @error('email')
                        <div class="invalid-feedback">{{ e($message) }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">Phone</label>
                    <input type="tel" id="phone" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', e($record->phone)) }}" maxlength="20">
                    @error('phone')
                        <div class="invalid-feedback">{{ e($message) }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">Address</label>
                    <input type="text" id="address" name="address"
                           class="form-control @error('address') is-invalid @enderror"
                           value="{{ old('address', e($record->address)) }}" maxlength="500">
                    @error('address')
                        <div class="invalid-feedback">{{ e($message) }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label fw-semibold">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="form-control @error('notes') is-invalid @enderror"
                              maxlength="1000">{{ old('notes', e($record->notes)) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ e($message) }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.146-.354l-3-3A.5.5 0 0 0 11.5 1zm5.5 11.5v-2.793l.646.647a.5.5 0 0 0 .708-.708l-1.5-1.5a.5.5 0 0 0-.708 0l-1.5 1.5a.5.5 0 0 0 .708.708L7.5 9.707V12.5h-2v-2a.5.5 0 0 0-.5-.5H3V2h8v2.5a.5.5 0 0 0 .5.5H14v9H7.5z"/>
                        </svg>
                        Update
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                        </svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ── Client-side validation ──────────────────────────────────────────────
    document.getElementById('editForm').addEventListener('submit', function (e) {
        const name = document.getElementById('name').value.trim();
        if (!name) {
            document.getElementById('name').classList.add('is-invalid');
            e.preventDefault();
        }

        const emailField = document.getElementById('email');
        const email = emailField.value.trim();
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            emailField.classList.add('is-invalid');
            e.preventDefault();
        }
    });

    document.querySelectorAll('.form-control').forEach(el => {
        el.addEventListener('input', () => el.classList.remove('is-invalid'));
    });
</script>
@endpush
