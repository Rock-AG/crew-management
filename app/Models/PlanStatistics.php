<?php

namespace App\Models;

class PlanStatistics
{
    protected Plan $plan;

    public $shiftsAvailable = 0;
    public $shiftsFull = 0;
    public $subscriptionsAvailable = 0;
    public $subscriptionsFull = 0;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
        $this->calculateStatistics();
    }

    protected function calculateStatistics()
    {
        $shifts = $this->plan->shifts()->get();
        $this->shiftsAvailable = $shifts->count();

        $shifts->each(function(Shift $shift) {
            $subscriptionsCount = $shift->subscriptions()->get()->count();

            $this->subscriptionsAvailable += $shift->team_size;
            $this->subscriptionsFull += $subscriptionsCount;
            
            if ($shift->team_size <= $subscriptionsCount) {
                $this->shiftsFull += 1;
            }
        });
    }
}