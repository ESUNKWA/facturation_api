<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class suiviventesController extends Controller
{
    public function suivi_vente($idpartenaire, $date1, $date2, $iscmd){

        $details_ventes = DB::select("SELECT prd.r_libelle, SUM(dt.r_quantite) as totalVendu, 
        SUM(dt.r_total) as r_total FROM t_produit prd
        INNER JOIN t_details_factures dt on prd.r_i = dt.r_produit
        INNER JOIN t_factures fac ON fac.r_i = dt.r_facture
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
}
