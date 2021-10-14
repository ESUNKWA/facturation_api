<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Dashbord;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FactureController;
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
Route::put('produit/edit', [ProduitController::class,'edit']);
Route::put('produit/ajout_stock', [ProduitController::class,'ajout_stock']);

//Clients
//Route::resource('client', ClientController::class);
Route::post('client/register', [ClientController::class,'store']);
Route::get('client/list', [ClientController::class,'index']);

Route::post('facture/register', [FactureController::class,'store']);
Route::get('facture/list', [FactureController::class,'index']);
Route::get('facture/detail/{id}', [FactureController::class,'show']);
Route::get('facture/liste_facture_client/{id}', [FactureController::class,'liste_facture_client']);
Route::post('facture/reglement_partiel/{id}/{mnt}/{solder}', [FactureController::class,'reglement_partiel']);

//Dashbord
Route::get('dashbord/{date}', [Dashbord::class,'index']);
