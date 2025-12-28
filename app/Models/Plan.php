<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
     * @inheritDoc
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        // add a unique_link for newly created plans
        if(empty($this->edit_id)) {
            $this->edit_id = Str::random(24);
        }
        if(empty($this->view_id)) {
            $this->view_id = Str::random(32);
        }
        return parent::save($options);
    }

    /**
     * Get the associated shifts for the plan
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shifts(): HasMany
    {
        // order by group, type and start date
        return $this->hasMany(Shift::class)
            ->orderByRaw('CASE WHEN category = \'\' THEN 1 ELSE 0 END, category')
            ->orderBy('start');
    }

    /**
     * Return a string showing the duration of the plan
     * (Start of first shift - End of last shift)
     */
    public function getTimespan(): string
    {
        $firstShift = $this->hasMany(Shift::class)->orderBy('start')->first();
        if (!$firstShift) {
            return "";
        }

        $lastShift = $this->hasMany(Shift::class)->orderBy('end', 'desc')->first();
        
        $start = \Illuminate\Support\Facades\Date::parse($firstShift->start);
        $end = \Illuminate\Support\Facades\Date::parse($lastShift->end);

        // Same day
        if ($start->isSameDay($end)) {
            return $start->isoFormat("dd. OD. MMMM YYYY");
        }
        // Same month
        elseif ($start->isSameMonth($end)) {
            return $start->isoFormat("dd. OD.") . ' - ' . $end->isoFormat("dd. OD. MMMM YYYY");
        }
        // Same year
        elseif ($start->isSameYear($end)) {
            return $start->isoFormat("dd. OD. MMMM") . ' - ' . $end->isoFormat("dd. OD. MMMM YYYY");
        }
        // Different year
        else {
            return $start->isoFormat("dd. OD. MMMM YYYY") . ' - ' . $end->isoFormat("dd. OD. MMMM YYYY");
        }
    }

    /**
     * Calculate the statistics for the plan
     */
    public function getStatistics(): PlanStatistics
    {
        if (!isset($this->statistics)) {
            $this->statistics = new PlanStatistics($this);
        }

        return $this->statistics;
    }
}
