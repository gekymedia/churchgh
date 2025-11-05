<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'first_name','last_name','phone','email','gender','dob','address','membership_status'
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function tithes(): HasMany
    {
        return $this->hasMany(Tithe::class);
    }

    public function offerings(): HasMany
    {
        return $this->hasMany(Offering::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
