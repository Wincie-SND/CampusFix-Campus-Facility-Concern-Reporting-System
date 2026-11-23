@extends('layouts.app')

@section('title', 'Submit a concern')

@section('content')
<main class="mx-auto max-w-4xl px-5 py-8 sm:px-8 sm:py-10">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-campus-blue"><span aria-hidden="true">←</span> Back to my reports</a>
    <div class="mt-5 grid gap-7 lg:grid-cols-[1fr_280px] lg:items-start">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
            <div class="border-b border-slate-100 pb-5">
                <p class="text-xs font-extrabold uppercase tracking-[.2em] text-campus-blue">New facility concern</p>
                <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-campus-ink">What needs attention?</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">Share enough detail for an administrator to understand and locate the issue.</p>
            </div>

            @if($errors->any())
                <div class="mt-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700" role="alert"><p class="font-bold">Please review the highlighted fields.</p><ul class="mt-2 list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('concerns.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label for="category" class="mb-1.5 block text-sm font-bold text-slate-700">Concern category <span class="text-rose-500">*</span></label>
                    <select id="category" name="category" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-campus-blue focus:ring-4 focus:ring-blue-100">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)<option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>@endforeach
                    </select>
                    @error('category')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="location" class="mb-1.5 block text-sm font-bold text-slate-700">Campus location <span class="text-rose-500">*</span></label>
                    <input id="location" name="location" type="text" value="{{ old('location') }}" required maxlength="255" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="For example: Main Building, 2nd floor, Room 204">
                    <p class="mt-1.5 text-xs text-slate-400">Use a building, floor, room, or other easy-to-find campus landmark.</p>
                    @error('location')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="description" class="mb-1.5 block text-sm font-bold text-slate-700">Describe the concern <span class="text-rose-500">*</span></label>
                    <textarea id="description" name="description" required minlength="15" maxlength="5000" rows="6" class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm leading-6 text-slate-700 focus:border-campus-blue focus:ring-4 focus:ring-blue-100" placeholder="What is damaged or not working? Include any details that might help staff understand the issue.">{{ old('description') }}</textarea>
                    <p class="mt-1.5 text-xs text-slate-400">At least 15 characters, up to 5,000.</p>
                    @error('description')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="photo" class="mb-1.5 block text-sm font-bold text-slate-700">Photo <span class="font-normal text-slate-400">(optional)</span></label>
                    <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-slate-50 file:px-4 file:py-3 file:text-sm file:font-bold file:text-campus-blue hover:file:bg-blue-50">
                    <p class="mt-1.5 text-xs text-slate-400">JPG, PNG, or WebP · up to 4 MB</p>
                    @error('photo')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('dashboard') }}" class="rounded-xl px-5 py-3 text-center text-sm font-bold text-slate-500 transition hover:bg-slate-100">Cancel</a>
                    <button class="rounded-xl bg-campus-blue px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-800">Submit concern</button>
                </div>
            </form>
        </section>

        <aside class="rounded-2xl border border-blue-100 bg-blue-50/70 p-5">
            <p class="text-sm font-extrabold text-campus-ink">A helpful report includes</p>
            <ul class="mt-4 space-y-3 text-sm leading-5 text-slate-600">
                <li class="flex gap-2.5"><span class="font-bold text-emerald-600">✓</span><span>A specific building or campus location</span></li>
                <li class="flex gap-2.5"><span class="font-bold text-emerald-600">✓</span><span>What is broken and what you observed</span></li>
                <li class="flex gap-2.5"><span class="font-bold text-emerald-600">✓</span><span>A photo, if it clarifies the concern</span></li>
            </ul>
            <div class="mt-5 border-t border-blue-100 pt-4 text-xs leading-5 text-slate-500">Your report is saved to your account. You can check its status from your reports page.</div>
        </aside>
    </div>
</main>
@endsection
