<?php

use App\Models\Letters\Disposition;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Backend\SPM\SpmController;
use App\Http\Controllers\Backend\SPM\TahunController;
use App\Http\Controllers\Backend\SPM\LayananController;
use App\Http\Controllers\Managements\EmployeeController;
use App\Http\Controllers\Backend\SPM\PuskesmasController;
use App\Http\Controllers\Backend\SPM\SubLayananController;
use App\Http\Controllers\Master\Letter\MasterSourceController;
use App\Http\Controllers\Master\Letter\MasterAddressController;
use App\Http\Controllers\Managements\Letters\DispositionController;
use App\Http\Controllers\Master\Letter\MasterDispositionController;
use App\Http\Controllers\Managements\Letters\IncomingLetterController;
use App\Http\Controllers\Managements\Letters\OutgoingLetterController;
use App\Http\Controllers\Managements\Letters\RecommendationController;
use App\Http\Controllers\Master\Employee\MasterEmployeeRankController;
use App\Http\Controllers\Master\Employee\MasterEmployeeTypeController;
use App\Http\Controllers\Managements\Letters\OfficialTaskFileController;
use App\Http\Controllers\Master\Employee\MasterEmployeeCollegeController;
use App\Http\Controllers\Master\Employee\MasterEmployeeWorkUnitController;
use App\Http\Controllers\Master\Employee\MasterEmployeeEducationController;

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

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'master'], function () {
    Route::delete('/master-letter-addresses/bulkDestroy', [MasterAddressController::class, 'bulkDestroy'])->name('master-letter-addresses.bulkDestroy');
    Route::post('/master-letter-addresses/download/{id}', [MasterAddressController::class, 'download'])->name('master-letter-addresses.download');
    Route::resource('master-letter-addresses', MasterAddressController::class);

    Route::get('master-letter-dispositions/export/{format}', [MasterDispositionController::class, 'export'])->name('master-letter-dispositions.export');
    Route::delete('/master-letter-dispositions/bulkDestroy', [MasterDispositionController::class, 'bulkDestroy'])->name('master-letter-dispositions.bulkDestroy');
    Route::resource('master-letter-dispositions', MasterDispositionController::class);

    Route::delete('/master-letter-sources/bulkDestroy', [MasterSourceController::class, 'bulkDestroy'])->name('master-letter-sources.bulkDestroy');
    Route::post('/master-letter-sources/download/{id}', [MasterSourceController::class, 'download'])->name('master-letter-sources.download');
    Route::resource('master-letter-sources', MasterSourceController::class);

    Route::delete('/master-employee-types/bulkDestroy', [MasterEmployeeTypeController::class, 'bulkDestroy'])->name('master-employee-types.bulkDestroy');
    Route::post('/master-employee-types/download/{id}', [MasterEmployeeTypeController::class, 'download'])->name('master-employee-types.download');
    Route::resource('master-employee-types', MasterEmployeeTypeController::class);

    Route::delete('/master-employee-colleges/bulkDestroy', [MasterEmployeeCollegeController::class, 'bulkDestroy'])->name('master-employee-colleges.bulkDestroy');
    Route::post('/master-employee-colleges/download/{id}', [MasterEmployeeCollegeController::class, 'download'])->name('master-employee-colleges.download');
    Route::resource('master-employee-colleges', MasterEmployeeCollegeController::class);

    Route::delete('/master-employee-educations/bulkDestroy', [MasterEmployeeEducationController::class, 'bulkDestroy'])->name('master-employee-educations.bulkDestroy');
    Route::post('/master-employee-educations/download/{id}', [MasterEmployeeEducationController::class, 'download'])->name('master-employee-educations.download');
    Route::resource('master-employee-educations', MasterEmployeeEducationController::class);

    Route::delete('/master-employee-ranks/bulkDestroy', [MasterEmployeeRankController::class, 'bulkDestroy'])->name('master-employee-ranks.bulkDestroy');
    Route::post('/master-employee-ranks/download/{id}', [MasterEmployeeRankController::class, 'download'])->name('master-employee-ranks.download');
    Route::resource('master-employee-ranks', MasterEmployeeRankController::class);

    Route::delete('/master-employee-workunit/bulkDestroy', [MasterEmployeeWorkUnitController::class, 'bulkDestroy'])->name('master-employee-workunit.bulkDestroy');
    Route::post('/master-employee-workunit/download/{id}', [MasterEmployeeWorkUnitController::class, 'download'])->name('master-employee-workunit.download');
    Route::resource('master-employee-workunit', MasterEmployeeWorkUnitController::class);

    Route::resource('master-spm-tahun', TahunController::class);
    Route::resource('master-spm-puskesmas', PuskesmasController::class);
    Route::resource('master-spm-layanan', LayananController::class);
    Route::resource('master-spm-sub-layanan', SubLayananController::class);


    Route::post('spm/tahunSpm', [SpmController::class, 'tahunSpm'])->name('spm.tahunspm');
    Route::put('spm/liveUpdate', [SpmController::class, 'liveUpdate'])->name('spm.liveupdate');
    Route::get('spm/export/{format}', [SpmController::class, 'export'])->name('spm.export');
    Route::get('spm/serverside', [SpmController::class, 'serverside'])->name('spm.serverside');
    Route::resource('spm', SpmController::class);
});

require __DIR__ . '/auth.php';
