<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'contact',
        'owner_email',
        'allow_unsubscribe',
        'allow_subscribe',
        'show_on_homepage',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'owner_email',
        'edit_id',
        'view_id'
    ];

    /**
     * Get the associated shifts for the plan
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shifts(): HasMany
    {
        // order by group, type and start date
        return $this->hasMany(Shift::class)
            ->orderByRaw('IF (`category` = "", 1, 0), `category`')
            ->orderBy('start');
    }
}
