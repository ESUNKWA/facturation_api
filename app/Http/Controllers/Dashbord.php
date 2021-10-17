<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashbord extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date)
    {
        //Tableau de bord
        $dashData = DB::select("SELECT CONVERT(SUM(fac.r_mnt),integer) as ventejr,
        (SELECT CONVERT(SUM(r_montant),integer) FROM t_reglement_partiele WHERE LEFT(created_at,10) = ? ) as rglepartieljr,
        (SELECT CONVERT(SUM(r_mnt),integer) FROM t_factures WHERE LEFT(created_at,10) = ? and r_status = 2 and r_cmd = 1 ) as totalCmdJr,
        ( SELECT COUNT(r_i) FROM t_clients WHERE LEFT(created_at,10) = ? ) as nbreClientJour,
        ( SELECT COUNT(r_i) FROM t_factures WHERE LEFT(created_at,10) = ? and r_status = 1) as nbreVenteJr,
        ( SELECT JSON_OBJECT('nbreFactureNonSolderJr',COUNT(r_i), 'mntTotal',SUM(r_mnt)) FROM t_factures WHERE LEFT(created_at,10) = ? and r_status = 0 ) as FactureNonSolderJr
        FROM t_factures fac  where LEFT(created_at,10) = ? and fac.r_status = 1;", [$date, $date,$date, $date, $date, $date]);

        $data = [

            "status" => 1,
            "result" => $dashData

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
        //
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
