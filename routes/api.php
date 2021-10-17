<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Dashbord;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\UtilisateurContoller;
use App\Http\Controllers\PartenairesController;
use App\Http\Controllers\ProfilUtilisaterController;


/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
Route::get('utilisateur/list', [UtilisateurContoller::class,'index'])->name('get_users');
Route::post('utilisateur/register', [UtilisateurContoller::class,'store'])->name('add_users');
Route::post('utilisateur/login', [UtilisateurContoller::class,'login']);
Route::put('utilisateur/update', [UtilisateurContoller::class,'update']);

//Proifls des utilisateurs
Route::get('profil/list', [ProfilUtilisaterController::class,'index']);
Route::post('profil/store', [ProfilUtilisaterController::class,'store']);
Route::put('profil/update', [ProfilUtilisaterController::class,'update']);
//Route::resource('profilsutilisateurs', ProfilUtilisaterController::class);

Route::resource('profil', ProfilUtilisaterController::class);

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
Route::get('facture/list/{iscmd}', [FactureController::class,'index']);
Route::get('facture/detail/{id}', [FactureController::class,'show']);
Route::get('facture/liste_facture_client/{id}', [FactureController::class,'liste_facture_client']);
Route::post('facture/reglement_partiel/{id}/{mnt}/{solder}', [FactureController::class,'reglement_partiel']);
Route::put('facture/update_status_facture/{status}', [FactureController::class,'update_status_facture']);

//Dashbord
Route::get('dashbord/{date}', [Dashbord::class,'index']);

//Partenaires
Route::resource('partenaire', PartenairesController::class);
