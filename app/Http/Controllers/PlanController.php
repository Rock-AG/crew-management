<?php

namespace App\Http\Controllers;

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
        return redirect()->route('plan.admin', ['plan' => $plan]);
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
            return $item->type !== '' ? $item->type : __('shift.noType');
        });

        return view('plan.show', ['plan' => $plan, 'shiftsGroupedByCategory' => $shiftsGroupedByCategory]);
    }
}
