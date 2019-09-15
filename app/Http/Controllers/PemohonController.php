<?php

namespace App\Http\Controllers;

use App\Pemohon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PemohonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pemohons'] = Pemohon::all()->sortByDesc("id");

    	return view('pemohon/index')->with($data);
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
     * @param  \App\Pemohon  $pemohon
     * @return \Illuminate\Http\Response
     */
    public function show(Pemohon $pemohon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pemohon  $pemohon
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemohon $pemohon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pemohon  $pemohon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pemohon $pemohon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pemohon  $pemohon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemohon $pemohon)
    {
        //
    }
}
