<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Giving
 *
 * Represents an online giving transaction. A giving may be linked to a
 * registered user and optionally to a member profile if the user has one.
 * Donors can specify the type of giving (tithe, offering, seed, donation)
 * and whether they wish to remain anonymous. The `reference` and `method`
 * fields capture details returned from the payment gateway.
 */
class Giving extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'member_id',
        'type',
        'amount',
        'is_anonymous',
        'note',
        'reference',
        'method',
        'paid_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'paid_at'      => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}