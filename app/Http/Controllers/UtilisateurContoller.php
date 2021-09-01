<?php

namespace App\Http\Controllers;

use App\Models\T_acces;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UtilisateurContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Liste des utilisateurs
        $utilisateurs = Utilisateur::all();
        $data = [
            'status'=>1,
            'result'=> $utilisateurs
        ];
        return response()->json($data, 200);
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

        //Controlle des champs
        
        $inputs = $request->all();//Récupère tous champs du formulaire

        $errors = [
            'p_nom' => 'required|between:2,30',
            'p_prenoms' => 'required',
            'password' => 'required|min:4|confirmed',
        ];

        $erreurs = [
            'p_nom.required' => 'Le nom de l\'utilisateur est réquis',
            'p_nom.between' => 'Le nom de l\'utilisateur est trop long',
            'p_prenoms.required' => 'Le prenoms de l\'utilisateur est réquis',
            'p_email.required' => 'L\'adresse email de l\'utilisateur est réquis',
            'p_email.email' => 'Le format de l\'adresse email est incorrect',
            'p_login.required' => 'Le login est réquis',
            'p_password.required' => 'Le mot de passe est réquis',
            'password.min' => 'Le mot de passe doit être de 6 caractères minimum',
            'password_confirmation.required' => 'Confirmer le mot de passe',
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails() ){
            return $validate->errors();
        }else{
            //Création d'untilisateur
            //DB::beginTransaction();

            $insertion = Utilisateur::create(
                        [
                        'r_nom'         => $request->p_nom,
                        'r_prenoms'     => $request->p_prenoms,
                        'r_email'       => $request->p_email,
                        'r_phone'       => '+225'.$request->p_phone,
                        'r_description' => $request->p_description,
                        'r_img'         => $request->p_img,
                        'r_login'       => $request->p_login,
                        ]
                    );

            $lastInsertedId = $insertion->r_i;

            $data = [
                'status'=>1,
                'msg'=>'Utilisateur crée avec succès'
            ];

            if( $insertion->r_i ){


                $insertAcces = T_acces::create([
                    'r_utilisateur' => $insertion->r_i,
                    'r_mdp'         => $request->password,
                    'r_status'      => 1
                ]);

                if( $insertAcces ){
                    return response()->json($data, 200);
                }



            }else{
               // DB::rollBack();
            }


            //DB::commit();

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request){

        // Validation des données

         $errors = [
            'p_login' => 'required',
            'p_mdp' => 'required',
        ];

        $validate = Validator::make($request->all(), $errors);


        if( $validate->fails() ){
            return response()->json(['status'=>200, 'result'=> $validate->errors()], 200);
        }

        $login = Utilisateur::where('r_login', $request->p_login)->get();

        try {
            if( count($login) !== 0 ){
                
               $acces = T_acces::where('r_utilisateur', $login[0]->r_i)->get();

                if( $acces[0]->r_mdp === $request->p_mdp ){

                    return response()->json(['status'=>1, 'result'=>$login]);

                }else{
                    return response()->json(['status'=>0, 'result'=>'Login ou Mot de passe incorrecte !']);
                }

            }else{
                return response()->json(['status'=>0, 'result'=>'Login ou Mot de passe incorrecte']);
            }
        } catch (\Throwable $th) {
           //return response()->json(['status'=>1, 'result'=>$login]);
        }


    }
}
