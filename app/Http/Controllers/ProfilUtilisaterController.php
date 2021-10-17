<?php

namespace App\Http\Controllers;

use App\Models\rc;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilUtilisaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Liste des profils
        $profils = Profil::orderBy('r_libelle', 'ASC')->get();
        $data = [ "status" => 1, "result" => $profils ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Controlle des champs
        $inputs = $request->all();

        $errors = [
            'r_libelle' => 'required|unique:t_profil',
        ];

        $erreurs = [
            'r_libelle.required' => 'Le libellé est réquis',
            'r_libelle.unique' => 'Ce nom de profil existe déjà',
        ];

        $validate = Validator::make( $inputs, $errors, $erreurs);

        if( $validate->fails() ){
            return $validate->errors();
        }else{
            $insert = Profil::create([
                'r_libelle' => $request->r_libelle,
                'r_description' => $request->p_description,
                'r_status' => 1
             ]);
            if( $insert ){
                $data = [
                    "status" => 1,
                    "result" => "Profil enregistré avec succès",
                ];
               return response()->json($data, 200);
            }else{
                $data = [
                    "status" => 0,
                    "result" => "Une erreur est survenue lors de l'enregistrement du profil",
                ];
                return response()->json($data, 200);
            }
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
    public function update(Request $request)
    {
        $update = Profil::find($request->r_i);
        $update->update([
            'r_libelle' =>$request->r_libelle,
            'r_description' =>$request->r_description,
        ]);
        $data = [
            "status" => 1,
            "result" => "Modification effectuée avec succès",
        ];
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
