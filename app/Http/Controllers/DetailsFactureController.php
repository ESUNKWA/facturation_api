<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailsFactureController extends Controller
{

    private $id = 0;

    public function construct($id){
        $this->id = $id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idvente)
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($idvente, $date1, $date2)
    {
        $details_ventes = DB::table('t_details_ventes')
            ->join('t_ventes','t_ventes.r_i', 't_details_ventes.r_vente')
            ->join('t_produits','t_produits.r_i', 't_details_ventes.r_produit')
            ->select('t_ventes.r_client','t_details_ventes.*','t_produits.r_libelle')
            ->where('t_details_ventes.r_vente', '=', $idvente)
            ->whereBetween('t_details_ventes.created_at', [$date1." 00:00:00",$date2." 23:59:59"])
            ->orderBy('created_at', 'DESC')
            ->get();

        $tt = count($details_ventes);
        $i = 0;
            for($i; $i < $tt; $i++){
                if( $this->id == 0 ){
                    $this->id = $details_ventes[$i]->r_client;
                    break;
                }
            }

            $client = $this->get_client($details_ventes[0]->r_client);


            $data = json_encode(
                [
                    "status" => 1,
                    "client" => $client[0],
                    "details_achat" => $details_ventes
                ]
            );

            return json_decode($data);
    }

    //Récupération du client ayany initié la vente
    public function get_client($idclient){

        $client = Client::where('r_i',$idclient)->get();

        return $client;
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
