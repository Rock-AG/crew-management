<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShiftRequest;
use App\Models\Plan;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShiftController extends Controller
{
    /**
     * Show the form for creating a new shift.
     *
     * @param Plan $plan
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Plan $plan)
    {
        $shift = new Shift();
        return view('shift.create', ['plan' => $plan, 'shift' => $shift]);
    }

    /**
     * Store a newly created shift in storage.
     *
     * @param StoreShiftRequest $request
     * @param Plan $plan
     * @return Response
     */
    public function store(StoreShiftRequest $request, Plan $plan)
    {
        $data = $request->validated();
        $plan->shifts()->create($data);
        Session::flash('info', __('shift.successfullyCreated'));
        return redirect()->route('plan.view.admin', ['plan' => $plan]);
    }

    /**
     * Show the form for editing a shift.
     *
     * @param Plan $plan
     * @param Shift $shift
     * @return Response
     */
    public function edit(Plan $plan, Shift $shift)
    {
        return view('shift.create', ['shift' => $shift, 'plan' => $plan]);
    }

    /**
     * Update the shift in storage.
     *
     * @param StoreShiftRequest $request
     * @param Plan $plan
     * @param Shift $shift
     * @return Response
     */
    public function update(StoreShiftRequest $request, Plan $plan, Shift $shift)
    {
        $data = $request->validated();
        $shift->update($data);

        Session::flash('info', __('shift.successfullyUpdated'));
        return redirect()->route('plan.view.admin', ['plan' => $plan]);

    }

    /**
     * Remove the specified shift from storage.
     *
     * @param Shift $shift
     * @return Response
     */
    public function destroy(Plan $plan, Shift $shift)
    {
        $shift->forceDelete();
        Session::flash('info', __('shift.successfullyDestroyed'));
        return redirect()->route('plan.view.admin', ['plan' => $plan]);
    }
}
