<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tithe extends Model
{
    protected $fillable = ['member_id','amount','paid_at','reference','notes'];
    protected $casts = ['paid_at'=>'datetime'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
