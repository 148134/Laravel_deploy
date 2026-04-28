<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\HomeController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CourseFinderController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UniversityController as AdminUniversityController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Admin\AccreditationController;
use App\Http\Controllers\Admin\RegionController as AdminRegionController;
use App\Http\Controllers\Admin\TuitionController;


Route::get('/',                  [HomeController::class,        'index'])->name('home');
Route::get('/universities',      [UniversityController::class,  'index'])->name('universities');
Route::get('/universities/{id}', [UniversityController::class,  'show'])->name('university')->where('id', '[0-9]+');
Route::get('/regions',           [RegionController::class,      'index'])->name('regions');
Route::get('/courses',           [CourseFinderController::class,'index'])->name('courses');


Route::prefix('admin')->name('admin.')->group(function () {

    
    Route::get ('login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    
    Route::middleware('admin.auth')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        
        Route::resource('universities', AdminUniversityController::class)->except(['show']);
        Route::patch('universities/{university}/toggle',
            [AdminUniversityController::class, 'toggle'])->name('universities.toggle');

         
        Route::get ('universities/{university}/fees',              [TuitionController::class, 'edit'])->name('tuition.edit');
        Route::post('universities/{university}/fees',              [TuitionController::class, 'update'])->name('tuition.update');
        Route::post('universities/{university}/fees/add-course',   [TuitionController::class, 'addCourse'])->name('tuition.add-course');
        Route::post('universities/{university}/fees/{ucId}',     [TuitionController::class, 'removeCourse'])->name('tuition.remove-course');

        
        Route::resource('courses', CourseController::class)->except(['show']);

        
        Route::resource('scholarships', ScholarshipController::class)->except(['show']);

        
        Route::get ('accreditation',           [AccreditationController::class, 'index'])->name('accreditation.index');
        Route::get ('accreditation/{id}/edit', [AccreditationController::class, 'edit'])->name('accreditation.edit');
        Route::put ('accreditation/{id}',      [AccreditationController::class, 'update'])->name('accreditation.update');

        
        Route::get('regions', [AdminRegionController::class, 'index'])->name('regions.index');
    });
});
