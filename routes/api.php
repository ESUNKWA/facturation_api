<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Dashbord;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\UtilisateurContoller;
use App\Http\Controllers\PartenairesController;
use App\Http\Controllers\suiviventesController;
use App\Http\Controllers\ProfilUtilisaterController;


/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::put('utilisateur.activdesact', [UtilisateurContoller::class,'activDesact']);
Route::post('utilisateur/login', [UtilisateurContoller::class,'login']);
Route::resource('utilisateurs', UtilisateurContoller::class);

//Proifls des utilisateurs
Route::resource('profil', ProfilUtilisaterController::class);

//Catégorie

Route::get('categories/{partenaire}', [CategorieController::class,'catProdPaternaire']);
Route::resource('categories', CategorieController::class);

//Produits
Route::put('produit/ajout_stock', [ProduitController::class,'ajout_stock']);
Route::put('produit/edit', [ProduitController::class,'edit']);
//Route::get('produit.alerte/{idpartenaire}', [ProduitController::class, 'alert_stock_produit']);
Route::get('produit.alerte/{idpartenaire}', [ProduitController::class, 'alert_stock_produit']);
Route::resource('produits', ProduitController::class);

//Clients
Route::resource('client', ClientController::class);
//Route::post('client/register', [ClientController::class,'store']);
//Route::get('client/list', [ClientController::class,'index']);


Route::post('facture/register', [FactureController::class,'store']);
Route::get('facture/list/{iscmd}/{partenaire}/{date1}/{date2}', [FactureController::class,'index']);
Route::get('facture/detail/{id}', [FactureController::class,'show']);
Route::get('facture/liste_facture_client/{id}', [FactureController::class,'liste_facture_client']);
Route::post('facture/reglement_partiel/{id}/{mnt}/{solder}/{partenaire}', [FactureController::class,'reglement_partiel']);
Route::put('facture/update_status_facture/{status}', [FactureController::class,'update_status_facture']);
Route::put('facture/update', [FactureController::class,'update']);


//Dashbord
Route::get('dashbord/{partenaire}', [Dashbord::class,'index']);
//Route::get('topsventes/{partenaire}', [Dashbord::class,'produitsPlusVendus']);

//Partenaires
Route::put('partenaires.activdesact', [PartenairesController::class,'activDesact']);
Route::resource('partenaires', PartenairesController::class);

//Suivie des ventes et des commandes
Route::get('detailsvente/{idpartenaire}/{date1}/{date2}/{iscmd}', [suiviventesController::class,'suivi_vente']);
Route::get('produitsVendus/{idpartenaire}/{idproduits}/{iscmd}/{date1}/{date2}', [suiviventesController::class,'produitsVendus']);

//Authentification

Route::resource('auth', authController::class);
