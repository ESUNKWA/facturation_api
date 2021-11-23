<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivraisaonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Liste des livraisons
    public function index($idpartenaire)
    {
        $livraison = DB::select("SELECT vt.r_i, vt.r_num, vt.r_partenaire , lvr.r_vente, lvr.r_quartier, lvr.r_situa_geo,
                                     lvr.r_frais, lvr.created_at, lvr.updated_at,
                                 CASE lvr.r_status
                                    WHEN 0 THEN 'En cours de livraison'
                                    WHEN 1 THEN 'Livré'
                                 END AS etat_livraison    FROM t_livraison lvr
                                 INNER JOIN t_ventes vt ON vt.r_i = lvr.r_vente", [$idpartenaire]);

        dd($livraison);
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
    public function show($idpartenaire, $date1, $date2)
    {
        $livraison = DB::select("SELECT DISTINCT lvr.r_i, vt.r_num, vt.r_partenaire , lvr.r_vente, lvr.r_quartier, lvr.r_situa_geo,
                                     lvr.r_frais, lvr.created_at, lvr.updated_at, lvr.r_status    FROM t_livraison lvr
                                 INNER JOIN t_ventes vt ON vt.r_i = lvr.r_vente
                                 WHERE vt.r_partenaire = ? AND lvr.created_at BETWEEN ? AND ? ", [$idpartenaire, $date1." 00:00:00", $date2." 23:59:59"]);


        if( $livraison ){
            $data = [

                "status" => 1,
                "result" => $livraison

            ];
        }else{
            $data = [

                "status" => 0,
                "result" => ["Aucune livraison pour cette période"]

            ];
        }


        return $data;
    }

    //Détails livraison
    public function details_produits_livraison($idvente, $date1, $date2){

        $details = DetailsFactureController::orderBy('created_at', 'DESC')
                                            ->where('r_vente',[$idvente])->get();
        return $details;
    }

     //reglement total de la facture
     public function update_status_livraison($idlivraison, $status){

        $updateStatusVente = Livraison::findOrFail($idlivraison);

        $updateStatusVente->update([
            "r_status" => $status
        ]);

        if( $status == 1 ){
            $data = [
                "status" => 1,
                "result" => "Livraison terminée"
            ];
        }else{
            $data = [
                "status" => 1,
                "result" => "Livraison annulée"
            ];
        }
        return response()->json($data, 200);

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
}
