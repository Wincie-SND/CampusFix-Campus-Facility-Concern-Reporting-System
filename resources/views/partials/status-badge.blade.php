<span class="cf-status-badge cf-status-{{ $concern->status }}">
    {{ \App\Models\FacilityConcern::STATUSES[$concern->status] ?? \Illuminate\Support\Str::headline($concern->status) }}
</span>
