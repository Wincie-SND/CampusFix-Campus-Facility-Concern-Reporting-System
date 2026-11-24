@extends('layouts.app')

@section('title', 'Overview')

@section('content')
<main>
    <header class="cf-page-heading">
        <div>
            <p class="cf-eyebrow">Your campus, your voice</p>
            <h1 class="cf-page-title">Let's make campus better.</h1>
            <p class="cf-page-subtitle">Report a facility concern, follow its progress, and make a difference.</p>
        </div>
    </header>

    <section class="cf-hero" aria-labelledby="hero-title">
        <div>
            <p class="cf-hero-label">A safer space starts with you</p>
            <h2 id="hero-title" class="cf-hero-title">Notice something that needs attention?</h2>
            <p class="cf-hero-copy">A clear report helps staff find the issue and keep you informed as it moves forward.</p>
            <a href="{{ route('concerns.create') }}" class="cf-button">
                Report an issue
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
            </a>
        </div>
        <div class="cf-hero-points" aria-label="Reporting tips">
            <div class="cf-hero-point"><span>01</span><span>Describe what is broken or not working.</span></div>
            <div class="cf-hero-point"><span>02</span><span>Add a building and clear location.</span></div>
            <div class="cf-hero-point"><span>03</span><span>Check your reports for status updates.</span></div>
        </div>
    </section>

    <section class="cf-stat-grid" aria-label="Report totals">
        @foreach ([['Total reports', $counts['total'], 'Your reports', '▤'], ['Pending', $counts['pending'], 'Awaiting review', '◷'], ['In progress', $counts['in_progress'], 'Being addressed', '↗'], ['Resolved', $counts['resolved'], 'Closed successfully', '✓']] as [$label, $value, $detail, $icon])
            <article class="cf-stat-card">
                <div class="cf-stat-top"><span>{{ $label }}</span><span class="cf-stat-icon" aria-hidden="true">{{ $icon }}</span></div>
                <div class="cf-stat-value">{{ str_pad((string) $value, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="cf-stat-detail">{{ $detail }}</div>
            </article>
        @endforeach
    </section>

    <section id="my-reports" class="cf-panel cf-recent-panel">
        <div class="cf-section-head">
            <div><h2 class="cf-section-title">My recent reports</h2><p class="cf-section-copy">Follow your submitted concerns and their latest updates.</p></div>
            <a href="{{ route('concerns.create') }}" class="cf-text-link">+ New report</a>
        </div>

        @if($concerns->isEmpty())
            <div class="cf-empty"><strong>No reports yet</strong>When you notice a campus facility issue, submit a report and follow its progress here.</div>
        @else
            <div class="cf-report-table-wrap">
                <table class="cf-report-table">
                    <thead><tr><th>Concern</th><th>Location</th><th>Status</th><th>Submitted</th></tr></thead>
                    <tbody>
                        @foreach($concerns as $concern)
                            <tr>
                                <td><a href="{{ route('concerns.show', $concern) }}"><div class="cf-row-title">{{ $concern->title ?: $concern->category }}</div><div class="cf-row-subtitle">{{ $concern->reference_code }} · {{ Str::limit($concern->description, 70) }}</div></a></td>
                                <td><a href="{{ route('concerns.show', $concern) }}"><div class="cf-row-title">{{ $concern->building ?: $concern->location }}</div><div class="cf-row-subtitle">{{ $concern->location }}</div></a></td>
                                <td>@include('partials.status-badge', ['concern' => $concern])</td>
                                <td class="cf-queue-meta">{{ $concern->created_at->format('M j, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</main>
@endsection
