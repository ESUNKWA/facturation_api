<?php

namespace App\Http\Controllers;

use App\Models\T_acces;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

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
        $utilisateurs = Utilisateur::orderBy('r_nom','ASC')->get();
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

     //Ajout des utilisateur
    public function store(Request $request)
    {

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
                        'r_profil'       => $request->p_profil,
                        'r_mdp'         => $request->password,
                        'r_partenaire'       => $request->p_partenaire,
                        ]
                    );

            $lastInsertedId = $insertion->r_i;

            $data = [
                'status'=>1,
                'msg'=>'Utilisateur crée avec succès'
            ];

            return response()->json($data, 200);

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
        //Liste des utilisateurs
        //$utilisateurs = Utilisateur::orderBy('r_nom','ASC')->where('r_partenaire',$id)->get();
        $utilisateurs = DB::select("SELECT * FROM t_utilisateurs
        WHERE r_partenaire = COALESCE(?,r_partenaire)", [$id]);
        $data = [
            'status'=>1,
            'result'=> $utilisateurs
        ];
        return response()->json($data, 200);
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
    public function update(Request $request)
    {
        $update = Utilisateur::find($request->r_i);
        $update->update([
            'r_nom'         => $request->r_nom,
            'r_prenoms'     => $request->r_prenoms,
            'r_email'       => $request->r_email,
            'r_phone'       => '+225'.$request->r_phone,
            'r_description' => $request->r_description,
            'r_img'         => $request->r_img,
            'r_login'       => $request->r_login,
            'r_profil'       => $request->r_profil,
            'r_partenaire'       => $request->r_partenaire,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function activDesact($status, $iduser){
        $update = Utilisateur::find($iduser);
        $update->update([
            'r_status' => $status
        ]);
        switch($update->r_status){
            case 0:
                $data = [
                    "status" => 0,
                    "result" => "Le compte est désactivé",
                ];
                break;

            case 1:
                $data = [
                    "status" => 1,
                    "result" => "Le compte est activé",
                ];
                break;
            default;
            return;
        }

        return response()->json($data, 200);
    }


    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }


    public function userProfile() {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token){

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
