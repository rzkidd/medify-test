<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);

Route::get('/category-items', [App\Http\Controllers\CategoryItemController::class, 'index']);
Route::get('/category-items/search', [App\Http\Controllers\CategoryItemController::class, 'search']);
Route::get('/category-items/form/{method}/{id?}', [App\Http\Controllers\CategoryItemController::class, 'formView']);
Route::post('/category-items/form/{method}/{id?}', [App\Http\Controllers\CategoryItemController::class, 'formSubmit']);

Route::get('/category-items/view/{kode}', [App\Http\Controllers\CategoryItemController::class, 'singleView']);
Route::get('/category-items/delete/{id}', [App\Http\Controllers\CategoryItemController::class, 'delete']);

Route::get('/category-items/print/{id}', [App\Http\Controllers\CategoryItemController::class, 'print']);

Route::get('/master-items/export', [App\Http\Controllers\MasterItemsController::class, 'export']);
