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
    public function index($date,$idpartenaire)
    {

        $dashData = DB::select("SELECT SUM(vt.r_mnt) as ventejr,
        (SELECT SUM(r_montant) FROM t_reglement_partiele WHERE LEFT(created_at,10) = ? and r_partenaire = ? ) as rglepartieljr,
        (SELECT SUM(r_mnt) FROM t_ventes WHERE LEFT(created_at,10) = ? and r_status = 2 and r_iscmd = 1 and r_partenaire = ? ) as totalCmdJr,
        ( SELECT COUNT(r_i) FROM t_clients WHERE LEFT(created_at,10) = ? and r_partenaire = ?) as nbreClientJour,
        ( SELECT COUNT(r_i) FROM t_ventes WHERE LEFT(created_at,10) = ? and r_status = 1 and r_partenaire = ?) as nbreVenteJr
        /*( SELECT JSON_OBJECT('nbreFactureNonSolderJr',COUNT(r_i), 'mntTotal',SUM(r_mnt)) FROM t_ventes WHERE LEFT(created_at,10) = ? and r_status != 1 ) as FactureNonSolderJr*/

        FROM t_ventes vt  where LEFT(created_at,10) = ? and vt.r_status = 1 and vt.r_partenaire = ?", [$date,$idpartenaire,$date,$idpartenaire, $date, $idpartenaire, $date,$idpartenaire, $date,$idpartenaire]);

        $topsVendu = $this->top_vendus($idpartenaire);

        $chiffre_aff_mois = $this->chiffre_aff_mois($idpartenaire);

        $this->res = array_merge([$dashData], [$topsVendu], $chiffre_aff_mois);

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

        $topsVendu = DB::select("SELECT prd.r_libelle as 'name',SUM(dt.r_total) as 'value'
        FROM t_ventes fac INNER join t_details_ventes dt on fac.r_i = dt.r_vente
        INNER JOIN t_produits prd on prd.r_i = dt.r_produit
        WHERE MONTH(dt.created_at) = MONTH(CURRENT_DATE()) AND fac.r_partenaire = ? AND fac.r_status = 1
        GROUP BY prd.r_libelle ORDER BY fac.r_mnt DESC LIMIT 5", [$idpartenaire]);

        $data = [

            "status" => 1,
            "result" => $topsVendu

        ];

        return $topsVendu;
    }


    public function chiffre_aff_mois($idpartenaire){
        $chiffre_aff_mois = DB::select("SELECT SUM(dt.r_total) as totalMois FROM t_ventes fac
        INNER join t_details_ventes dt on fac.r_i = dt.r_vente
        WHERE MONTH(dt.created_at) = MONTH(CURRENT_DATE()) AND fac.r_partenaire = ? AND fac.r_status = 1;", [$idpartenaire]);

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
