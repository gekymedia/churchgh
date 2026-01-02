<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Position extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relationship: members who hold this position.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'member_position');
    }
}
