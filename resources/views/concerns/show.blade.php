@extends('layouts.app')

@section('title', $concern->reference_code)

@section('content')
<main>
    <a href="{{ auth()->user()->canReviewConcerns() ? route('admin.concerns.index') : route('dashboard') }}" class="cf-back-link"><span aria-hidden="true">←</span> {{ auth()->user()->canReviewConcerns() ? 'Back to all reports' : 'Back to my reports' }}</a>
    <header class="cf-page-heading">
        <div>
            <p class="cf-eyebrow">Facility report</p>
            <h1 class="cf-page-title">{{ $concern->title ?: $concern->category }}</h1>
            <p class="cf-page-subtitle">{{ $concern->reference_code }} · Submitted {{ $concern->created_at->format('M j, Y · g:i A') }}</p>
        </div>
        @include('partials.status-badge', ['concern' => $concern])
    </header>

    <div class="cf-show-grid">
        <section class="cf-panel cf-show-panel">
            @if(auth()->user()->canReviewConcerns())
                <div class="cf-detail-section">
                    <p class="cf-detail-label">Submitted by</p>
                    <p class="cf-detail-value">{{ $concern->user->name }} <span class="cf-queue-meta">· {{ $concern->user->email }}</span></p>
                </div>
            @endif
            <div class="cf-show-top" style="margin-top: 13px">
                <div><p class="cf-eyebrow">{{ $concern->category }}</p><p class="cf-detail-value">{{ $concern->building ?: 'Campus' }} · {{ $concern->location }}</p></div>
            </div>
            <h2 class="cf-detail-label" style="margin-top: 16px">Description</h2>
            <p class="cf-show-copy">{{ $concern->description }}</p>

            @if($concern->photo_path)
                <div class="cf-detail-section" style="margin-top: 17px">
                    <p class="cf-detail-label">Attached photo</p>
                    <a href="{{ route('concerns.photo', $concern) }}" target="_blank" rel="noopener" class="cf-photo-link">
                        <img src="{{ route('concerns.photo', $concern) }}" alt="Photo attached to {{ $concern->reference_code }}">
                    </a>
                </div>
            @endif

            <div class="cf-detail-section" style="margin-top: 17px">
                <p class="cf-detail-label">Status progress</p>
                @php
                    $steps = ['pending' => 'Submitted', 'in_progress' => 'In progress', 'resolved' => 'Resolved'];
                    $activeStep = array_search($concern->status, array_keys($steps), true);
                @endphp
                <div class="cf-progress">
                    @foreach($steps as $key => $label)
                        @php $stepIndex = array_search($key, array_keys($steps), true); $isReached = $activeStep !== false && $stepIndex <= $activeStep; @endphp
                        <div @class(['cf-progress-step', 'is-reached' => $isReached])><span></span><small>{{ $label }}</small></div>
                    @endforeach
                </div>
            </div>

            @if($concern->admin_note)
                <div class="cf-detail-section" style="margin-top: 18px">
                    <p class="cf-detail-label">Reviewer update</p>
                    <p class="cf-show-copy">{{ $concern->admin_note }}</p>
                    @if($concern->reviewer)<p class="cf-help">Updated by {{ $concern->reviewer->name }} · {{ $concern->updated_at->format('M j, Y') }}</p>@endif
                </div>
            @endif
        </section>

        <aside class="cf-panel cf-show-side">
            @if(auth()->user()->canReviewConcerns())
                <p class="cf-eyebrow">Reviewer tools</p>
                <h2 class="cf-section-title" style="margin-top: 6px">Update status</h2>
                <p class="cf-section-copy">Keep the reporter informed with a clear status and optional note.</p>
                @if($errors->any())<div class="cf-form-errors" style="margin-top: 10px">{{ $errors->first() }}</div>@endif
                <form action="{{ route('admin.concerns.update', $concern) }}" method="POST" class="cf-detail-form">
                    @csrf
                    @method('PATCH')
                    <label class="cf-label" for="status">Status</label>
                    <select class="cf-control" id="status" name="status" required>
                        @foreach($statuses as $key => $label)<option value="{{ $key }}" @selected(old('status', $concern->status) === $key)>{{ $label }}</option>@endforeach
                    </select>
                    <label class="cf-label" for="admin_note">Update note <span style="font-weight: 500; color: #99a5a1">(optional)</span></label>
                    <textarea class="cf-control" id="admin_note" name="admin_note" rows="5" maxlength="2000" placeholder="Share a brief update with the reporter">{{ old('admin_note', $concern->admin_note) }}</textarea>
                    <button class="cf-button cf-button-primary" type="submit">Save changes</button>
                </form>
            @else
                <p class="cf-eyebrow">Report details</p>
                <dl class="cf-detail-list">
                    <div><dt class="cf-detail-label">Category</dt><dd class="cf-detail-value">{{ $concern->category }}</dd></div>
                    <div><dt class="cf-detail-label">Building</dt><dd class="cf-detail-value">{{ $concern->building ?: 'Campus' }}</dd></div>
                    <div><dt class="cf-detail-label">Specific location</dt><dd class="cf-detail-value">{{ $concern->location }}</dd></div>
                    <div><dt class="cf-detail-label">Reference</dt><dd class="cf-detail-value cf-detail-ref">{{ $concern->reference_code }}</dd></div>
                </dl>
                <p class="cf-help" style="margin-top: 15px">Return here any time to check the latest report status.</p>
            @endif
        </aside>
    </div>
</main>
@endsection
