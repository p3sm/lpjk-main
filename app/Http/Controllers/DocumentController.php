<?php

namespace App\Http\Controllers;

use App\PersonalRegTA;
use App\PersonalRegTT;
use App\PengajuanNaikStatus;
use App\PengajuanNaikStatusTT;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $param = explode(".", Crypt::decryptString($request->query('data')));

            if($param["0"] == 1){
                $pengajuan = PengajuanNaikStatus::find($param["1"]);
            } else {
                $pengajuan = PengajuanNaikStatusTT::find($param["1"]);
            }

            $data["ttd_verifikator"] = $pengajuan->ttd_verifikator;
            $data["ttd_database"] = $pengajuan->ttd_database;
            
            if($param["0"] == 1){
                $data['regta'] = PersonalRegTA::where("diajukan", 1)->where("ID_Personal", $param["2"])->where("Tgl_Registrasi", $param["3"])->get();
            } else {
                $data['regta'] = PersonalRegTT::where("diajukan", 1)->where("ID_Personal", $param["2"])->where("Tgl_Registrasi", $param["3"])->get();
            }
        } catch (\Exception $e){
            return;
        }

        if($param["0"] == 1){
            return view('document/index')->with($data);
        } else {
            return view('document/indexSKT')->with($data);
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
        //
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
}
