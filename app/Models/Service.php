<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = ['name','starts_at','location','notes'];
    protected $casts = ['starts_at'=>'datetime'];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
