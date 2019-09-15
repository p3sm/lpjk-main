<?php

namespace App\Http\Controllers;

use App\ApprovalTransaction;
use App\SikiAsosiasi;
use App\PersonalRegTtSync;
use App\PersonalRegTtApprove;
use App\TeamKontribusiTt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalRegttController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->asosiasi){
            return redirect('/approval_regtt/' . Auth::user()->asosiasi->asosiasi_id);
        }

    	return view('approval/regtt/index');
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
        $asosiasi = SikiAsosiasi::find($id);

        $postData = [
            "status_99" => 0,
            // "limit" => 10
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/Klasifikasi/Get-TT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);

        $data['response'] = $obj->response;
        $data['results'] = $obj->response > 0 ? $obj->result : [];
        $data['role'] = Auth::user()->role_id;

    	return view('approval/regtt/list')->with($data);
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

    public function approve(Request $request, $id)
    {
        // exit;

        // $asosiasiId = 142;
        $asosiasi = SikiAsosiasi::find($id);
        // dd($asosiasi);
        
        // $reg = SikiRegta::find($id);

        $postData = [
          "id_personal"           => $request->query('ID_Personal'),
          "id_sub_bidang"         => $request->query('ID_Sub_Bidang'),
          "id_kualifikasi"        => $request->query('ID_Kualifikasi'),
          "id_unit_sertifikasi"   => $request->query('id_unit_sertifikasi'),
          "tgl_permohonan"        => $request->query('Tgl_Registrasi'),
          "tahun"                 => Carbon::parse($request->query('Tgl_Registrasi'))->format("Y"),
          "id_provinsi"           => $request->query('ID_propinsi_reg'),
          "id_permohonan"         => $request->query('id_permohonan'),
          "id_status"             => 99,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/History/TT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);

        // dd($response);

        // echo $response;
        // exit;
        
        if($obj = json_decode($response)){
            if($obj->response) {
                $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function ApproveTransaction($request){
        $teamKontribusi = TeamKontribusiTt::where("team_id", $request->query('team'))
        ->where("id_asosiasi_profesi", $request->query('ID_Asosiasi_Profesi'))
        ->where("id_propinsi_reg", $request->query('ID_propinsi_reg'))
        ->where("id_kualifikasi", $request->query('ID_Kualifikasi'))
        ->first();
        
        $approvalTrx                      = new ApprovalTransaction();
        $approvalTrx->id_asosiasi_profesi = $request->query('ID_Asosiasi_Profesi');
        $approvalTrx->id_propinsi_reg     = $request->query('ID_propinsi_reg');
        $approvalTrx->team_id             = $request->query('team');
        $approvalTrx->tipe_sertifikat     = "SKT";
        $approvalTrx->id_personal         = $request->query('ID_Personal');
        $approvalTrx->nama                = $request->query('Nama');
        $approvalTrx->id_sub_bidang       = $request->query('ID_Sub_Bidang');
        $approvalTrx->id_unit_sertifikasi = $request->query('id_unit_sertifikasi');
        $approvalTrx->tgl_registrasi      = $request->query('Tgl_Registrasi');
        $approvalTrx->id_kualifikasi      = $request->query('ID_Kualifikasi');
        $approvalTrx->id_permohonan       = $request->query('id_permohonan');
        $approvalTrx->dpp_adm_anggota     = 0;
        $approvalTrx->dpp_kontribusi      = $teamKontribusi->kontribusi;
        $approvalTrx->dpp_total           = $teamKontribusi->kontribusi;
        $approvalTrx->created_by          = Auth::id();
        $approvalTrx->save();
    }
}
