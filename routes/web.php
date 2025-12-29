<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/** 
 * === Static routes ===
 **/
Route::get('/',
    [HomepageController::class, 'homepage'])
    ->name('homepage');

Route::get('/impressum',
    function() { return view('imprint'); })
    ->name('imprint');

/**
 *  === Unauthenticated User ===
 *      View plan
 */
Route::get('/plan/{plan:view_id}',
    [PlanController::class, 'show'])
    ->name('plan.view.user');

/**
 *  === Unauthenticated User ===
 *      Subscribe to plan
 */
Route::get('/plan/{plan:view_id}/shift/{shift}/subscribe',
    [SubscriptionController::class, 'create'])
    ->name('subscription.create');

Route::post('/plan/{plan:view_id}/shift/{shift}/subscribe',
    [SubscriptionController::class, 'store'])
    ->name('subscription.store');

/**
 *  === Unauthenticated User ===
 *      Unsubscribe from plan
 */
Route::get('/plan/{plan:view_id}/shift/{shift}/unsubscribe',
    [SubscriptionController::class, 'remove'])
    ->name('subscription.remove');

Route::post('/plan/{plan:view_id}/shift/{shift}/unsubscribe',
    [SubscriptionController::class, 'doRemove'])
    ->name('subscription.doRemove');

Route::get('/plan/{plan:view_id}/shift/{shift}/unsubscribe/{unsubscribeConfirmationKey}',
    [SubscriptionController::class, 'confirmRemove'])
    ->name('subscription.remove.confirm');

Route::post('/plan/{plan:view_id}/shift/{shift}/unsubscribe/{unsubscribeConfirmationKey}',
    [SubscriptionController::class, 'doConfirmRemove'])
    ->name('subscription.remove.doConfirm');

/**
 * === Authenticated User (Admin) ===
 *     All routes in "/admin"
 */
Route::prefix('admin')->middleware('auth')->group(function() {
    /*
     * Admin overview
     */ 
    Route::get('/',
        [AdminController::class, 'admin'])
        ->name('admin');
    
    /*
     * Plan management
     *      Create/edit/delete
     */ 
    Route::get('/plan',
        [PlanController::class, 'create'])
        ->name('plan.create');

    Route::post('/plan',
        [PlanController::class, 'store'])
        ->name('plan.store');

    Route::get('/plan/{plan:edit_id}/edit',
        [PlanController::class, 'edit'])
        ->name('plan.edit');

    Route::put('/plan/{plan:edit_id}/edit',
        [PlanController::class, 'update'])
        ->name('plan.update');

    Route::get('/plan/{plan:edit_id}',
        [PlanController::class, 'admin'])
        ->name('plan.view.admin');

    Route::delete('/plan/{plan:edit_id}/destroy',
        [PlanController::class, 'destroy'])
        ->name('plan.destroy');
    
    /*
     * Shift management
     *      Create/edit/delete
     */
    Route::get('/plan/{plan:edit_id}/shift',
        [ShiftController::class, 'create'])
        ->name('plan.shift.create');

    Route::post('/plan/{plan:edit_id}/shift',
        [ShiftController::class, 'store'])
        ->name('plan.shift.store');

    Route::get('/plan/{plan:edit_id}/shift/{shift}/edit',
        [ShiftController::class, 'edit'])
        ->name('plan.shift.edit');

    Route::put('/plan/{plan:edit_id}/shift/{shift}/edit',
        [ShiftController::class, 'update'])
        ->name('plan.shift.update');

    Route::delete('/plan/{plan:edit_id}/shift/{shift}/delete',
        [ShiftController::class, 'destroy'])
        ->name('plan.shift.destroy');

    /*
     * Subscription management
     *      Edit/delete
     */ 
    Route::get('/plan/{plan:edit_id}/subscriptions',
        [PlanController::class, 'subscriptions'])
        ->name('plan.subscriptions');

    Route::get('/plan/{plan:edit_id}/shift/{shift}/{subscription}/edit',
        [SubscriptionController::class, 'edit'])
        ->name('subscription.edit');

    Route::put('/plan/{plan:edit_id}/shift/{shift}/{subscription}',
        [SubscriptionController::class, 'update'])
        ->name('subscription.update');

    Route::delete('/plan/{plan:edit_id}/shift/{shift}/{subscription}',
        [SubscriptionController::class, 'destroy'])
        ->name('subscription.destroy');
});
