<?php

namespace App\Http\Controllers;

use App\ApprovalTransaction;
use App\Asosiasi;
use App\UserAsosiasi;
use App\Ustk;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapRPLController extends Controller
{
    
    public function index(Request $request)
    {
      $data['ustk']= Ustk::where("provinsi_id", Auth::user()->asosiasi->provinsi_id)->get();
      $data['asosiasi'] = Asosiasi::orderBy("id_asosiasi", "asc")->get();

      $data['from'] = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now()->subDays(1);
      $data['to'] = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
      $data['sr'] = $request->sr;
      $data['as'] = $request->as;
      $data['us'] = $request->us;
      $data['te'] = $request->te;

      if($request->as)
        $data['team'] = UserAsosiasi::where("provinsi_id", Auth::user()->asosiasi->provinsi_id)->where("asosiasi_id", $request->as)->get();
      else
        $data['team'] = UserAsosiasi::where("provinsi_id", Auth::user()->asosiasi->provinsi_id)->get();

      // dd($data['team']);

      $record = ApprovalTransaction::whereDate("created_at", ">=", $data['from']->format('Y-m-d'))
      ->whereDate("created_at", "<=", $data['to']->format('Y-m-d'));

      if(Auth::user()->id != 1){
        $record = $record->whereHas("createdBy", function ($query) {
            $query->whereHas("asosiasi", function ($query2) {
                $query2->where("provinsi_id", Auth::user()->asosiasi->provinsi_id);
            });
        });
    }

      if($request->sr)
        $record->where("tipe_sertifikat", strtoupper($request->sr));

      if($request->as)
        $record->where("id_asosiasi_profesi", $request->as);

      if($request->us)
        $record->where("id_unit_sertifikasi", $request->us);

      if($request->te)
        $record->where("created_by", $request->te);
      
      $data["record"] = $record->get();

      return view('rekap_rpl/index')->with($data);
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
