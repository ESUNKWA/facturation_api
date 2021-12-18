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
        ->where('t_achat_produits.r_partenaire',$idpartenaire)
        ->whereBetween('t_achat_produits.created_at', [$date1." 00:00:00", $date2." 23:59:59"])
        ->get();
        if( count($achatProduits) >= 1 ){
            $responseDatas = [
                "status" => 1,
                "result" => $achatProduits
              ];
        }else{
            $responseDatas = [
                "status" => 0,
                "result" => "Aucun achat éffectué pendant cette période"
              ];
        }
        
        return response()->json($responseDatas, 200);
    }

    //regroupement des produits achétés sur une période par partenaire
    public function regpmntAchatProduits($idpartenaire, $date1, $date2){
        $achatProduits = DB::select("SELECT SUM(ach.r_mnt) as mnt_achat, prd.r_libelle, COUNT(ach.r_produit) as nbre_achat FROM t_achat_produits ach
        INNER JOIN t_produits prd ON prd.r_i = ach.r_produit
        WHERE ach.r_partenaire = ? 
        AND ach.created_at BETWEEN ? AND ? GROUP BY prd.r_libelle", [$idpartenaire, $date1." 00:00:00", $date2." 23:59:59"]);
        if( count($achatProduits) >= 1 ){
            $responseDatas = [
                "status" => 1,
                "result" => $achatProduits
              ];
        }else{
            $responseDatas = [
                "status" => 0,
                "result" => "Aucun achat éffectué pendant cette période"
              ];
        }
        
        return response()->json($responseDatas, 200);
    }

    //Liste des achats par produits
    public function Achat_par_produits($idpartenaire, $idpproduit, $date1, $date2){
        $achatProduits = DB::table('t_achat_produits')
        ->join('t_produits','t_produits.r_i', 't_achat_produits.r_produit')
        ->select('t_achat_produits.*','t_produits.r_libelle')
        ->where('t_achat_produits.r_partenaire',$idpartenaire)
        ->where('t_achat_produits.r_produit',$idpproduit)
        ->whereBetween('t_achat_produits.created_at', [$date1." 00:00:00", $date2." 23:59:59"])
        ->get();
        if( count($achatProduits) >= 1 ){
            $responseDatas = [
                "status" => 1,
                "result" => $achatProduits
              ];
        }else{
            $responseDatas = [
                "status" => 0,
                "result" => "Aucun achat éffectué pendant cette période"
              ];
        }
        
        return response()->json($responseDatas, 200);
    }
}
