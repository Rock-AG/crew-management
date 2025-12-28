<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemoveSubscriptionRequest;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\Plan;
use App\Models\Shift;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class SubscriptionController extends Controller
{
    /**
     * Show the form for creating a new subscription.
     *
     * @param Plan $plan
     * @param Shift $shift
     * @return Response
     */
    public function create(Plan $plan, Shift $shift)   {

        $subscription = new Subscription();

        return view('subscription.create', [
            'plan' => $plan,
            'shift' => $shift,
            'subscription' => $subscription,
            'cancelLink' => URL::route('plan.view.user', $plan->view_id),
        ]);
    }

    /**
     * Store a newly created subscription in storage.
     *
     * @param StoreSubscriptionRequest $request
     * @param Plan $plan
     * @param Shift $shift
     * @return Response
     */
    public function store(StoreSubscriptionRequest $request, Plan $plan, Shift $shift)
    {
        // check if there are already enough subscriptions
        if($shift->team_size <= $shift->subscriptions()->count()) {
            Session::flash('fail', __('subscription.enoughSubscription'));
            return redirect()->route('plan.view.user', ['plan' => $plan]);
        }

        $data = $request->validated();
        $sub = $shift->subscriptions()->create($data);

        $sub->sendSubscribeConfirmation();

        Session::flash('info', __('subscription.successfullyCreated'));
        return redirect()->route('plan.view.user', ['plan' => $plan]);
    }

    /**
     * Show the form for editing the specified subscription.
     *
     * @param Plan $plan
     * @param Shift $shift
     * @param Subscription $subscription
     * @return Response
     */
    public function edit(Plan $plan, Shift $shift, Subscription $subscription)
    {
        return view('subscription.create', [
            'plan' => $plan,
            'shift' => $shift,
            'subscription' => $subscription,
            'cancelLink' => URL::route('plan.subscriptions', $plan->edit_id)
        ]);
    }

    /**
     * Update the specified subscription in storage.
     *
     * @param StoreSubscriptionRequest $request
     * @param Plan $plan
     * @param Shift $shift
     * @param Subscription $subscription
     * @return Response
     */
    public function update(StoreSubscriptionRequest $request, Plan $plan, Shift $shift, Subscription $subscription)
    {
        $data = $request->validated();

        $subscription->update($data);

        Session::flash('info', __('subscription.successfullyUpdated'));
        return redirect()->route('plan.subscriptions', ['plan' => $plan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Plan $plan
     * @param Shift $shift
     * @param Subscription $subscription
     * @return Response
     */
    public function destroy(Plan $plan, Shift $shift, Subscription $subscription)
    {
        $subscription->forceDelete();

        Session::flash('info', __('subscription.successfullyDestroyed'));
        return redirect()->route('plan.subscriptions', ['plan' => $plan]);
    }

    /**
     * Show the form for unsubscribing from a shift
     *
     * @param Plan $plan
     * @param Shift $shift
     * @return Response
     */
    public function remove(Plan $plan, Shift $shift)   {
        return view('subscription.remove', ['plan' => $plan, 'shift' => $shift]);
    }

    /**
     * Process the submitted unsubscribe form
     * 
     * @param RemoveSubscriptionRequest $request
     * @param Plan $plan
     * @param Shift $shift
     */
    public function doRemove(RemoveSubscriptionRequest $request, Plan $plan, Shift $shift)   {
        $data = $request->validated();

        foreach ($shift->subscriptions as $sub) {
            if ($sub->email == $data['email']) {
                $sub->sendUnsubscribeConfirmation();
            }
        }

        Session::flash('info', __('subscription.removeEmail'));
        return redirect()->route('plan.view.user', ['plan' => $plan]);
    }

    /**
     * Show the page for confirming the unsubscribe
     *
     * @param Plan $plan
     * @param Shift $shift
     * @param string $unsubscribeConfirmationKey
     * 
     * @return Response
     */
    public function confirmRemove(Plan $plan, Shift $shift, string $unsubscribeConfirmationKey)   {
        return view('subscription.confirmRemove',
            [
                'plan' => $plan,
                'shift' => $shift,
                'unsubscribeConfirmationKey' => $unsubscribeConfirmationKey
            ]);
    }

    /**
     * Process the unsubscribe confirmation
     * 
     * @param Plan $plan
     * @param Shift $shift
     * @param string $unsubscribeConfirmationKey
     * 
     * @return Response
     */
    public function doConfirmRemove(Plan $plan, Shift $shift, string $unsubscribeConfirmationKey)   {
        if ($plan->allow_unsubscribe) {
            foreach ($shift->subscriptions as $sub) {
                if ($sub->unsubscribe_confirmation_key == $unsubscribeConfirmationKey) {
                    $sub->delete();
                    Session::flash('info', __('subscription.successfullyRemoved', ['shiftTitle' => $shift->title]));
                }
            }
        }
        return redirect()->route('plan.view.user', ['plan' => $plan]);
    }
}
