@extends('layouts.app')

@section('title', 'Administrator workspace')

@section('content')
<main class="mx-auto max-w-7xl px-5 py-8 sm:px-8 sm:py-10">
    <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-xs font-extrabold uppercase tracking-[.2em] text-campus-blue">Administrator workspace</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-campus-ink">Facility concern queue</h1>
            <p class="mt-2 text-sm text-slate-500">Search submitted reports, review the details, and keep statuses current.</p>
        </div>
        <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-xs font-semibold text-blue-900/75">CampusFix · Authorized administrator</div>
    </section>

    <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Concern queue totals">
        @foreach ([['All reports', $counts['total'], 'bg-blue-50 text-campus-blue', '▤'], ['Pending review', $counts['pending'], 'bg-amber-50 text-amber-700', '◷'], ['In progress', $counts['in_progress'], 'bg-indigo-50 text-indigo-700', '↗'], ['Resolved', $counts['resolved'], 'bg-emerald-50 text-emerald-700', '✓']] as [$label, $value, $tone, $icon])
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">{{ $label }}</span><span class="grid h-9 w-9 place-items-center rounded-xl {{ $tone }}">{{ $icon }}</span></div><p class="mt-4 text-3xl font-extrabold tracking-tight text-campus-ink">{{ $value }}</p></div>
        @endforeach
    </section>

    <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between"><div><h2 class="text-lg font-extrabold text-campus-ink">Submitted reports</h2><p class="mt-1 text-sm text-slate-500">Search by reference, student, category, location, or description.</p></div><p class="text-xs font-semibold text-slate-400">{{ $concerns->total() }} total</p></div>
            <form action="{{ route('admin.concerns.index') }}" method="GET" class="mt-5 grid gap-3 sm:grid-cols-[1fr_190px_auto]">
                <label class="sr-only" for="q">Search reports</label>
                <input id="q" name="q" type="search" value="{{ $search }}" placeholder="Search reports…" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm focus:border-campus-blue focus:ring-4 focus:ring-blue-100">
                <label class="sr-only" for="status">Filter by status</label>
                <select id="status" name="status" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-campus-blue focus:ring-4 focus:ring-blue-100">
                    <option value="">All statuses</option>
                    @foreach($statuses as $key => $label)<option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>@endforeach
                </select>
                <div class="flex gap-2"><button class="flex-1 rounded-xl bg-campus-blue px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-800 sm:flex-none">Search</button><a href="{{ route('admin.concerns.index') }}" class="rounded-xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-500 transition hover:bg-slate-50">Clear</a></div>
            </form>
        </div>

        @if($concerns->isEmpty())
            <div class="px-6 py-14 text-center"><span class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-slate-50 text-xl text-slate-400">⌕</span><h3 class="mt-4 font-bold text-campus-ink">No reports match this search</h3><p class="mt-1 text-sm text-slate-500">Try another term or clear the filters.</p></div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px] text-left">
                    <thead class="bg-slate-50 text-[11px] font-extrabold uppercase tracking-wider text-slate-400"><tr><th class="px-6 py-3">Report</th><th class="px-6 py-3">Student</th><th class="px-6 py-3">Location</th><th class="px-6 py-3">Submitted</th><th class="px-6 py-3">Status</th><th class="px-6 py-3"><span class="sr-only">Open report</span></th></tr></thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($concerns as $concern)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4"><a href="{{ route('concerns.show', $concern) }}" class="font-extrabold text-campus-blue hover:underline">{{ $concern->reference_code }}</a><p class="mt-1 text-xs text-slate-500">{{ $concern->category }}</p></td>
                                <td class="px-6 py-4"><p class="text-sm font-semibold text-campus-ink">{{ $concern->user->name }}</p><p class="mt-0.5 text-xs text-slate-400">{{ $concern->user->email }}</p></td>
                                <td class="max-w-56 truncate px-6 py-4 text-sm text-slate-600" title="{{ $concern->location }}">{{ $concern->location }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $concern->created_at->format('M j, Y') }}</td>
                                <td class="px-6 py-4">@include('partials.status-badge', ['concern' => $concern])</td>
                                <td class="px-6 py-4 text-right"><a href="{{ route('concerns.show', $concern) }}" class="rounded-lg px-3 py-2 text-sm font-bold text-campus-blue hover:bg-blue-50">Review <span aria-hidden="true">→</span></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($concerns->hasPages())<div class="border-t border-slate-100 px-5 py-4 sm:px-6">{{ $concerns->links() }}</div>@endif
        @endif
    </section>
</main>
@endsection
