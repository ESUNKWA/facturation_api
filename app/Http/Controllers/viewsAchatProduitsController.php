<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;

use App\Models\AchatsProduits;
use Illuminate\Support\Facades\DB;
class viewsAchatProduitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
     
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(cr $cr)
    {
        //
    }
    //Liste des produits achétés sur une période par partenaire
    public function consultAchatProduits($idpartenaire, $date1, $date2){
        $achatProduits = DB::table('t_achat_produits')
        ->join('t_produits','t_produits.r_i', 't_achat_produits.r_produit')
        ->select('t_achat_produits.*','t_produits.r_libelle')
        ->whereBetween('t_achat_produits.created_at', [$date1." 00:00:00", $date2." 23:59:59"])
        ->get();
        return $achatProduits;
    }
}
