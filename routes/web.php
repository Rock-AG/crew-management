<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;

/** 
 * Static routes
 **/
Route::get(
    '/',
    [HomepageController::class, 'homepage'])
    ->name('homepage');

Route::get(
    '/impressum',
    function() {
        return view('imprint');
    })
    ->name('imprint');

/**
 * Admin overview
 */
Route::get(
    '/admin',
    [AdminController::class, 'admin']
    )
    ->name('admin');

/**
 *  === Plan ===
 *      creation/editing routes
 */
Route::get(
    '/admin/plan',
    [PlanController::class, 'create']
    )
    ->name('plan.create');

Route::post(
    '/admin/plan',
    [PlanController::class, 'store']
    )
    ->name('plan.store');

Route::get(
    '/admin/plan/{plan:edit_id}/edit',
    [PlanController::class, 'edit']
    )
    ->name('plan.edit');

Route::put(
    '/admin/plan/{plan:edit_id}/edit',
    [PlanController::class, 'update']
    )
    ->name('plan.update');

Route::get(
    '/admin/plan/{plan:edit_id}',
    [PlanController::class, 'admin']
    )
    ->name('plan.view.admin');

Route::delete(
    '/admin/plan/{plan:edit_id}/destroy',
    [PlanController::class, 'destroy']
    )
    ->name('plan.destroy');

Route::get(
    '/plan/{plan:view_id}',
    [PlanController::class, 'show']
    )
    ->name('plan.view.user');

/**
 *  === Subscription ===
 *      creation/editing routes
 */
Route::get(
    '/admin/plan/{plan:edit_id}/subscriptions',
    [PlanController::class, 'admin_subscriptions']
    )
    ->name('plan.subscriptions');

/**
 *  === Shift ===
 *      creation/editing routes
 */
Route::get(
    '/plan/{plan:edit_id}/shift',
    [ShiftController::class, 'create']
    )
    ->name('plan.shift.create');

Route::post(
    '/plan/{plan:edit_id}/shift',
    [ShiftController::class, 'store']
    )
    ->name('plan.shift.store');

Route::get(
    '/plan/{plan:edit_id}/shift/{shift}/edit',
    [ShiftController::class, 'edit']
    )
    ->name('plan.shift.edit');

Route::put(
    '/plan/{plan:edit_id}/shift/{shift}/edit',
    [ShiftController::class, 'update']
    )
    ->name('plan.shift.update');

Route::delete(
    '/plan/{plan:edit_id}/shift/{shift}/delete',
    [ShiftController::class, 'destroy']
    )
    ->name('plan.shift.destroy');

/**
 * Public routes
 */


Route::get('/info', function () {
    Log::info('Phpinfo page visited');
    return phpinfo();
});

Route::get('/health', function () {
    $status = [];

    // Check Database Connection
    try {
        DB::connection()->getPdo();
        // Optionally, run a simple query
        DB::select('SELECT 1');
        $status['database'] = 'OK';
    } catch (\Exception $e) {
        $status['database'] = 'Error';
    }

    // Check Storage Access
    try {
        $testFile = 'health_check.txt';
        Storage::put($testFile, 'OK');
        $content = Storage::get($testFile);
        Storage::delete($testFile);

        if ($content === 'OK') {
            $status['storage'] = 'OK';
        } else {
            $status['storage'] = 'Error';
        }
    } catch (\Exception $e) {
        $status['storage'] = 'Error';
    }

    // Determine overall health status
    $isHealthy = collect($status)->every(function ($value) {
        return $value === 'OK';
    });

    $httpStatus = $isHealthy ? 200 : 503;

    return response()->json($status, $httpStatus);
});
