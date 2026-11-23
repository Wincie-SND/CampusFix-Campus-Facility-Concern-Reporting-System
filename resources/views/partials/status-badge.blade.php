@php
    $badgeClasses = [
        'pending' => 'bg-amber-50 text-amber-800 ring-amber-200',
        'in_progress' => 'bg-blue-50 text-blue-800 ring-blue-200',
        'resolved' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
    ][$concern->status] ?? 'bg-slate-100 text-slate-700 ring-slate-200';
@endphp
<span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $badgeClasses }}">
    <span class="h-1.5 w-1.5 rounded-full {{ $concern->status === 'resolved' ? 'bg-emerald-500' : ($concern->status === 'in_progress' ? 'bg-blue-500' : 'bg-amber-500') }}"></span>
    {{ \App\Models\FacilityConcern::STATUSES[$concern->status] ?? \Illuminate\Support\Str::headline($concern->status) }}
</span>
