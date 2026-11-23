@extends('layouts.app')
@section('title', __('Create Account') . ' - MyGamingCard')

@section('content')
<div style="max-width: 440px; margin: 3rem auto;">
    <div class="card fade-in">
        <div class="card-header" style="text-align:center;">
            <h2 style="font-family:'Orbitron',monospace; font-size:1.3rem; font-weight:700;">{{ __('Create Account') }}</h2>
            <p style="color:var(--text-muted); font-size:0.85rem; margin-top:0.25rem;">{{ __('Join the gaming community') }}</p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">{{ __('Name') }}</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" placeholder="{{ __('Name') }}" required autofocus>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="you@example.com" required>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">{{ __('Password') }}</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Min 8 characters" required>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="{{ __('Confirm Password') }}" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">{{ __('Create Account') }}</button>
            </form>
            <p style="text-align:center; margin-top:1.25rem; font-size:0.85rem; color:var(--text-muted);">
                {{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Sign In') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
