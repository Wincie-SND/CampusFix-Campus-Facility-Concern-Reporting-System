@extends('layouts.app')

@section('title', 'Report a campus facility concern')

@section('content')
<main>
    <section class="relative overflow-hidden bg-campus-ink">
        <div class="absolute -right-24 -top-32 h-96 w-96 rounded-full border-[44px] border-white/[.04]"></div>
        <div class="absolute -bottom-48 right-[18%] h-96 w-96 rounded-full border-[1px] border-white/[.08]"></div>
        <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-5 py-16 sm:px-8 sm:py-20 lg:grid-cols-[1.05fr_.95fr] lg:gap-20 lg:py-24">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/[.06] px-3 py-1.5 text-xs font-semibold tracking-wide text-blue-100">
                    <span class="h-2 w-2 rounded-full bg-campus-gold"></span>
                    A better campus starts with a report
                </div>
                <h1 class="max-w-2xl text-4xl font-extrabold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Help us keep your campus <span class="text-campus-gold">working well.</span>
                </h1>
                <p class="mt-6 max-w-xl text-base leading-7 text-blue-100/80 sm:text-lg sm:leading-8">
                    Notice a damaged chair, a faulty light, or equipment that needs attention? Send a clear report and follow its progress from review to resolution.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-3 rounded-xl bg-campus-gold px-6 py-3.5 text-sm font-extrabold text-campus-ink shadow-lg shadow-black/10 transition hover:bg-amber-300">
                        Submit a concern <span aria-hidden="true">→</span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">Sign in to track a report</a>
                </div>
                <p class="mt-5 text-xs text-blue-100/55">For students and authorized university administrators</p>
            </div>

            <div class="relative mx-auto w-full max-w-lg">
                <div class="absolute -left-5 -top-5 h-24 w-24 rounded-3xl bg-campus-gold/15"></div>
                <div class="relative rounded-3xl border border-white/15 bg-white p-5 shadow-2xl shadow-black/20 sm:p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[.16em] text-campus-blue">A simple process</p>
                            <h2 class="mt-2 text-xl font-extrabold text-campus-ink">From concern to care</h2>
                        </div>
                        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-blue-50 text-campus-blue">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3.8h7l4 4V20H7a2 2 0 0 1-2-2V5.8a2 2 0 0 1 2-2Z"/><path d="M14 4v4h4M8.5 12h7M8.5 15.5h7" stroke-linecap="round"/></svg>
                        </span>
                    </div>
                    <div class="mt-7 space-y-5">
                        <div class="flex gap-4">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-blue-50 text-sm font-extrabold text-campus-blue">01</span>
                            <div><h3 class="font-bold text-campus-ink">Tell us what needs attention</h3><p class="mt-1 text-sm leading-6 text-slate-500">Choose a category, add the campus location, and describe the issue.</p></div>
                        </div>
                        <div class="ml-4 h-3 border-l border-dashed border-slate-200"></div>
                        <div class="flex gap-4">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-amber-50 text-sm font-extrabold text-amber-700">02</span>
                            <div><h3 class="font-bold text-campus-ink">Administrators review it</h3><p class="mt-1 text-sm leading-6 text-slate-500">Your report enters a shared queue for authorized campus staff.</p></div>
                        </div>
                        <div class="ml-4 h-3 border-l border-dashed border-slate-200"></div>
                        <div class="flex gap-4">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-emerald-50 text-sm font-extrabold text-emerald-700">03</span>
                            <div><h3 class="font-bold text-campus-ink">Follow the status</h3><p class="mt-1 text-sm leading-6 text-slate-500">Check your report for its latest status and administrator notes.</p></div>
                        </div>
                    </div>
                    <div class="mt-7 rounded-2xl bg-campus-pale px-4 py-3 text-xs leading-5 text-slate-500"><span class="font-bold text-campus-ink">CampusFix keeps it focused:</span> facility reports, records, and status tracking in one place.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-14 sm:px-8 sm:py-16">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div><p class="text-xs font-extrabold uppercase tracking-[.2em] text-campus-blue">What to report</p><h2 class="mt-2 text-2xl font-extrabold tracking-tight text-campus-ink sm:text-3xl">The spaces we share</h2></div>
            <p class="max-w-md text-sm leading-6 text-slate-500">Report damaged or malfunctioning campus facilities and equipment. Add a photo when it helps explain the issue.</p>
        </div>
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([['Furniture', 'Chairs, desks, tables', '🪑'], ['Electrical', 'Outlets and equipment', '⚡'], ['Lighting', 'Lamps and fixtures', '💡'], ['Buildings', 'Doors, walls, structures', '🏫']] as [$title, $detail, $icon])
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-slate-50 text-xl">{{ $icon }}</span>
                    <h3 class="mt-4 font-bold text-campus-ink">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $detail }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-8 rounded-2xl border border-blue-100 bg-blue-50/70 px-5 py-4 text-sm leading-6 text-blue-900/80">
            <span class="font-bold text-campus-ink">Designed for focused reporting.</span> CampusFix does not track your GPS location or dispatch maintenance staff. Please provide a clear campus location in your report.
        </div>
    </section>
</main>
@endsection
