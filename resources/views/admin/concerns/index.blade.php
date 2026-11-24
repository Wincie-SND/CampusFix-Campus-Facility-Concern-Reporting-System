@extends('layouts.app')

@section('title', 'All reports')

@section('content')
<main>
    <header class="cf-page-heading">
        <div>
            <p class="cf-eyebrow">Facility management</p>
            <h1 class="cf-page-title">Every concern, accounted for.</h1>
            <p class="cf-page-subtitle">Review campus reports, update their status, and keep a reliable record.</p>
        </div>
        <span class="cf-heading-note">{{ now()->format('F j, Y') }}</span>
    </header>

    <section class="cf-stat-grid cf-admin-stats" aria-label="Concern queue totals">
        @foreach ([['Total reports', $counts['total'], 'All submitted concerns', '▤'], ['Pending', $counts['pending'], 'Awaiting review', '◷'], ['In progress', $counts['in_progress'], 'Currently being addressed', '↗'], ['Resolved', $counts['resolved'], 'Closed successfully', '✓']] as [$label, $value, $detail, $icon])
            <article class="cf-stat-card">
                <div class="cf-stat-top"><span>{{ $label }}</span><span class="cf-stat-icon" aria-hidden="true">{{ $icon }}</span></div>
                <div class="cf-stat-value">{{ str_pad((string) $value, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="cf-stat-detail">{{ $detail }}</div>
            </article>
        @endforeach
    </section>

    <div class="cf-admin-grid">
        <section class="cf-panel cf-queue-panel">
            <div class="cf-section-head cf-queue-head">
                <div><h2 class="cf-section-title">Submitted reports</h2><p class="cf-section-copy">Search by concern, reporter, building, or reference number.</p></div>
                <span class="cf-queue-meta">{{ $concerns->total() }} total</span>
            </div>

            <form action="{{ route('admin.concerns.index') }}" method="GET" class="cf-search-form">
                <input class="cf-control" id="q" name="q" type="search" value="{{ $search }}" placeholder="Search reports…" aria-label="Search reports">
                <select class="cf-control" id="status" name="status" aria-label="Filter by status">
                    <option value="">All statuses</option>
                    @foreach($statuses as $key => $label)<option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>@endforeach
                </select>
                <div class="cf-search-actions"><button class="cf-button cf-button-primary" type="submit">Search</button><a class="cf-button cf-button-outline" href="{{ route('admin.concerns.index') }}">Clear</a></div>
            </form>

            @if($concerns->isEmpty())
                <div class="cf-empty"><strong>No reports found</strong>Try another search or clear the filters.</div>
            @else
                <div class="cf-report-table-wrap">
                    <table class="cf-report-table cf-queue-table">
                        <thead><tr><th>Concern</th><th>Building / location</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($concerns as $concern)
                                @php $rowUrl = route('admin.concerns.index', array_merge(request()->query(), ['selected' => $concern->id])); @endphp
                                <tr @class(['cf-queue-row', 'is-selected' => $selectedConcern?->id === $concern->id])>
                                    <td><a href="{{ $rowUrl }}"><div class="cf-row-title">{{ $concern->title ?: $concern->category }}</div><div class="cf-row-subtitle">{{ $concern->reference_code }} · {{ $concern->user->name }}</div></a></td>
                                    <td><a href="{{ $rowUrl }}"><div class="cf-row-title">{{ $concern->building ?: 'Campus' }}</div><div class="cf-row-subtitle">{{ $concern->location }}</div></a></td>
                                    <td>@include('partials.status-badge', ['concern' => $concern])</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($concerns->hasPages())
                    <div class="cf-pagination"><span>Page {{ $concerns->currentPage() }} of {{ $concerns->lastPage() }}</span><div class="cf-pagination-links">{{ $concerns->links() }}</div></div>
                @endif
            @endif
        </section>

        <aside class="cf-panel cf-detail-panel" aria-label="Selected report details">
            @if($selectedConcern)
                <div class="cf-detail-head">
                    <div class="cf-detail-ref">{{ $selectedConcern->reference_code }}</div>
                    <h2 class="cf-detail-title">{{ $selectedConcern->title ?: $selectedConcern->category }}</h2>
                    <p class="cf-detail-category">{{ $selectedConcern->category }} · {{ $selectedConcern->created_at->format('M j, Y') }}</p>
                    <div class="mt-3">@include('partials.status-badge', ['concern' => $selectedConcern])</div>
                </div>
                <div class="cf-detail-body">
                    <section class="cf-detail-section">
                        <p class="cf-detail-label">Reporter</p>
                        <p class="cf-detail-value">{{ $selectedConcern->user->name }}<br><span class="cf-queue-meta">{{ $selectedConcern->user->email }}</span></p>
                        <p class="cf-detail-label" style="margin-top: 11px">Location</p>
                        <p class="cf-detail-value">{{ $selectedConcern->building ?: 'Campus' }} · {{ $selectedConcern->location }}</p>
                        <p class="cf-detail-label" style="margin-top: 11px">Description</p>
                        <p class="cf-detail-value cf-detail-desc">{{ Str::limit($selectedConcern->description, 240) }}</p>
                    </section>
                    <section class="cf-detail-section">
                        <p class="cf-detail-label">Update status</p>
                        @if($errors->any())<div class="cf-form-errors" style="margin-top: 9px">{{ $errors->first() }}</div>@endif
                        <form action="{{ route('admin.concerns.update', $selectedConcern) }}" method="POST" class="cf-detail-form">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="return_to" value="queue">
                            <select class="cf-control" name="status" id="selected-status" required aria-label="Report status">
                                @foreach($statuses as $key => $label)<option value="{{ $key }}" @selected(old('status', $selectedConcern->status) === $key)>{{ $label }}</option>@endforeach
                            </select>
                            <textarea class="cf-control" name="admin_note" rows="3" maxlength="2000" placeholder="Add a note for the reporter…" aria-label="Update note">{{ old('admin_note', $selectedConcern->admin_note) }}</textarea>
                            <button class="cf-button cf-button-primary" type="submit">Save changes</button>
                        </form>
                    </section>
                </div>
            @else
                <div class="cf-detail-empty">Select a report from the queue to view its details and update its status.</div>
            @endif
        </aside>
    </div>
</main>
@endsection
