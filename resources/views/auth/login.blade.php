@extends('layouts.app')
@section('title', __('Login') . ' - MyGamingCard')

@section('content')
<div style="max-width: 440px; margin: 3rem auto;">
    <div class="card fade-in">
        <div class="card-header" style="text-align:center;">
            <h2 style="font-family:'Orbitron',monospace; font-size:1.3rem; font-weight:700;">{{ __('Welcome Back') }}</h2>
            <p style="color:var(--text-muted); font-size:0.85rem; margin-top:0.25rem;">{{ __('Sign in to your account') }}</p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">{{ __('Password') }}</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="{{ __('Password') }}" required>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span style="font-size:0.85rem; color:var(--text-muted);">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">{{ __('Sign In') }}</button>
            </form>
            <p style="text-align:center; margin-top:1.25rem; font-size:0.85rem; color:var(--text-muted);">
                {{ __("Don't have an account?") }} <a href="{{ route('register') }}">{{ __('Create one') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
