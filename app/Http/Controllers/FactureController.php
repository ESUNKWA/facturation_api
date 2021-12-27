<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\Produit;
use App\Models\Livraison;
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
    public function index($iscmd,$idpartenaire, $date1,$date2)
    {
        //Liste des factures
        $factures = DB::table('t_clients')
            ->join('t_ventes', 't_clients.r_i', '=', 't_ventes.r_client')
            ->select('t_clients.*', 't_ventes.*')
            ->where('t_ventes.r_iscmd','=',$iscmd)
            ->where('t_ventes.r_partenaire','=',$idpartenaire)
            ->whereBetween('t_ventes.created_at', [$date1." 00:00:00",$date2." 23:59:59"])
            ->orderBy('t_ventes.created_at', 'DESC')
            ->get();

            if( count($factures) >= 1 ){
                $response = [
                    "status" => 1,
                    "result" => $factures
                ];
            }else{
                $response = [
                    "status" => 0,
                    "result" => ['Aucune vente effectuée en ce jour']
                ];
            }
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
        $factures = DB::table('t_ventes')
            ->join('t_clients', 't_clients.r_i', '=', 't_ventes.r_client')
            ->orderBy('t_ventes.created_at', 'DESC')
            ->where('t_ventes.r_client', '=', $idClient)
            ->get();
        if( count($factures) >= 1 ){
            $response = [
                "status" => 1,
                "result" => $factures
            ];
        }else{
            $response = [
                "status" => 0,
                "result" => 'Pas de données'
            ];
        }

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
            "r_partenaire"      =>  $request->p_partenaire,
            "r_utilisateur"     =>  $request->p_utilisateur

        ]);

         //Saisie facture
        if( $insert->r_i ){

            $latestOrder = Facture::orderBy('r_i')->count(); // Avoir le nombre d'enregistrement des factures
            $numFacture = date('y')."-".str_pad($latestOrder+1, 5, "0", STR_PAD_LEFT);

                if( $request->p_cmd === 1 ){
                    $status = 2;
                }else{
                    $status = ( $request->p_mnt_partiel == 0 )? 1 : 0;
                }

                $insertFacture      = Facture::create([
                "r_num"             =>  $numFacture,
                "r_client"          =>  $insert->r_i,
                "r_mnt"             =>  $request->p_mnt,
                "r_remise"          =>  $request->p_remise,
                "r_status"          =>  $status,
                "r_iscmd"           =>  $request->p_cmd,
                "r_partenaire"      =>  $request->p_partenaire,
                "r_utilisateur"     =>  $request->p_utilisateur,
                "r_mnt_total_achat" =>  $request->p_mntTotalAchat
                ]);

                if( $insertFacture->r_i ){

                    if( $request->p_mnt_partiel !== 0 ){
                        $this->reglement_partiel($insertFacture->r_i, $request->p_mnt_partiel, false,$request->p_partenaire);
                    }

                    //Saisie détails facture
                    for ($i=0; $i < count($request->p_ligneFacture); $i++){

                        $produit = $request->p_ligneFacture[$i];

                        $insertlgnFacture   = DetailsFactures::create([
                            "r_vente"     =>  $insertFacture->r_i,
                            "r_produit"	    =>  $produit['r_i'],
                            "r_quantite"    =>  $produit['p_quantite'],
                            "r_total"       =>  $produit['p_total'],
                            "r_description" =>  "ras",
                            "r_partenaire"  =>  $request->p_partenaire
                        ]);

                        // Mise à jour stok produits

                        if( $insertlgnFacture->r_i ){

                            $updateProduit = Produit::find($produit['r_i']);

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

                    if( $request->p_livraison !== null ){
                        Livraison::create([
                            "r_vente"       =>  $insertFacture->r_i,
                            "r_ville"	    =>  $request->p_livraison["p_ville"],
                            "r_quartier"    =>  $request->p_livraison["p_quartier"],
                            "r_frais"       =>  $request->p_livraison["p_frais"],
                            "r_status"      =>  "ras",
                            "r_situa_geo"   =>  $request->p_livraison["p_situation_geo"],
                            "r_partenaire"  =>  $request->p_partenaire
                        ]);
                    }

                    switch($request->p_cmd){
                        case 0:
                            $data = [
                                "status" => 1,
                                "result" => "La vente numéro [ " . $numFacture . " ] à bien été enregistrée"
                            ];
                            break;

                        case 1:
                            $data = [
                                "status" => 1,
                                "result" => "La commande numéro [ " . $numFacture . " ] à bien été enregistrée"
                            ];
                            break;
                    }

                    return response()->json($data, 200);

                }else{
                     DB::rollBack();
                }

        }else{
            DB::rollBack();
        }

    }

    //Enregistrement reglement partiel
    public function reglement_partiel($idfacture, $mnt_partiel,$solder,$idpartenaire){

         $reglmtPartiel = ReglementPartiel::create([
            "r_vente" =>$idfacture,
            "r_montant" => $mnt_partiel,
            "r_partenaire"  =>  $idpartenaire
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
            ( SELECT SUM(rgl.r_montant) FROM t_reglement_partiele rgl WHERE rgl.r_vente = fac.r_i ) as mnt_paye,
            det.*, prd.r_prix_vente, prd.r_libelle as libelle_produit 
            FROM t_ventes fac 
            INNER JOIN t_details_ventes det ON fac.r_i = det.r_vente 
            INNER JOIN t_produits prd ON prd.r_i = det.r_produit
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

     //Modification des ventes par partenaire
    public function update(Request $request)
    {
        //Recherche de la vente
        $facture = Facture::find($request->p_facture);

        if( isset($facture) ){
            //Modification de la vente
            $modif_vente = $facture->update([
                "r_mnt"                 =>  $request->p_mnt,
                "r_utilisateur"         =>  $request->p_utilisateur,
                "r_mnt_total_achat"     =>  $request->p_mntTotalAchat
            ]);

            if( $modif_vente ){
                //Modification des lignes de ventes

                for ($i=0; $i < count($request->p_ligneventes); $i++) {

                    $produit = $request->p_ligneventes[$i];

                    $updateLigneVente = DetailsFactures::find($produit['p_idlignevente']);

                    $updateLigneVente->update([
                        "r_produit"	    =>  $produit['p_idproduit'],
                        "r_quantite"    =>  $produit['p_quantite'],
                        "r_total"       =>  $produit['p_total'],
                        "r_description" =>  "ras",
                        "r_utilisateur" =>  $produit['p_utilisateur'],
                    ]);

                }

                $data = [
                    "status" => 1,
                    "result" => "Modification effectuée avec succès !"
                ];
            }
        }else{
            $data = [

                "status" => 1,
                "result" => "Vente non existante !"

            ];
        }



        return response()->json($data, 200);
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
