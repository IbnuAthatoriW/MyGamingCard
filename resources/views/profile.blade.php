@extends('layouts.app')
@section('title', __('Profile') . ' - MyGamingCard')

@push('styles')
<style>
    .profile-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 1.5rem; max-width: 800px;
    }
    @media (max-width: 768px) {
        .profile-grid { grid-template-columns: 1fr; }
    }
    .profile-header {
        display: flex; align-items: center; gap: 1rem;
        margin-bottom: 2rem; padding: 1.5rem;
        background: var(--card-bg); border: 1px solid var(--border);
        border-radius: var(--radius-lg); max-width: 800px;
    }
    .profile-avatar {
        width: 64px; height: 64px; border-radius: 50%;
        background: linear-gradient(135deg, var(--purple), var(--blue));
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 700; flex-shrink: 0;
    }
    .profile-name { font-size: 1.2rem; font-weight: 700; }
    .profile-email { font-size: 0.85rem; color: var(--text-muted); }
    .profile-stat { font-size: 0.85rem; color: var(--text-dim); margin-top: 0.25rem; }
</style>
@endpush

@section('content')
    <div class="page-header fade-in">
        <h1 class="page-title">{{ __('Profile') }}</h1>
        <p class="page-subtitle">{{ __('Manage your account settings') }}</p>
    </div>

    <div class="profile-header fade-in">
        <div class="profile-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
            <div class="profile-stat">{{ $cardCount }} {{ __('Total Cards') }}</div>
        </div>
    </div>

    <div class="profile-grid fade-in-delay">
        <!-- Update Profile -->
        <div class="card">
            <div class="card-header">
                <h3 style="font-size:1rem; font-weight:600;">{{ __('Update Profile') }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="form-label" for="name">{{ __('Name') }}</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">{{ __('Save Changes') }}</button>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card">
            <div class="card-header">
                <h3 style="font-size:1rem; font-weight:600;">{{ __('Change Password') }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="form-label" for="current_password">{{ __('Current Password') }}</label>
                        <input type="password" id="current_password" name="current_password" class="form-input" required>
                        @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="new_password">{{ __('New Password') }}</label>
                        <input type="password" id="new_password" name="password" class="form-input" required>
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">{{ __('Confirm New Password') }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">{{ __('Update Password') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
