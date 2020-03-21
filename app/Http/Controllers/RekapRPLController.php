<?php

namespace App\Http\Controllers;

use App\ApprovalTransaction;
use App\Asosiasi;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapRPLController extends Controller
{
    
    public function index(Request $request)
    {
      $data['asosiasi'] = Asosiasi::orderBy("id_asosiasi", "asc")->get();
      $data['from'] = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now()->subDays(1);
      $data['to'] = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();
      $data['as'] = $request->as;

      $record = ApprovalTransaction::whereDate("created_at", ">=", $data['from']->format('Y-m-d'))
      ->whereDate("created_at", "<=", $data['to']->format('Y-m-d'));

      if($request->as)
        $record->where("id_asosiasi_profesi", $request->as);
      
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
