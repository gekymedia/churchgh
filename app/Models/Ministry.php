<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Ministry
 *
 * Represents a ministry or department in the church (e.g., Choir, Ushers,
 * Media). Members may belong to one or many ministries. Ministries are
 * managed by the church leadership and can be assigned to members via
 * the pivot table `member_ministry`.
 */
class Ministry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'description'];

    /**
     * Members belonging to this ministry.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'member_ministry');
    }
}