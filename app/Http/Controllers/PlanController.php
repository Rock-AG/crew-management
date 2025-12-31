<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanDuplicateRequest;
use App\Http\Requests\PlanStoreRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Plan;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Show the form for creating a new plan
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $plan = new Plan();
        return view('plan.create', ['plan' => $plan]);
    }

    /**
     * Show the form for editing the plan
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan): View
    {
        return view('plan.create', ['plan' => $plan]);
    }

    /**
     * Show the form for editing the plan
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Plan $plan): View
    {
        return view('plan.duplicate', ['plan' => $plan]);
    }

    /**
     * Create and store a copy of the plan with the new data
     * 
     * Values for allow_unsubscribe, allow_subscribe, show_on_homepage
     * will be set to false
     *
     * @param  \App\Http\Plan $plan
     * @param  \App\Http\Requests\PlanStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function duplicateStore(Plan $plan, PlanDuplicateRequest $request)
    {
        $data = $request->validated();
        
        // Base entity
        $newPlan = Plan::create($data);

        // Shifts with newly calculated dates
        $dateDiff = $plan->event_date->diff($newPlan->event_date);

        foreach ($plan->shifts as $shift) {
            $newPlan->shifts()->create(
                [
                    'title' => $shift->title,
                    'description' => $shift->description,
                    'start' => $shift->start->copy()->add($dateDiff),
                    'end' => $shift->end->copy()->add($dateDiff),
                    'team_size' => $shift->team_size,
                    'category' => $shift->category,
                    'contact_name' => $shift->contact_name,
                    'contact_email' => $shift->contact_email,
                    'contact_phone' => $shift->contact_phone,
                ]
            );
        }

        Session::flash('info', __('plan.successfullyDuplicated'));
        return redirect()->route('plan.view.admin', ['plan' => $newPlan]);
    }

    /**
     * Store the newly created plan.
     *
     * @param  \App\Http\Requests\PlanStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanStoreRequest $request)
    {
        $data = $request->validated();

        $data['allow_unsubscribe'] = $request->has('allow_unsubscribe');
	    $data['allow_subscribe'] = $request->has('allow_subscribe');
	    $data['show_on_homepage'] = $request->has('show_on_homepage');

        $plan = Plan::create($data);

        Session::flash('info', __('plan.successfullyCreated'));
        return redirect()->route('plan.view.admin', ['plan' => $plan]);
    }

    /**
     * Update the specified plan in storage.
     *
     * @param  \App\Http\Requests\UpdatePlanRequest  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $data = $request->validated();

	    $data['allow_unsubscribe'] = $request->has('allow_unsubscribe');
	    $data['allow_subscribe'] = $request->has('allow_subscribe');
	    $data['show_on_homepage'] = $request->has('show_on_homepage');

        $plan->update($data);

        // redirect to shifts overview
        Session::flash('info', __('plan.successfullyUpdated'));
        return redirect()->route('plan.view.admin', ['plan' => $plan]);
    }

    /**
     * Display an overview of shifts for a specified plan.
     *
     * @param Plan $plan
     * @return Response
     */
    public function admin(Plan $plan)
    {
        $shiftsGroupedByCategory = $plan->shifts->groupBy(function(Shift $item) {
            return $item->category !== '' ? $item->category : __('shift.noCategory');
        });

        return view('plan.admin')
            ->with([
                'plan' => $plan,
                'shiftsGroupedByCategory' => $shiftsGroupedByCategory
            ]);
    }

    /**
     * Display an overview of subscriptions for a specified plan.
     *
     * @param Plan $plan
     * @return Response
     */
    public function subscriptions(Request $request, Plan $plan)
    {
        $orderBy = $request->input('orderBy') ?? "title";
        $search = $request->input('search') ?? "";
        $shifts = $plan->getShifts($orderBy, $search)->get();

        return view('plan.subscriptions')->with(['plan' => $plan, 'shifts' => $shifts]);
    }

    /**
     * Remove the plan from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        $plan->forceDelete();
        Session::flash('info', __('plan.successfullyDestroyed'));
        return \redirect()->route('admin');
    }

    /**
     * Show a plan with all subscriptions
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        $shiftsGroupedByCategory = $plan->shifts->groupBy(function(Shift $item) {
            return $item->category !== '' ? $item->category : __('shift.noCategory');
        });

        return view('plan.show', ['plan' => $plan, 'shiftsGroupedByCategory' => $shiftsGroupedByCategory]);
    }

    /**
     * Build formatted date string like:
     *      Mo. 10.1 10:00 - 12:00
     *      Mo. 10.1 10:00 - Di.11.1 12:00
     */
    public static function buildDateString($start, $end, bool $inline = false): string  {
        $res = "";
        if($start->isSameDay($end)) {
            $res .= $start->translatedFormat("l, d. F Y | H:i");
            $res .= " - ";
            $res .= $end->translatedFormat('H:i');
        } elseif($start->isSameYear($end)) {
            $res .= $start->translatedFormat("l, d. F Y | H:i");
            $res .= "&nbsp; -";
            $res .= $inline ? "&nbsp;" : "<br>";
            $res .= $end->translatedFormat("l, d. F Y | H:i");
        } else {
            $res .= $start->translatedFormat("l, d. F Y H:i");
            $res .= $inline ? "&nbsp;" : "<br>";
            $res .= " - ";
            $res .= $inline ? "&nbsp;" : "<br>";
            $res .= $end->translatedFormat("l, d. F Y | H:i");
        }
        return $res;
    }
}
