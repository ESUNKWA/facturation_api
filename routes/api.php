<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\UtilisateurContoller;
use App\Http\Controllers\ProfilUtilisaterController;

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

//Proifl utilisateur
Route::get('profil/list', [ProfilUtilisaterController::class,'index']);
Route::post('profil/register', [ProfilUtilisaterController::class,'store']);

//Catégorie
Route::get('categorie/list', [CategorieController::class,'index']);
Route::post('categorie/register', [CategorieController::class,'store']);

//Produits
Route::get('produit/list', [ProduitController::class,'index']);
Route::post('produit/register', [ProduitController::class,'store']);
