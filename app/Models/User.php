<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'member_id',
        'receive_quote_email',
        'receive_event_reminder_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes to native types.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'             => 'datetime',
            'password'                     => 'hashed',
            'receive_quote_email'          => 'boolean',
            'receive_event_reminder_email' => 'boolean',
        ];
    }

    /**
     * Relationship: the member profile associated with this user.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Relationship: givings made by this user.
     */
    public function givings()
    {
        return $this->hasMany(Giving::class);
    }

    /**
     * Relationship: event registrations for this user.
     */
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Relationship: follow‑up tasks assigned to this user (e.g., leaders).
     */
    public function assignedFollowups()
    {
        return $this->hasMany(Followup::class, 'assigned_user_id');
    }

    /**
     * Relationship: members assigned to this shepherd (flock).
     */
    public function flock()
    {
        return $this->belongsToMany(Member::class, 'shepherd_member', 'shepherd_id', 'member_id')
                    ->withPivot('notes')
                    ->withTimestamps();
    }

    /**
     * Check if user is a shepherd.
     */
    public function isShepherd(): bool
    {
        if (!$this->member) {
            return false;
        }
        return $this->member->hasPosition('shepherd');
    }

    /**
     * Get user's positions through their member profile.
     */
    public function positions()
    {
        if (!$this->member) {
            return collect([]);
        }
        return $this->member->positions;
    }
}
