<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\DetailsFactures;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Liste des factures
        $factures = Facture::orderBy('created_at', 'ASC')->get();
        $response = [
            "status" => 1,
            "result" => $factures
        ];
        return response()->json($response, 200);
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

                $insertFacture = Facture::create([
                "r_num" =>"11112",
                "r_client"=>$insert->r_i,
                "r_mnt"=>$request->p_mnt
                ]);

                if( $insertFacture->r_i ){

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
                            $data = [

                                "status" => 1,
                                "result" => "La facture numéro à bien été enregistrée"

                            ];

                            return response()->json($data, 200);

                        }else{
                             DB::rollBack();
                        }
                        

                    }

                }else{
                     DB::rollBack();
                }
               
        }else{
            DB::rollBack();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function show(rc $rc)
    {
        //
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
