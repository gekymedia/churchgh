<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Quote
 *
 * Represents a devotional quote or scripture plus message to be delivered to
 * members on a scheduled date. Quotes can be scheduled ahead of time and
 * delivered via the scheduler. The `delivery_time` field allows for
 * specifying a time of day; if null, the scheduler will default to
 * delivering at 06:00.
 */
class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'scripture',
        'message',
        'delivery_date',
        'delivery_time',
        'sent_at',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'delivery_time' => 'string',
        'sent_at'       => 'datetime',
    ];
}