@extends('layouts.app')

@section('title', 'Report a concern')

@section('content')
<main>
    <a href="{{ route('dashboard') }}" class="cf-back-link"><span aria-hidden="true">←</span> Back to overview</a>
    <header class="cf-page-heading">
        <div>
            <p class="cf-eyebrow">Student workspace</p>
            <h1 class="cf-page-title">Report a concern</h1>
            <p class="cf-page-subtitle">Something on campus needs attention? Tell us about it below.</p>
        </div>
        <span class="cf-heading-note">Fields marked <span class="cf-required">*</span> are required</span>
    </header>

    <div class="cf-form-layout">
        <section class="cf-panel cf-form-panel">
            <div class="cf-form-heading">
                <p class="cf-eyebrow">New facility concern</p>
                <h2 class="cf-form-title">Concern details</h2>
                <p class="cf-form-intro">A clear title and location help campus staff respond faster.</p>
            </div>

            @if($errors->any())
                <div class="cf-form-errors" role="alert"><strong>Please review these fields:</strong><ul style="margin: 5px 0 0; padding-left: 17px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('concerns.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="cf-form-grid">
                    <div class="cf-field cf-field-full">
                        <label for="title" class="cf-label">Concern title <span class="cf-required">*</span></label>
                        <input class="cf-control" id="title" name="title" type="text" maxlength="120" value="{{ old('title') }}" required placeholder="e.g. Broken chair in Room 301">
                        @error('title')<p class="cf-help">{{ $message }}</p>@enderror
                    </div>
                    <div class="cf-field">
                        <label for="category" class="cf-label">Facility category <span class="cf-required">*</span></label>
                        <select class="cf-control" id="category" name="category" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)<option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>@endforeach
                        </select>
                        @error('category')<p class="cf-help">{{ $message }}</p>@enderror
                    </div>
                    <div class="cf-field">
                        <label for="building" class="cf-label">Building <span class="cf-required">*</span></label>
                        <input class="cf-control" id="building" name="building" list="campus-buildings" type="text" maxlength="120" value="{{ old('building') }}" required placeholder="Select or enter a building">
                        <datalist id="campus-buildings"><option value="Main Building"><option value="Science Building"><option value="Library"><option value="Engineering Building"><option value="Student Center"></datalist>
                        @error('building')<p class="cf-help">{{ $message }}</p>@enderror
                    </div>
                    <div class="cf-field cf-field-full">
                        <label for="location" class="cf-label">Specific location <span class="cf-required">*</span></label>
                        <input class="cf-control" id="location" name="location" type="text" maxlength="255" value="{{ old('location') }}" required placeholder="Floor, room number, or nearby landmark">
                        <p class="cf-help">For example: 3rd floor, Room 301, near the west stairwell.</p>
                        @error('location')<p class="cf-help">{{ $message }}</p>@enderror
                    </div>
                    <div class="cf-field cf-field-full">
                        <label for="description" class="cf-label">Description <span class="cf-required">*</span></label>
                        <textarea class="cf-control" id="description" name="description" rows="5" minlength="15" maxlength="5000" required placeholder="Describe what happened and what needs attention.">{{ old('description') }}</textarea>
                        <p class="cf-help">At least 15 characters. Add useful details so the team can understand the concern.</p>
                        @error('description')<p class="cf-help">{{ $message }}</p>@enderror
                    </div>
                    <div class="cf-field cf-field-full">
                        <label for="photo" class="cf-label">Photo <span style="font-weight: 500; color: #99a5a1">(optional)</span></label>
                        <input class="cf-control" id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp">
                        <p class="cf-help">JPG, PNG, or WebP · up to 4 MB</p>
                        @error('photo')<p class="cf-help">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="cf-form-actions">
                    <a href="{{ route('dashboard') }}" class="cf-button cf-button-outline">Cancel</a>
                    <button class="cf-button cf-button-primary" type="submit">Submit report <span aria-hidden="true">→</span></button>
                </div>
            </form>
        </section>

        <aside class="cf-aside-stack">
            <section class="cf-advice-card">
                <h2 class="cf-advice-title">A helpful report goes a long way.</h2>
                <ol class="cf-advice-list">
                    <li class="cf-advice-item"><span class="cf-advice-number">01</span><span><strong>Be specific</strong><br>Describe what is broken or not working.</span></li>
                    <li class="cf-advice-item"><span class="cf-advice-number">02</span><span><strong>Add a clear location</strong><br>Include the building, floor, and room.</span></li>
                    <li class="cf-advice-item"><span class="cf-advice-number">03</span><span><strong>Show the concern</strong><br>A photo helps when it adds context.</span></li>
                </ol>
            </section>
            <section class="cf-advice-card cf-advice-card-white">
                <h2 class="cf-advice-title">What happens next?</h2>
                <ol class="cf-steps"><li>Your report is saved as Pending.</li><li>Campus staff review the concern.</li><li>Check My reports for status changes.</li></ol>
                <p class="cf-help" style="margin-top: 12px">You can view your report after submitting.</p>
            </section>
        </aside>
    </div>
</main>
@endsection
