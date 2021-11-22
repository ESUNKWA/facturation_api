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
    public function show($idpartenaire)
    {
        $livraison = DB::select("SELECT vt.r_i, vt.r_num, vt.r_partenaire , lvr.r_vente, lvr.r_quartier, lvr.r_situa_geo,
                                     lvr.r_frais, lvr.created_at, lvr.updated_at,
                                 CASE lvr.r_status
                                    WHEN 0 THEN 'En cours de livraison'
                                    WHEN 1 THEN 'Livré'
                                 END AS etat_livraison    FROM t_livraison lvr
                                 INNER JOIN t_ventes vt ON vt.r_i = lvr.r_vente
                                 WHERE vt.r_partenaire = ? ", [$idpartenaire]);

        $data = [

            "status" => 1,
            "result" => $livraison

        ];

        return $data;
    }

    //Détails livraison
    public function details_produits_livraison($idvente){

        $details = DetailsFactureController::orderBy('created_at', 'DESC')
                                            ->where('r_vente',[$idvente])->get();
        return $details;
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
