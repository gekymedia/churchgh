<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Lead
 *
 * A Lead represents a contact who is not yet a registered church member but
 * could be interested in the church. Leads are typically collected during
 * outreach, crusades or evangelism campaigns. Storing their contact
 * information allows the church to follow up with invitations and general
 * communication.
 */
class Lead extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'notes',
    ];
}