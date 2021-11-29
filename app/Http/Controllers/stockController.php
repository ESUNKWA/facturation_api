<?php

namespace App\Http\Controllers;

use App\Models\cr;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\AchatsProduits;

class stockController extends Controller
{
    private $afficheError = "Une erreur est survenue !";
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
        $addStock = AchatsProduits::create([
            'r_partenaire' => $request->p_partenaire,
            'r_produit' => $request->p_produit,
            'r_utilisateur' => $request->p_utilisateur,
            'r_quantite' => $request->p_quantite
            //'r_mnt' => $request->p_partenaire
        ]);

        if( $addStock->r_i ){

            $updateStock = Produit::find($request->p_produit);

            $updateStock->update([
                "r_stock" => $request->p_newStock
            ]);

            $responseData = [
                "status" => 1,
                "result" => "Stock mise à jour !",
            ];

            return response()->json($responseData, 200);
        }else{
            $responseData = [
                "status" => 0,
                "result" => $this->afficheError,
            ];

            return response()->json($responseData, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(cr $cr)
    {
        //
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
