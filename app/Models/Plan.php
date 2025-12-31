<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;
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
        'event_date',
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

    protected function casts(): array
    {
        return [
            'event_date' => 'datetime:Y-m-d',
        ];
    }

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
     * Get the associated shifts for the plan, ordered by the specified field
     * 
     * @param string $orderBy The field to order the shifts by
     * @param string $search The search term
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getShifts($orderBy = "title", $search = "")
    {
        $out = $this->hasMany(Shift::class);

        switch ($orderBy) {
            case "title":
                $out
                    ->orderBy("title")
                    ->orderBy("start");
                break;

            case 'start':
                $out
                    ->orderBy("start")
                    ->orderBy("title");
                break;
            
            case "type":
                $out
                    ->orderByRaw('IF (`type` = "", 1, 0), `type`')
                    ->orderBy("title")
                    ->orderBy("start");
                break;
            
            default:
                $out = $this->shifts();
                break;
        }

        if ($search != "") {
            $out->where('title', 'like', '%' . $search . '%');
        }

        return $out;
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
        
        $start = $firstShift->start;
        $end = $lastShift->end;

        // Same day
        if ($start->isSameDay($end)) {
            return $start->translatedFormat("d. F Y");
        }
        // Same month
        elseif ($start->isSameMonth($end)) {
            return $start->translatedFormat("d.") . ' - ' . $end->translatedFormat("d. F Y");
        }
        // Same year
        elseif ($start->isSameYear($end)) {
            return $start->translatedFormat("d. F") . ' - ' . $end->translatedFormat("d. F Y");
        }
        // Different year
        else {
            return $start->translatedFormat("d. F Y") . ' - ' . $end->translatedFormat("d. F Y");
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
