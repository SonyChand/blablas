<?php

use App\Models\Letters\Disposition;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Managements\EmployeeController;
use App\Http\Controllers\Managements\Letters\DispositionController;
use App\Http\Controllers\Managements\Letters\IncomingLetterController;
use App\Http\Controllers\Managements\Letters\OutgoingLetterController;
use App\Http\Controllers\Managements\Letters\RecommendationController;
use App\Http\Controllers\Managements\Letters\OfficialTaskFileController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    }
    return redirect()->route('login');
})->name('home.index');


Route::group(['middleware' => ['auth', 'verified',], 'prefix' => 'panel'], function () {
    Route::resource('dashboard', DashboardController::class);
    // Route::get('/uhuys', [DashboardController::class, 'uhuy'])->name('uhuys');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('profiles', ProfileController::class);
});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'management'], function () {
    Route::delete('/incoming-letters/bulkDestroy', [IncomingLetterController::class, 'bulkDestroy'])->name('incoming-letters.bulkDestroy');
    Route::post('/incoming-letters/download/{id}', [IncomingLetterController::class, 'download'])->name('incoming-letters.download');
    Route::resource('incoming-letters', IncomingLetterController::class);

    Route::get('outgoing-letters/export/{format}', [OutgoingLetterController::class, 'export'])->name('outgoing-letters.export');
    Route::delete('/outgoing-letters/bulkDestroy', [OutgoingLetterController::class, 'bulkDestroy'])->name('outgoing-letters.bulkDestroy');
    Route::get('/outgoing-letters/download/{id}', [OutgoingLetterController::class, 'download'])->name('outgoing-letters.download');
    Route::resource('outgoing-letters', OutgoingLetterController::class);

    Route::delete('/dispositions/bulkDestroy', [DispositionController::class, 'bulkDestroy'])->name('dispositions.bulkDestroy');
    Route::post('/dispositions/download/{id}', [DispositionController::class, 'download'])->name('dispositions.download');
    Route::resource('dispositions', DispositionController::class);

    Route::delete('/recommendation-letters/bulkDestroy', [RecommendationController::class, 'bulkDestroy'])->name('recommendation-letters.bulkDestroy');
    Route::post('/recommendation-letters/download/{id}', [RecommendationController::class, 'download'])->name('recommendation-letters.download');
    Route::resource('recommendation-letters', RecommendationController::class);

    Route::post('official-task-files/bulk-destroy', [OfficialTaskFileController::class, 'bulkDestroy'])->name('official-task-files.bulkDestroy');
    Route::get('official-task-files/download/{id}', [OfficialTaskFileController::class, 'download'])->name('official-task-files.download');
    Route::resource('official-task-files', OfficialTaskFileController::class);


    Route::put('/employees/{employee}/disconnect', [EmployeeController::class, 'disconnect'])->name('employees.disconnect');
    Route::delete('/employees/bulkDestroy', [EmployeeController::class, 'bulkDestroy'])->name('employees.bulkDestroy');
    Route::post('/employees/download/{id}', [EmployeeController::class, 'download'])->name('employees.download');
    Route::resource('employees', EmployeeController::class);
});

require __DIR__ . '/auth.php';
