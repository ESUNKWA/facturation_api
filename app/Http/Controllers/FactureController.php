<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\DetailsFactures;
use App\Models\ReglementPartiel;
use Illuminate\Support\Facades\DB;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Ventes du jours
    public function index()
    {
        //Liste des factures
        $factures = DB::table('t_clients')
            ->join('t_factures', 't_clients.r_i', '=', 't_factures.r_client')
            ->select('t_clients.*', 't_factures.*')
            ->orderBy('t_factures.created_at', 'DESC')
            ->get();
        //$factures = Facture::orderBy('created_at', 'DESC')->get();
        $response = [
            "status" => 1,
            "result" => $factures
        ];
        return response()->json($response, 200);
        /* Faire un switch case pour ramener le montant de l'avance */
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

    public function liste_facture_client($idClient)
    {
        //Liste des factures
        $factures = DB::table('t_factures')
            ->join('t_clients', 't_clients.r_i', '=', 't_factures.r_client')
            ->orderBy('t_factures.created_at', 'DESC')
            ->where('t_factures.r_client', '=', $idClient)
            ->get();
        //$factures = Facture::orderBy('created_at', 'DESC')->get();
        $response = [
            "status" => 1,
            "result" => $factures
        ];
        return response()->json($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //DB::beginTransaction();
     
        //Saisie un client
        $insert = Client::create([

            "r_type_person"     => $request->p_type_person,
            "r_nom"             => $request->p_nom,
            "r_prenoms"         => $request->p_prenoms,
            "r_phone"           => $request->p_phone,
            "r_email"           => $request->p_email,
            "r_description"     => $request->p_description,

        ]);

         //Saisie facture
        if( $insert->r_i ){

            $latestOrder = Facture::orderBy('r_i')->count(); // Avoir le nombre d'enregistrement des factures
            $numFacture = date('y')."-".str_pad($latestOrder+1, 5, "0", STR_PAD_LEFT);

                $insertFacture  = Facture::create([
                "r_num"         =>  $numFacture,
                "r_client"      =>  $insert->r_i,
                "r_mnt"         =>  $request->p_mnt,
                "r_status"      =>  ( $request->p_mnt_partiel == 0 )? 1 : 0
                ]);

                if( $insertFacture->r_i ){

                    if( $request->p_mnt_partiel !== 0 ){
                        $this->reglement_partiel($insertFacture->r_i, $request->p_mnt_partiel, false);
                    }

                    //Saisie détails facture
                    for ($i=0; $i < count($request->p_ligneFacture); $i++){ 
                        
                        $produit = $request->p_ligneFacture[$i];

                        $insertlgnFacture   = DetailsFactures::create([
                            "r_facture"     =>  $insertFacture->r_i,
                            "r_produit"	    =>  $produit['p_idproduit'],
                            "r_quantite"    =>  $produit['p_quantite'],
                            "r_total"       =>  $produit['p_total'],
                            "r_description" =>  "ras"
                        ]);


                        // Mise à jour stok produits

                        if( $insertlgnFacture->r_i ){

                            $updateProduit = Produit::find($produit['p_idproduit']);

                            $updateProduit->r_stock = $produit['p_stock_restant'];

                            $updateProduit->save();

                            if( !$updateProduit ){
                                DB::rollBack();
                                return;
                            }

                        }else{
                             DB::rollBack();
                        }
                        

                    }
                    
                    $data = [

                        "status" => 1,
                        "result" => "La facture numéro à [ " . $numFacture . " ] bien été enregistrée"

                    ];

                    return response()->json($data, 200);

                }else{
                     DB::rollBack();
                }
               
        }else{
            DB::rollBack();
        }
        
    }

    //Enregistrement reglement partiel
    public function reglement_partiel($idfacture, $mnt_partiel,$solder){
        
         $reglmtPartiel = ReglementPartiel::create([
            "r_facture" =>$idfacture,
            "r_montant" => $mnt_partiel
        ]);

        if($solder == 1){
             $this->update_status_facture($idfacture);
            
            $data = [
                "status" => 1,
                "result" => "La facture a étée soldée !"
            ];
            return response()->json($data, 200);
        } else {
            $res = [
                "status" => 1,
                "result" => "Enregistrement effectué avec succès !"
            ];
            return response()->json($res, 200);
        }
         
    }

    //reglement total de la facture
    public function update_status_facture($idfacture){
        $updateStatusFacture = Facture::find($idfacture);
        $updateStatusFacture->update([
            "r_status" => 1
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Détails de la facture
        $details_facture = DB::select('SELECT 
            fac.r_num, fac.r_client, fac.r_mnt, fac.r_status,
            ( SELECT SUM(rgl.r_montant) FROM t_reglement_partiele rgl WHERE rgl.r_facture = fac.r_i ) as mnt_paye,
            det.*, prd.r_libelle as libelle_produit FROM t_factures fac INNER JOIN t_details_factures det ON fac.r_i = det.r_facture INNER JOIN t_produit prd ON prd.r_i = det.r_produit
        WHERE fac.r_i = ?', [$id]);

            $data = [

                "status" => 1,
                "result" => $details_facture

            ];

            return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function edit(rc $rc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rc $rc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function destroy(rc $rc)
    {
        //
    }
}
