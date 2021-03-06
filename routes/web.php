<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/ajax', function () {
    return view('ajax');
});

Route::get('/upload', [HomeController::class, 'upload']);
Route::post('/importstudent', [HomeController::class, 'importstudent'])->name('importstudent');
Route::post('/importmark', [HomeController::class, 'importmark'])->name('importmark');
Route::post('/ajaxsubmit', [HomeController::class, 'ajaxsubmit'])->name('ajaxsubmit');
Route::get('/viewreport', [HomeController::class, 'viewreport'])->name('viewreport');
Route::get('/viewchart', [HomeController::class, 'viewchart'])->name('viewchart');
Route::get('/showmark/{studentid}/{classname}', [HomeController::class, 'showmark'])->name('showmark');



