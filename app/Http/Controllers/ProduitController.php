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
    public function store(Request $request)
    {
        //Saisie des produits

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
                "r_categorie"   => $request->p_categorie,
                "r_libelle"     => $request->r_libelle,
                "r_stock"       => $request->p_stock,
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
