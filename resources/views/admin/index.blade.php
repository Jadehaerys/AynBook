@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color:var(--brand-text);">
        {{-- Inline SVG: shield-lock --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" style="color:var(--brand);" viewBox="0 0 16 16">
            <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56l.09.022c1.106.31 2.233.68 2.917.9a1.48 1.48 0 0 1 1.018 1.21 13.3 13.3 0 0 1-2.33 9.65 11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.064.625c-.28.132-.581.24-.878.24s-.598-.108-.878-.24a7 7 0 0 1-1.064-.625 11.8 11.8 0 0 1-2.518-2.453 13.3 13.3 0 0 1-2.33-9.65 1.48 1.48 0 0 1 1.019-1.21C2.49 1.265 3.6.9 4.982.56z"/>
            <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 1 1 9.5 6.5"/>
        </svg>
        Admin Panel — User Management
    </h4>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
        {{-- Inline SVG: arrow-left --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg>
        Back to Dashboard
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($users->isEmpty())
            <p class="text-center text-muted py-5">No users found.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td class="ps-3 text-muted" style="font-size:.85rem;">{{ $index + 1 }}</td>
                        <td>
                            {{ e($user->name) }}
                            {{-- badge for yourself --}}
                            @if($user->id === Auth::id())
                                <span class="badge ms-1" style="background-color:var(--brand);font-size:.65rem;">you</span>
                            @endif
                        </td>
                        <td style="font-size:.9rem;">{{ e($user->email) }}</td>
                        <td>
                            <span class="badge rounded-pill"
                                  style="background-color:{{ $user->role === 'admin' ? 'var(--brand-dark)' : '#b0bec5' }};
                                         font-size:.75rem;">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td style="font-size:.85rem;color:#888;">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                {{-- Role toggle (disabled for yourself) --}}
                                @if($user->id !== Auth::id())
                                <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                    @csrf
                                    <input type="hidden" name="role"
                                           value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                                    <button type="submit"
                                            class="btn btn-sm {{ $user->role === 'admin' ? 'btn-outline-secondary' : 'btn-outline-primary' }}"
                                            title="{{ $user->role === 'admin' ? 'Demote to user' : 'Promote to admin' }}">
                                        @if($user->role === 'admin')
                                            {{-- Inline SVG: person-dash --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1"/>
                                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                            </svg>
                                            Demote
                                        @else
                                            {{-- Inline SVG: person-check --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514"/>
                                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                            </svg>
                                            Promote
                                        @endif
                                    </button>
                                </form>
                                {{-- Delete user --}}
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Remove {{ addslashes(e($user->name)) }}? This deletes all their records too.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="Delete user">
                                        {{-- Inline SVG: trash --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                </form>
                                @else
                                    <span class="text-muted" style="font-size:.8rem;">that's you!</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<p class="text-muted mt-3" style="font-size:.8rem;">
    Total users: {{ $users->count() }}
    &nbsp;·&nbsp;
    Admins: {{ $users->where('role', 'admin')->count() }}
</p>
@endsection
