<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

/** 
 * General routes
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
 * Authenticated routes
 */
Route::get(
    '/admin',
    [AdminController::class, 'admin']
    )
    ->name('admin');

Route::get(
    '/plan/create',
    [PlanController::class, 'create']
    )
    ->name('plan.create');

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
