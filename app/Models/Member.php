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

    /**
     * Relationship: ministries the member belongs to.
     */
    public function ministries()
    {
        return $this->belongsToMany(Ministry::class, 'member_ministry');
    }

    /**
     * Relationship: user account associated with this member (if any).
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Relationship: givings recorded against this member (online giving).
     */
    public function givings()
    {
        return $this->hasMany(Giving::class);
    }

    /**
     * Relationship: event registrations for this member via their user account.
     */
    public function eventRegistrations()
    {
        return $this->hasManyThrough(EventRegistration::class, User::class);
    }

    /**
     * Relationship: positions held by this member (elder, deacon, deaconess, shepherd).
     */
    public function positions()
    {
        return $this->belongsToMany(Position::class, 'member_position');
    }

    /**
     * Relationship: shepherds assigned to this member.
     */
    public function shepherds()
    {
        return $this->belongsToMany(User::class, 'shepherd_member', 'member_id', 'shepherd_id')
                    ->withPivot('notes')
                    ->withTimestamps();
    }

    /**
     * Check if member has a specific position.
     */
    public function hasPosition(string $positionName): bool
    {
        return $this->positions()->where('name', $positionName)->exists();
    }

    /**
     * Check if member is a shepherd.
     */
    public function isShepherd(): bool
    {
        return $this->hasPosition('shepherd');
    }
}
