<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Liste des clients
        $clients = Client::orderBy('r_nom', 'ASC')->get();
        $responseDatas = [
          "status" => 1,
          "result" => $clients
        ];
        
        return response()->json($responseDatas, 200);
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
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $updateclient = Client::find($request->idCLient);
        if( $updateclient ){
            $updateclient->update([
                "r_nom"             => $request->p_nom,
                "r_prenoms"         => $request->p_prenoms,
                "r_phone"           => $request->p_phone,
                "r_email"           => $request->p_email,
                "r_description"     => $request->p_description,
                "r_utilisateur"     =>  $request->p_utilisateur
            ]);
            $data = [
                "status" => 1,
                "result" => "Modification effectuée avec succès !"
            ];
            return response()->json($data, 200);
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
