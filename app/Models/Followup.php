<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Followup
 *
 * Represents a follow‑up task for a church member. A follow‑up is typically
 * created when a member requires additional engagement, for example after a
 * first visit, baptism class or counselling session. Each follow‑up is tied
 * to a member and records a date when the follow‑up should occur, an optional
 * note describing what should be done and the date/time when it was completed.
 */
class Followup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'followup_date',
        'note',
        'completed_at',
        'category',
        'assigned_user_id',
        'status',
    ];

    /**
     * Dates that should be cast to Carbon instances.
     *
     * @var array<string>
     */
    protected $dates = [
        'followup_date',
        'completed_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the member that this follow‑up relates to.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the user assigned to handle this follow‑up (e.g., a pastor or leader).
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * Determine if the follow‑up has been marked as completed.
     *
     * A follow‑up is considered completed if it has a non‑null
     * completed_at timestamp or its status has been set to 'closed'.
     */
    public function getIsCompletedAttribute(): bool
    {
        return !is_null($this->completed_at) || ($this->status === 'closed');
    }
}