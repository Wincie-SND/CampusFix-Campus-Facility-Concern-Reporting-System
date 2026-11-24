<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityConcern extends Model
{
    protected $fillable = [
        'user_id',
        'reviewed_by',
        'reference_code',
        'category',
        'title',
        'building',
        'location',
        'description',
        'photo_path',
        'status',
        'admin_note',
    ];

    public const CATEGORIES = [
        'Furniture',
        'Electrical',
        'Lighting',
        'Air conditioning',
        'Plumbing',
        'Technology equipment',
        'Building or structure',
        'Other campus facility',
    ];

    public const STATUSES = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
