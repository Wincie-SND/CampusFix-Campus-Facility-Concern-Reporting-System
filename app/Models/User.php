<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function concerns(): HasMany
    {
        return $this->hasMany(FacilityConcern::class);
    }

    public function canReviewConcerns(): bool
    {
        return in_array($this->role, ['staff', 'faculty', 'admin'], true);
    }

    public function canSubmitConcerns(): bool
    {
        return in_array($this->role, ['student', 'guest', 'faculty'], true);
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['staff', 'admin'], true);
    }
}
