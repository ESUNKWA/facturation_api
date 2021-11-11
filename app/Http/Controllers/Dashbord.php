<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashbord extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $res;
    public function index($idpartenaire)
    {

        $dashData = DB::select("SELECT COALESCE(SUM(vt.r_mnt),0) as ventejr,
        ( SELECT COALESCE(SUM(rgl.r_montant),0) FROM t_ventes vt INNER JOIN t_reglement_partiele rgl ON vt.r_i = rgl.r_vente WHERE vt.r_status = 0 AND vt.r_iscmd = 0 AND vt.r_partenaire = ? ) as reglPartielJr,
        ( SELECT COALESCE(SUM(vt.r_mnt),0) FROM t_ventes vt WHERE vt.r_status = 0 AND vt.r_iscmd = 0 AND vt.r_partenaire = ? AND DATE(vt.created_at) = DATE(CURRENT_DATE())) as venteNonSoldees,
        ( SELECT COALESCE(SUM(vt.r_mnt),0) FROM t_ventes vt WHERE vt.r_status = 2 AND vt.r_partenaire = ? AND vt.r_iscmd = 1 AND DATE(vt.created_at) = DATE(CURRENT_DATE()) ) as totalCmdJr
        FROM t_ventes vt WHERE vt.r_status = 1 AND vt.r_partenaire = ? AND DATE(vt.created_at) = DATE(CURRENT_DATE())", [$idpartenaire,$idpartenaire,$idpartenaire,$idpartenaire]);

        $topsVendu = $this->top_vendus($idpartenaire);


        $chiffre_aff_mois = $this->chiffre_aff_mois($idpartenaire);

       $this->res = array_merge($dashData, $chiffre_aff_mois, [$topsVendu]);

        $data = [

            "status" => 1,
            "result" => $this->res

        ];

        return $data;


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

    public function top_vendus($idpartenaire){

        $topsVendu = DB::select("SELECT * FROM
        (
        SELECT prd.r_libelle as 'name', dt.r_total as 'value'
                FROM t_ventes fac INNER join t_details_ventes dt on fac.r_i = dt.r_vente
                INNER JOIN t_produits prd on prd.r_i = dt.r_produit
                WHERE MONTH(dt.created_at) = MONTH(CURRENT_DATE())
                AND fac.r_partenaire = 2 AND fac.r_status = 1 GROUP BY prd.r_libelle
        ) as momo ORDER BY value DESC LIMIT 5", [$idpartenaire]);

        $data = [

            "status" => 1,
            "result" => $topsVendu

        ];

        return $topsVendu;
    }


    public function chiffre_aff_mois($idpartenaire){
        $chiffre_aff_mois = DB::select("SELECT COALESCE(SUM(vt.r_mnt),0) as venteMois,

        ( SELECT COALESCE(SUM(rgl.r_montant),0) FROM t_ventes vt
         INNER JOIN t_reglement_partiele rgl ON vt.r_i = rgl.r_vente
         WHERE vt.r_status = 0 AND vt.r_iscmd = 0 AND vt.r_partenaire = ? ) as reglPartielMois

        FROM t_ventes vt WHERE vt.r_status = 1 AND vt.r_partenaire = ? AND MONTH(vt.created_at) = MONTH(CURRENT_DATE());", [$idpartenaire,$idpartenaire]);

        return $chiffre_aff_mois;
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
