@extends('layouts.app')

@section('title', 'Create a student account')

@section('content')
<main class="mx-auto grid max-w-6xl gap-10 px-5 py-10 sm:px-8 sm:py-14 lg:grid-cols-[.9fr_1.1fr] lg:items-center">
    <section class="hidden rounded-3xl bg-campus-ink p-10 text-white shadow-soft lg:block">
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-white/10 text-campus-gold">
            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 3 4.5 7v5.5c0 4.1 3.1 7.5 7.5 8.5 4.4-1 7.5-4.4 7.5-8.5V7L12 3Z"/><path d="m9 12 2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <p class="mt-10 text-xs font-bold uppercase tracking-[.2em] text-blue-200">Make a difference</p>
        <h1 class="mt-3 text-3xl font-extrabold leading-tight">A small report can improve a shared space.</h1>
        <p class="mt-4 text-sm leading-7 text-blue-100/75">Create your student account to submit facility concerns and keep track of each report's progress.</p>
        <div class="mt-10 grid grid-cols-2 gap-3">
            <div class="rounded-2xl border border-white/10 bg-white/[.05] p-4"><p class="text-xs font-bold text-campus-gold">01</p><p class="mt-2 text-sm font-semibold">Describe the issue</p></div>
            <div class="rounded-2xl border border-white/10 bg-white/[.05] p-4"><p class="text-xs font-bold text-campus-gold">02</p><p class="mt-2 text-sm font-semibold">Follow its status</p></div>
        </div>
    </section>
    <section class="mx-auto w-full max-w-lg rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-9">
        <p class="text-xs font-extrabold uppercase tracking-[.2em] text-campus-blue">Get started</p>
        <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-campus-ink">Create your student account</h2>
        <p class="mt-2 text-sm text-slate-500">A few details are all you need to report a concern.</p>

        @if($errors->any())
            <div class="mt-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700" role="alert"><ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" class="mt-7 space-y-4">
            @csrf
            <div>
                <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Full name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" autofocus class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="Your full name">
                @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="you@university.edu">
                @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="At least 8 characters">
                    @error('password')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-slate-700">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="Re-enter password">
                </div>
            </div>
            <p class="text-xs leading-5 text-slate-400">Your account is for submitting and tracking your own facility reports.</p>
            <button class="mt-2 w-full rounded-xl bg-campus-blue px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-800">Create account</button>
        </form>
        <p class="mt-6 text-center text-sm text-slate-500">Already have an account? <a href="{{ route('login') }}" class="font-bold text-campus-blue hover:underline">Sign in</a></p>
    </section>
</main>
@endsection
