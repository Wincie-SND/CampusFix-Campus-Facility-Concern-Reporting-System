@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
<main class="mx-auto grid max-w-6xl gap-10 px-5 py-10 sm:px-8 sm:py-14 lg:grid-cols-[.9fr_1.1fr] lg:items-center">
    <section class="hidden rounded-3xl bg-campus-ink p-10 text-white shadow-soft lg:block">
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-white/10 text-campus-gold">
            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 20V8.5L12 4l7 4.5V20M9 20v-6h6v6M9 9h.01M15 9h.01" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <p class="mt-10 text-xs font-bold uppercase tracking-[.2em] text-blue-200">CampusFix workspace</p>
        <h1 class="mt-3 text-3xl font-extrabold leading-tight">Your campus reports, all in one place.</h1>
        <p class="mt-4 text-sm leading-7 text-blue-100/75">Sign in to follow the concerns you have submitted or review reports as an authorized administrator.</p>
        <div class="mt-10 flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[.05] p-4 text-sm text-blue-100/80">
            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-emerald-300/10 text-emerald-300">✓</span>
            Reports stay connected to your account for easy follow-up.
        </div>
    </section>
    <section class="mx-auto w-full max-w-lg rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-9">
        <p class="text-xs font-extrabold uppercase tracking-[.2em] text-campus-blue">Welcome back</p>
        <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-campus-ink">Sign in to CampusFix</h2>
        <p class="mt-2 text-sm text-slate-500">Use the account you registered with.</p>

        @if($errors->any())
            <div class="mt-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700" role="alert">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.store') }}" method="POST" class="mt-7 space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="you@university.edu">
                @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="Enter your password">
                @error('password')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-500"><input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-campus-blue focus:ring-campus-blue"> Keep me signed in</label>
            <button class="w-full rounded-xl bg-campus-blue px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-800">Sign in</button>
        </form>
        <p class="mt-6 text-center text-sm text-slate-500">New to CampusFix? <a href="{{ route('register') }}" class="font-bold text-campus-blue hover:underline">Create a student account</a></p>
    </section>
</main>
@endsection
