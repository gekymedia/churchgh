<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title','starts_at','ends_at','location','description'];
    protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime'];

    /**
     * Users who have registered for this event.
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}
