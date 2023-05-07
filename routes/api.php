<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('items')->group(function (){
    Route::get('/',[\App\Http\Controllers\Api\ItemsController::class,'index'])->name('items.index');
    Route::get('/{id}/show',[\App\Http\Controllers\Api\ItemsController::class,'show'])->name('items.show');
    Route::post('/',[\App\Http\Controllers\Api\ItemsController::class,'store'])->name('items.store');
    Route::get('/statistics',[\App\Http\Controllers\Api\ItemsController::class,'statistics'])->name('items.statistics');


});
