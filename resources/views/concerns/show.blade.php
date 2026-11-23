@extends('layouts.app')

@section('title', $concern->reference_code)

@section('content')
<main class="mx-auto max-w-6xl px-5 py-8 sm:px-8 sm:py-10">
    <a href="{{ auth()->user()->isAdmin() ? route('admin.concerns.index') : route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-campus-blue"><span aria-hidden="true">←</span> {{ auth()->user()->isAdmin() ? 'Back to admin workspace' : 'Back to my reports' }}</a>
    <div class="mt-5 grid gap-6 lg:grid-cols-[1fr_340px] lg:items-start">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-white px-5 py-6 sm:px-7">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[.18em] text-campus-blue">Facility report</p>
                        <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-campus-ink">{{ $concern->category }}</h1>
                        <p class="mt-2 text-sm text-slate-500">{{ $concern->location }}</p>
                    </div>
                    @include('partials.status-badge', ['concern' => $concern])
                </div>
                <div class="mt-5 flex flex-wrap gap-x-5 gap-y-2 border-t border-slate-100 pt-4 text-xs text-slate-400">
                    <span>Reference <strong class="font-extrabold text-campus-ink">{{ $concern->reference_code }}</strong></span>
                    <span>Submitted {{ $concern->created_at->format('M j, Y · g:i A') }}</span>
                </div>
            </div>
            <div class="px-5 py-6 sm:px-7">
                @if(auth()->user()->isAdmin())
                    <div class="mb-6 rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Submitted by</p>
                        <p class="mt-1 text-sm font-bold text-campus-ink">{{ $concern->user->name }}</p>
                        <p class="text-sm text-slate-500">{{ $concern->user->email }}</p>
                    </div>
                @endif
                <h2 class="text-sm font-extrabold text-campus-ink">Concern description</h2>
                <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-600">{{ $concern->description }}</p>

                @if($concern->photo_path)
                    <div class="mt-7">
                        <h2 class="text-sm font-extrabold text-campus-ink">Attached photo</h2>
                        <a href="{{ route('concerns.photo', $concern) }}" target="_blank" rel="noopener" class="mt-3 inline-block overflow-hidden rounded-xl border border-slate-200">
                            <img src="{{ route('concerns.photo', $concern) }}" alt="Photo attached to {{ $concern->reference_code }}" class="max-h-[420px] max-w-full object-contain">
                        </a>
                    </div>
                @endif

                <div class="mt-8 border-t border-slate-100 pt-6">
                    <h2 class="text-sm font-extrabold text-campus-ink">Status progress</h2>
                    @php
                        $steps = ['pending' => 'Submitted', 'in_progress' => 'In Progress', 'resolved' => 'Resolved'];
                        $activeStep = array_search($concern->status, array_keys($steps), true);
                    @endphp
                    <div class="mt-5 grid grid-cols-3 gap-2">
                        @foreach($steps as $key => $label)
                            @php $stepIndex = array_search($key, array_keys($steps), true); $isReached = $activeStep !== false && $stepIndex <= $activeStep; @endphp
                            <div>
                                <div class="h-1.5 rounded-full {{ $isReached ? 'bg-campus-blue' : 'bg-slate-100' }}"></div>
                                <p class="mt-2 text-xs font-bold {{ $isReached ? 'text-campus-ink' : 'text-slate-400' }}">{{ $label }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($concern->admin_note)
                    <div class="mt-7 rounded-xl border border-blue-100 bg-blue-50/70 p-4">
                        <p class="text-xs font-extrabold uppercase tracking-wider text-campus-blue">Administrator update</p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $concern->admin_note }}</p>
                        @if($concern->reviewer)<p class="mt-3 text-xs text-slate-400">Updated by {{ $concern->reviewer->name }}@if($concern->updated_at) · {{ $concern->updated_at->format('M j, Y') }}@endif</p>@endif
                    </div>
                @endif
            </div>
        </section>

        @if(auth()->user()->isAdmin())
            <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <p class="text-xs font-extrabold uppercase tracking-[.18em] text-campus-blue">Administrator action</p>
                <h2 class="mt-2 text-lg font-extrabold text-campus-ink">Update report status</h2>
                <p class="mt-1 text-sm leading-6 text-slate-500">Keep the student informed with a clear status and optional note.</p>
                @if($errors->any())<div class="mt-4 rounded-lg bg-rose-50 px-3 py-2 text-xs text-rose-700">{{ $errors->first() }}</div>@endif
                <form action="{{ route('admin.concerns.update', $concern) }}" method="POST" class="mt-5 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="status" class="mb-1.5 block text-sm font-bold text-slate-700">Status</label>
                        <select id="status" name="status" required class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-3 text-sm focus:border-campus-blue focus:ring-4 focus:ring-blue-100">
                            @foreach($statuses as $key => $label)<option value="{{ $key }}" @selected(old('status', $concern->status) === $key)>{{ $label }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label for="admin_note" class="mb-1.5 block text-sm font-bold text-slate-700">Update note <span class="font-normal text-slate-400">(optional)</span></label>
                        <textarea id="admin_note" name="admin_note" rows="5" maxlength="2000" class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-3 text-sm leading-6 focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="Share a brief update with the student">{{ old('admin_note', $concern->admin_note) }}</textarea>
                    </div>
                    <button class="w-full rounded-xl bg-campus-blue px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-800">Save update</button>
                </form>
                <div class="mt-5 border-t border-slate-100 pt-4 text-xs leading-5 text-slate-400">Status changes are visible to the student on this report page.</div>
            </aside>
        @else
            <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <p class="text-xs font-extrabold uppercase tracking-[.18em] text-campus-blue">Report details</p>
                <dl class="mt-4 space-y-4">
                    <div><dt class="text-xs font-semibold text-slate-400">Category</dt><dd class="mt-1 text-sm font-bold text-campus-ink">{{ $concern->category }}</dd></div>
                    <div><dt class="text-xs font-semibold text-slate-400">Campus location</dt><dd class="mt-1 text-sm font-bold text-campus-ink">{{ $concern->location }}</dd></div>
                    <div><dt class="text-xs font-semibold text-slate-400">Reference</dt><dd class="mt-1 font-mono text-sm font-bold text-campus-ink">{{ $concern->reference_code }}</dd></div>
                </dl>
                <div class="mt-5 rounded-xl bg-slate-50 p-4 text-xs leading-5 text-slate-500">You can return to this page at any time to check the latest status update.</div>
            </aside>
        @endif
    </div>
</main>
@endsection
