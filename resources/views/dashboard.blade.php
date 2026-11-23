@extends('layouts.app')

@section('title', 'My reports')

@section('content')
<main class="mx-auto max-w-7xl px-5 py-8 sm:px-8 sm:py-10">
    <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-xs font-extrabold uppercase tracking-[.2em] text-campus-blue">Student workspace</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-campus-ink">Good to see you, {{ Str::before(auth()->user()->name, ' ') }}.</h1>
            <p class="mt-2 text-sm text-slate-500">Follow your submitted concerns and check the latest updates.</p>
        </div>
        <a href="{{ route('concerns.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-campus-blue px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-800"><span class="text-xl leading-none">+</span> Submit a concern</a>
    </section>

    <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Report totals">
        @foreach ([['All reports', $counts['total'], 'bg-blue-50 text-campus-blue', '▤'], ['Pending', $counts['pending'], 'bg-amber-50 text-amber-700', '◷'], ['In progress', $counts['in_progress'], 'bg-indigo-50 text-indigo-700', '↗'], ['Resolved', $counts['resolved'], 'bg-emerald-50 text-emerald-700', '✓']] as [$label, $value, $tone, $icon])
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">{{ $label }}</span><span class="grid h-9 w-9 place-items-center rounded-xl {{ $tone }}">{{ $icon }}</span></div>
                <p class="mt-4 text-3xl font-extrabold tracking-tight text-campus-ink">{{ $value }}</p>
            </div>
        @endforeach
    </section>

    <section class="mt-9 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div><h2 class="text-lg font-extrabold text-campus-ink">Your recent reports</h2><p class="mt-1 text-sm text-slate-500">Open a report to view its details and administrator notes.</p></div>
            @if($concerns->isNotEmpty())<span class="text-xs font-semibold text-slate-400">Showing {{ $concerns->count() }} latest</span>@endif
        </div>

        @if($concerns->isEmpty())
            <div class="px-6 py-16 text-center">
                <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-blue-50 text-2xl text-campus-blue">＋</span>
                <h3 class="mt-4 font-bold text-campus-ink">No concerns submitted yet</h3>
                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">When you spot a facility problem, tell us what happened and where it is on campus.</p>
                <a href="{{ route('concerns.create') }}" class="mt-5 inline-flex rounded-lg bg-campus-blue px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-800">Create your first report</a>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($concerns as $concern)
                    <a href="{{ route('concerns.show', $concern) }}" class="group flex flex-col gap-4 px-5 py-5 transition hover:bg-slate-50 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="flex min-w-0 items-start gap-4">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-slate-50 text-slate-500">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M5 6.5A1.5 1.5 0 0 1 6.5 5h11A1.5 1.5 0 0 1 19 6.5v11a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 5 17.5v-11Z"/><path d="M8 9h8M8 12h8M8 15h5" stroke-linecap="round"/></svg>
                            </span>
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2"><span class="text-sm font-extrabold text-campus-ink">{{ $concern->reference_code }}</span><span class="text-slate-300">·</span><span class="text-sm font-semibold text-slate-600">{{ $concern->category }}</span></div>
                                <p class="mt-1 truncate text-sm text-slate-500">{{ $concern->location }}</p>
                                <p class="mt-1 text-xs text-slate-400">Submitted {{ $concern->created_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-5 sm:justify-end"><span>@include('partials.status-badge', ['concern' => $concern])</span><span class="text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-campus-blue" aria-hidden="true">→</span></div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <div class="mt-6 flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50/70 px-4 py-3 text-xs leading-5 text-blue-900/75">
        <span class="font-bold text-campus-blue">i</span>
        <p>CampusFix is for facility concern reporting. It does not include GPS tracking, repair scheduling, or real-time notifications.</p>
    </div>
</main>
@endsection
