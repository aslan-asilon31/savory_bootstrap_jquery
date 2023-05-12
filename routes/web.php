<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodOriginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Food
Route::get('/', [FoodController::class, 'visitorFood']);
Route::get('/foodindex', [FoodController::class, 'index']);
Route::post('/foodstore', [FoodController::class, 'store'])->name('food.store');
Route::get('/foodfetchall', [FoodController::class, 'fetchAll'])->name('food.fetchAll');
Route::delete('/fooddelete', [FoodController::class, 'delete'])->name('food.delete');
Route::get('/foodedit', [FoodController::class, 'edit'])->name('food.edit');
Route::post('/foodupdate', [FoodController::class, 'update'])->name('food.update');

// Food Origin
Route::get('/foodoriginindex', [FoodOriginController::class, 'index']);
Route::post('/foodoriginstore', [FoodOriginController::class, 'store'])->name('foodorigin.store');
Route::get('/foodoriginfetchall', [FoodOriginController::class, 'fetchAll'])->name('foodorigin.fetchAll');
Route::delete('/foodorigindelete', [FoodOriginController::class, 'delete'])->name('foodorigin.delete');
Route::get('/foodoriginedit', [FoodOriginController::class, 'edit'])->name('foodorigin.edit');
Route::post('/foodoriginupdate', [FoodOriginController::class, 'update'])->name('foodorigin.update');
