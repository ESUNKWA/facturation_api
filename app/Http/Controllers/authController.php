<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


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
        // Validation des données
        $errors = [
            'p_login' => 'required',
            'p_mdp' => 'required',
        ];
        $erreurs = [
            'p_login.required' => 'Veuillez saisir votre identifiant',
            'p_mdp.required' => 'Veuillez saisir votre mot de passe',
        ];

      
        $validate = Validator::make($request->all(), $errors, $erreurs);


        if( $validate->fails() ){
            return response()->json(['status'=>201, 'result'=> $validate->errors()], 200);
        }

        $login = Utilisateur::where('r_login', $request->p_login)
                                ->where('r_mdp', $request->p_mdp)
                                ->get();


        if( count($login) >= 1 ){

            switch( $login[0]->r_status ){

                case 0:

                    return response()->json(['status'=>-100, 'result'=>'Votre compte est inactif, veuillez contacter l\'éditeur']);

                    break;

                case 1:

                    return response()->json(['status'=>1, 'result'=>$login]);

                    break;

            }

        }else{

            return response()->json(['status'=>0, 'result'=>'Login ou Mot de passe incorrecte !']);

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
