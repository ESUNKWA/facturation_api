<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    
    private $afficheError = "Une erreur est survenue !";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Liste des catégories de produits
        $produits = Categorie::all();
        if( $produits ){
            return response()->json(["status"=>1, "result" => $produits], 200);
        }else{
            return response()->json(["status"=>0, "result" => $this->afficheError], 200);
        }
       
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
        //Saisie des catégories

        $inputs = $request->all();

        $errors = [
            "r_libelle" => "required|unique:t_categorie"
        ];

        $erreurs = [
            "r_libelle.required" => "Le libellé du produit est réquis",
            "r_libelle.unique" => "Catégorie déjà existante"
        ];

        //Controlle des champs
        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails() ){

            return $validate->errors();

        }else{

            $insert = Categorie::create([

                "r_libelle" => $request->r_libelle,
                "r_description" => $request->p_description,
                "r_status" => 1
    
            ]);
    
            if( $insert ){
    
                $responseData = [
                    "status" => 0,
                    "result" => "Enregistrement éffectué avec succes !",
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
