<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $afficheError = "Une erreur est survenue !";

    public function index()
    {
        //Liste des produits
        $produits = Produit::orderBy('r_libelle', 'ASC')->get();

        $res = [
            "status" => 1,
            "result" => $produits
        ];

        return response()->json($res, 200);
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
    //Saisie des produits
    public function store(Request $request)
    {
         //Validation des champs
        $inputs = $request->all();

        $errors = [
            "p_categorie" => "required",
            "r_libelle" => "required|unique:t_produit"
        ];

        $erreurs = [
            "p_categorie.required" => "La catégorie du produit est réquis",
            "r_libelle.required" => "Le libellé du est réquis",
            "r_libelle.unique" => "Produit déjà existant"
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails() ){
            return $validate->errors();
        }else{

            $insert = Produit::create([
                "r_partenaire"  => $request->p_partenaire,
                "r_categorie"   => $request->p_categorie,
                "r_libelle"     => $request->r_libelle,
                "r_stock"       => $request->p_stock,
                "r_prix_vente"  => $request->p_prix_vente,
                "r_description" => $request->p_description,
                "r_status"      => 1
            ]);
    
            if( $insert ){
    
                $res = [
    
                    "status" => 1,
                    "result" => "Enregistrement effectué avec succès !",
    
                ];
                return response()->json($res, 200);
    
            }else{
                $res = [
    
                    "status" => 0,
                    "result" => $this->afficheError,
    
                ];
                return response()->json($res, 200);
    
            }
        }
    }

        

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($idpartenaire)
    {
        //Liste des produits
        $produits = Produit::orderBy('r_libelle', 'ASC')->where('r_partenaire',$idpartenaire)->get();

        $res = [
            "status" => 1,
            "result" => $produits
        ];

        return response()->json($res, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //Modification
        
        $updateProduit = Produit::find($request->p_idproduit);
       
        $updateProduit->update([
            "r_categorie"  => $request->p_categorie,
            "r_libelle" => $request->r_libelle,
            "r_stock" => $request->p_stock,
            "r_prix_vente"  => $request->p_prix_vente,
            "r_description" => $request->p_description
        ]);

        $res = [
    
            "status" => 1,
            "result" => "Modification effectuée avec succès !",

        ];
        return response()->json($res, 200);

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

    public function ajout_stock(Request $request){
       
        $updateStockProduit = Produit::find($request->p_idproduit);
       
        $updateStockProduit->update([
            "r_stock" => $request->p_quantite
        ]);

        $res = [
            "status" => 1,
            "result" => "La quantité du produit à évoluée !"
        ];
        return response()->json($res, 200);
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
