<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;

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
    return view('form');
})->name('home.form');

Route::post('link-create', [LinkController::class, 'store'])->name('link.store');

Route::get('{hash}', [LinkController::class, 'followLink'])
    ->where(['hash' => '[A-Za-z0-9]{8}'])
    ->name('link.follow');
