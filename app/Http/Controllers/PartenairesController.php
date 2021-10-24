<?php

namespace App\Http\Controllers;

use App\Models\cr;
use App\Models\Partenaires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartenairesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partenaires = Partenaires::orderBy('r_nom','ASC')->get();
        $data = [
            "status" => 1,
            "result" => $partenaires
        ];
        return response()->json($data,200);
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
        //Récupération des données provenant du serveur
        $inputs = $request->all();

        //Controlle des champs

        $errors = [
            'p_nom'=>'required'
        ];
        $erreurs = [
            'p_nom.required'=>'Le nom du partenaire est réquis',
        ];

        $validator = Validator::make($inputs, $errors, $erreurs);

        if( $validator->fails() ){
            return $validator->errors();
        }else{

            $latestOrder = Partenaires::orderBy('r_i')->count(); // Avoir le nombre d'enregistrement des factures
            $code = "part"."-".str_pad($latestOrder+1, "0", STR_PAD_LEFT);

            $partenaires = Partenaires::create([
                'r_code'            => $code,
                'r_nom'             => $request->p_nom,
                'r_ville'           => $request->p_ville,
                'r_quartier'        => $request->p_quartier,
                'r_situation_geo'   => $request->p_stua_geo,
                'r_status'          => 0,
                'r_description'     => $request->p_description,
            ]);
    
            if( isset($partenaires->r_i) ){
                $data = [
                    "status" => 1,
                    "result" => "Enregistrement effectué avec succès"
                ];
            }else{
                $data = [
                    "status" => 0,
                    "result" => "Une erreur est survenue lors de l'enregistrement"
                ];
            }
            return response()->json($data,200);

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
        $partenaires = Partenaires::orderBy('r_nom','ASC')->where('r_partenaire',$idpartenaire)->get();
        $data = [
            "status" => 1,
            "result" => $partenaires
        ];
        return response()->json($data,200);
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
    public function update(Request $request, $idpartenaire)
    {
        $update = Partenaires::find($idpartenaire);

        //Récupération des données provenant du serveur
        $inputs = $request->all();

        //Controlle des champs
        $errors = [
            'r_nom'=>'required'
        ];
        $erreurs = [
            'r_nom.required'=>'Le nom du partenaire est réquis',
        ];

        $validator = Validator::make($inputs, $errors, $erreurs);

        if( $validator->fails() ){
            return $validator->errors();
        }else{

            $update->update([
                'r_nom'             => $request->r_nom,
                'r_ville'           => $request->r_ville,
                'r_quartier'        => $request->r_quartier,
                'r_situation_geo'   => $request->r_stua_geo,
                'r_description'     => $request->r_description,
            ]);
    
            if( isset($update->r_i) ){
                $data = [
                    "status" => 1,
                    "result" => "Modification effectuée avec succès"
                ];
            }else{
                $data = [
                    "status" => 0,
                    "result" => "Une erreur est survenue lors de a modification"
                ];
            }
            return response()->json($data,200);

        }

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
