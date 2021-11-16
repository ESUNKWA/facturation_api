<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class suiviventesController extends Controller
{
    public function suivi_vente($idpartenaire, $date1, $date2, $iscmd){

        $details_ventes = DB::select("SELECT prd.r_i, prd.r_libelle, SUM(dt.r_quantite) as totalVendu, 
        SUM(dt.r_total) as r_total FROM t_produits prd
        INNER JOIN t_details_ventes dt on prd.r_i = dt.r_produit
        INNER JOIN t_ventes fac ON fac.r_i = dt.r_vente
        WHERE prd.r_partenaire = ? AND (LEFT(dt.created_at,10) BETWEEN ? AND ?) 
        AND fac.r_status = 1 and fac.r_iscmd = ? GROUP BY prd.r_libelle ", [$idpartenaire,$date1,$date2, $iscmd]);

        if( $details_ventes ){
            $data = [
                "status"=>1,
                "result"=>$details_ventes
            ];
            return response()->json($data,200);
        }else{
            $data = [
                "status"=>0,
                "result"=>"Aucune données pour cette période"
            ];
            return response()->json($data,200);
        }

       

    }

    public function produitsVendus($idpartenaire, $idproduits, $iscmd, $date1 , $date2){
        $prodVendu = DB::select("SELECT vt.r_num, cli.r_nom, cli.r_prenoms, prd.r_libelle, dt.r_quantite, dt.r_total, dt.created_at 
        FROM t_details_ventes dt
        INNER JOIN t_produits prd ON prd.r_i = dt.r_produit
        INNER JOIN t_ventes vt ON vt.r_i = dt.r_vente
        INNER JOIN t_clients cli on cli.r_i = vt.r_client
        WHERE dt.r_partenaire = ? AND dt.r_produit = ? AND vt.r_iscmd = ? AND DATE(dt.created_at) BETWEEN ? AND ? ", [$idpartenaire, $idproduits, $iscmd , $date1, $date2]);

        $data = [
            "status"=>1,
            "result"=>$prodVendu
        ];
        return response()->json($data,200);
    }

}
