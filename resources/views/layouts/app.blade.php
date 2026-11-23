<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CampusFix') · CampusFix</title>
    <link rel="stylesheet" href="{{ asset('css/campusfix.css') }}">
    <style>
        :root { color-scheme: light; }
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        input:focus, select:focus, textarea:focus { outline: 2px solid transparent; outline-offset: 2px; }
    </style>
    @stack('head')
</head>
<body class="min-h-screen bg-campus-pale text-slate-800 antialiased">
    <header class="border-b border-slate-200/80 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="CampusFix home">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-campus-ink text-white shadow-sm">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path d="M4 20V8.5L12 4l8 4.5V20M8 20v-6h8v6M9 9h.01M15 9h.01" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span>
                    <span class="block text-lg font-extrabold tracking-tight text-campus-ink">CampusFix</span>
                    <span class="-mt-0.5 block text-[10px] font-semibold uppercase tracking-[.18em] text-slate-400">Campus care, connected</span>
                </span>
            </a>

            <nav class="flex items-center gap-2 sm:gap-3" aria-label="Main navigation">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.concerns.index') }}" class="hidden rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 sm:inline-flex">Admin workspace</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="hidden rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 sm:inline-flex">My reports</a>
                        <a href="{{ route('concerns.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-campus-blue px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 sm:px-4">
                            <span class="text-lg leading-none">+</span><span class="hidden sm:inline">New report</span><span class="sm:hidden">Report</span>
                        </a>
                    @endif
                    <div class="hidden h-8 w-px bg-slate-200 sm:block"></div>
                    <div class="hidden text-right sm:block">
                        <span class="block max-w-36 truncate text-sm font-semibold text-campus-ink">{{ auth()->user()->name }}</span>
                        <span class="block text-[11px] font-medium capitalize text-slate-400">{{ auth()->user()->role }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-500 transition hover:bg-slate-100 hover:text-campus-ink">Sign out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Sign in</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-campus-ink px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">Create account</a>
                @endauth
            </nav>
        </div>
    </header>

    @if(session('success'))
        <div class="mx-auto mt-5 max-w-7xl px-5 sm:px-8" role="status">
            <div class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <span class="mt-0.5 font-bold">✓</span><p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @yield('content')

    <footer class="mt-16 border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-5 py-6 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <span>CampusFix · A clearer way to care for campus spaces.</span>
            <span>Facility concerns are reviewed by authorized university administrators.</span>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
