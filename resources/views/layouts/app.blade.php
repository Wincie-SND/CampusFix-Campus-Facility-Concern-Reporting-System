<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CampusFix') · CampusFix</title>
    <link rel="stylesheet" href="{{ asset('css/campusfix.css') }}">
    <link rel="stylesheet" href="{{ asset('css/campusfix-ui.css') }}">
    <style>
        :root { color-scheme: light; }
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
    </style>
    @stack('head')
</head>
<body class="min-h-screen antialiased">
    @auth
        <div class="cf-app-shell">
            <aside class="cf-sidebar">
                <a href="{{ route('home') }}" class="cf-brand" aria-label="CampusFix home">
                    <span class="cf-brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 20V8.5L12 4l8.5 4.5V20M7.5 20v-6h9v6M8 9.5h.01M16 9.5h.01" /></svg>
                    </span>
                    <span><span class="cf-brand-name">CampusFix</span><span class="cf-brand-tagline">Campus care, connected</span></span>
                </a>

                <div class="cf-sidebar-body">
                    @if(auth()->user()->canSubmitConcerns())
                        <section class="cf-nav-section">
                            <p class="cf-nav-label">Reporting workspace</p>
                            <nav class="cf-nav" aria-label="Reporting navigation">
                                <a href="{{ route('dashboard') }}" @class(['cf-nav-link', 'is-active' => request()->routeIs('dashboard')]) @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/></svg>
                                    Overview
                                </a>
                                <a href="{{ route('concerns.create') }}" @class(['cf-nav-link', 'is-active' => request()->routeIs('concerns.create')]) @if(request()->routeIs('concerns.create')) aria-current="page" @endif>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                                    Report a concern
                                </a>
                                <a href="{{ route('dashboard') }}#my-reports" class="cf-nav-link">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4.5h7l4 4V20H7a2 2 0 0 1-2-2V6.5a2 2 0 0 1 2-2Z"/><path d="M14 5v4h4M8.5 13h7M8.5 16h5"/></svg>
                                    My reports
                                </a>
                            </nav>
                        </section>
                    @endif

                    @if(auth()->user()->canReviewConcerns())
                        <section class="cf-nav-section">
                            <p class="cf-nav-label">Review workspace</p>
                            <nav class="cf-nav" aria-label="Review navigation">
                                <a href="{{ route('admin.concerns.index') }}" @class(['cf-nav-link', 'is-active' => request()->routeIs('admin.concerns.*')]) @if(request()->routeIs('admin.concerns.*')) aria-current="page" @endif>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M5 5h14v14H5zM8 9h8M8 12h8M8 15h5"/></svg>
                                    All reports
                                </a>
                            </nav>
                        </section>
                    @endif
                </div>

                <div class="cf-sidebar-spacer"></div>
                <div class="cf-sidebar-tip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3.8a6.2 6.2 0 0 0-3.8 11.1c.7.5 1.2 1.2 1.3 2h5c.1-.8.6-1.5 1.3-2A6.2 6.2 0 0 0 12 3.8Z"/><path d="M9.8 20h4.4M10 17h4M12 1.8v1.5"/></svg>
                    <strong>Small reports. Meaningful change.</strong>
                    <p>Help keep shared campus spaces safe and working.</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="cf-sidebar-signout" type="submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10 5H5v14h5M14 8l4 4-4 4M8 12h10"/></svg>
                        Sign out
                    </button>
                </form>
            </aside>

            <div class="cf-main-shell">
                <header class="cf-topbar">
                    <div>
                        <div class="cf-topbar-label">{{ auth()->user()->isStaff() ? 'CampusFix administration' : (auth()->user()->role === 'faculty' ? 'Faculty portal' : 'Student portal') }}</div>
                        <div class="cf-topbar-subtitle">Campus facility concern reporting</div>
                    </div>
                    <div class="cf-topbar-account">
                        <span class="cf-role-pill">{{ auth()->user()->role }}</span>
                        <span class="cf-avatar" aria-hidden="true">{{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="cf-account-copy"><span class="cf-account-name">{{ auth()->user()->name }}</span><span class="cf-account-type">CampusFix account</span></span>
                    </div>
                </header>

                @if(session('success'))
                    <div class="cf-flash" role="status">{{ session('success') }}</div>
                @endif

                <div class="cf-page-wrap">
                    @yield('content')
                </div>
                <footer class="cf-footer">CampusFix · A clearer way to care for campus spaces.</footer>
            </div>
        </div>
    @else
        <header class="cf-public-header">
            <a href="{{ route('home') }}" class="cf-brand" aria-label="CampusFix home">
                <span class="cf-brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 20V8.5L12 4l8.5 4.5V20M7.5 20v-6h9v6M8 9.5h.01M16 9.5h.01" /></svg></span>
                <span><span class="cf-brand-name">CampusFix</span><span class="cf-brand-tagline">Campus care, connected</span></span>
            </a>
            <nav class="cf-public-nav" aria-label="Main navigation">
                <a href="{{ route('login') }}" class="cf-public-link">Sign in</a>
                <a href="{{ route('register') }}" class="cf-public-link cf-public-link-primary">Create account</a>
            </nav>
        </header>
        @if(session('success'))
            <div class="cf-flash" role="status">{{ session('success') }}</div>
        @endif
        @yield('content')
        <footer class="cf-public-footer">CampusFix · A clearer way to care for campus spaces.</footer>
    @endauth
    @stack('scripts')
</body>
</html>
