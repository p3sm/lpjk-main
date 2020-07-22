<?php

namespace App\Http\Controllers;

use App\PengajuanNaikStatus;
use App\PengajuanNaikStatusTT;
use App\Asosiasi;
use App\Ustk;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanNaikStatusController extends Controller
{
    
    public function ska(Request $request)
    {
        $data['ustk']= Ustk::where("provinsi_id", Auth::user()->asosiasi->provinsi_id)->get();
        $data['asosiasi'] = Asosiasi::orderBy("id_asosiasi", "asc")->get();

        $data['from'] = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now()->subDays(1);
        $data['to'] = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
        $data['as'] = $request->as;
        $data['us'] = $request->us;


        $pengajuan = PengajuanNaikStatus::whereDate("created_at", ">=", $data['from']->format('Y-m-d'))
        ->whereDate("created_at", "<=", $data['to']->format('Y-m-d'));

        if(Auth::user()->id != 1){
            $pengajuan = $pengajuan->whereHas("createdBy", function ($query) {
                $query->whereHas("asosiasi", function ($query2) {
                    $query2->where("provinsi_id", Auth::user()->asosiasi->provinsi_id);
                });
            });
        }

        if($request->as)
          $pengajuan->where("asosiasi", $request->as);

        if($request->us)
          $pengajuan->where("ustk", $request->us);
        
        $data["pengajuan"] = $pengajuan->orderBy("date", "DESC")->orderBy("id_personal", "ASC")->orderBy("id", "DESC")->get();

        return view('pengajuan_naik_status/indexSKA')->with($data);
    }

    public function skt(Request $request)
    {
        $data['ustk']= Ustk::where("provinsi_id", Auth::user()->asosiasi->provinsi_id)->get();
        $data['asosiasi'] = Asosiasi::orderBy("id_asosiasi", "asc")->get();

        $data['from'] = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now()->subDays(1);
        $data['to'] = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
        $data['as'] = $request->as;
        $data['us'] = $request->us;

        $pengajuan = PengajuanNaikStatusTT::whereDate("created_at", ">=", $data['from']->format('Y-m-d'))
        ->whereDate("created_at", "<=", $data['to']->format('Y-m-d'));

        if(Auth::user()->id != 1){
            $pengajuan = $pengajuan->whereHas("createdBy", function ($query) {
                $query->whereHas("asosiasi", function ($query2) {
                    $query2->where("provinsi_id", Auth::user()->asosiasi->provinsi_id);
                });
            });
        }

        if($request->as)
          $pengajuan->where("asosiasi", $request->as);

        if($request->us)
          $pengajuan->where("ustk", $request->us);
        
        $data["pengajuan"] = $pengajuan->orderBy("date", "DESC")->orderBy("id_personal", "ASC")->orderBy("id", "DESC")->get();

        return view('pengajuan_naik_status/indexSKT')->with($data);
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
