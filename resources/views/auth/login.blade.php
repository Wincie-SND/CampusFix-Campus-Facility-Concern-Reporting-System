@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
<main class="cf-auth-wrap">
    <section class="cf-auth-promo">
        <p class="cf-hero-label">CampusFix workspace</p>
        <h1>Your campus reports, all in one place.</h1>
        <p>Follow the concerns you have submitted or review campus reports if your account has staff or faculty access.</p>
        <div class="cf-hero-points" style="grid-template-columns: 1fr; border: 0; padding: 18px 0 0">
            <div class="cf-hero-point"><span>✓</span><span>Reports stay connected to your account for easy follow-up.</span></div>
            <div class="cf-hero-point"><span>✓</span><span>Campus staff and faculty keep report statuses current.</span></div>
        </div>
    </section>
    <section class="cf-auth-card">
        <p class="cf-eyebrow">Welcome back</p>
        <h2>Sign in to CampusFix</h2>
        <p>Use the credentials for your student, guest, faculty, or staff account.</p>

        @if($errors->any())
            <div class="cf-form-errors" role="alert" style="margin-top: 15px">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.store') }}" method="POST" class="cf-auth-form">
            @csrf
            <div class="cf-field">
                <label for="email" class="cf-label">Email address</label>
                <input class="cf-control" id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="you@university.edu">
                @error('email')<p class="cf-help">{{ $message }}</p>@enderror
            </div>
            <div class="cf-field">
                <label for="password" class="cf-label">Password</label>
                <input class="cf-control" id="password" name="password" type="password" required autocomplete="current-password" placeholder="Enter your password">
                @error('password')<p class="cf-help">{{ $message }}</p>@enderror
            </div>
            <label class="cf-auth-check"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button class="cf-button cf-button-primary" type="submit">Sign in</button>
        </form>
        <p class="cf-auth-switch">New to CampusFix? <a href="{{ route('register') }}">Create a student or guest account</a></p>
    </section>
</main>
@endsection
