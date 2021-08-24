<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurContoller;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
Route::get('utilisateur/list', [UtilisateurContoller::class,'index'])->name('get_users');
Route::post('utilisateur/register', [UtilisateurContoller::class,'store'])->name('add_users');
Route::post('utilisateur/login', [UtilisateurContoller::class,'login']);
