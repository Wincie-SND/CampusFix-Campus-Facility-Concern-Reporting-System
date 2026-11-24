@extends('layouts.app')

@section('title', 'Create a CampusFix account')

@section('content')
<main class="cf-auth-wrap">
    <section class="cf-auth-promo">
        <p class="cf-hero-label">Make a difference</p>
        <h1>A small report can improve a shared space.</h1>
        <p>Choose a student or guest account to submit facility concerns and keep track of each report's progress.</p>
        <div class="cf-hero-points" style="grid-template-columns: 1fr; border: 0; padding: 18px 0 0">
            <div class="cf-hero-point"><span>01</span><span>Describe the facility issue.</span></div>
            <div class="cf-hero-point"><span>02</span><span>Follow each report as it is reviewed.</span></div>
        </div>
    </section>
    <section class="cf-auth-card">
        <p class="cf-eyebrow">Get started</p>
        <h2>Create your account</h2>
        <p>Student and guest accounts can submit and track reports.</p>

        @if($errors->any())
            <div class="cf-form-errors" role="alert" style="margin-top: 15px"><ul style="margin: 0; padding-left: 17px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" class="cf-auth-form">
            @csrf
            <div class="cf-field">
                <label for="name" class="cf-label">Full name</label>
                <input class="cf-control" id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="120" autocomplete="name" autofocus placeholder="Your full name">
                @error('name')<p class="cf-help">{{ $message }}</p>@enderror
            </div>
            <div class="cf-field">
                <label for="email" class="cf-label">Email address</label>
                <input class="cf-control" id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@university.edu">
                @error('email')<p class="cf-help">{{ $message }}</p>@enderror
            </div>
            <div class="cf-field">
                <label for="role" class="cf-label">Account type</label>
                <select class="cf-control" id="role" name="role" required>
                    <option value="student" @selected(old('role', 'student') === 'student')>Student</option>
                    <option value="guest" @selected(old('role') === 'guest')>Guest</option>
                </select>
                @error('role')<p class="cf-help">{{ $message }}</p>@enderror
            </div>
            <div class="cf-form-grid">
                <div class="cf-field">
                    <label for="password" class="cf-label">Password</label>
                    <input class="cf-control" id="password" name="password" type="password" required minlength="8" autocomplete="new-password" placeholder="At least 8 characters">
                    @error('password')<p class="cf-help">{{ $message }}</p>@enderror
                </div>
                <div class="cf-field">
                    <label for="password_confirmation" class="cf-label">Confirm password</label>
                    <input class="cf-control" id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" placeholder="Re-enter password">
                </div>
            </div>
            <p class="cf-help">Faculty and staff accounts are provisioned by the university because they can review reports.</p>
            <button class="cf-button cf-button-primary" type="submit">Create account</button>
        </form>
        <p class="cf-auth-switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
    </section>
</main>
@endsection
