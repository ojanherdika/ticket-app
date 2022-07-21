<?php

use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/welcome', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('ticket.index');
});
Auth::routes();
Route::prefix('admin')->group(function () {
    Route::get('ticket/search', [TicketsController::class, 'searchPage']);
    Route::post('ticket/search', [TicketsController::class, 'searchLogic']);
    Route::resource('ticket', TicketsController::class);
});
Route::post('ticket/checkin', [TicketsController::class, 'checkin']);
