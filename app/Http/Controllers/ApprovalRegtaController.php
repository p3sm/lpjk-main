<?php

namespace App\Http\Controllers;

use App\ApprovalTransaction;
use App\ApiKey;
use App\TeamKontribusiTa;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalRegtaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key = ApiKey::first();

        $postData = [
            "status_99" => 1,
            "id_status" => 99
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("LPJK_ENDPOINT") . "LPJK-Service/Klasifikasi/Get-TA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);

        if($obj && $obj->response){
            $data['response'] = $obj->response;
            $data['results'] = $obj->response > 0 ? $obj->result : [];
            $data['role'] = Auth::user()->role_id;
        } else {
            return redirect()->back()->with('error', "Terjadi kesalahan saat mengambil data, silakan coba lagi");
        }

    	return view('approval/regta/list')->with($data);
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
    public function show($asosiasi_id)
    {
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
        $key = ApiKey::first();

        $postData = [
          "id_personal"           => $request->query('ID_Personal'),
          "id_asosiasi"           => $request->query('ID_Asosiasi_Profesi'),
          "id_sub_bidang"         => $request->query('ID_Sub_Bidang'),
          "id_kualifikasi"        => $request->query('ID_Kualifikasi'),
          "id_unit_sertifikasi"   => $request->query('id_unit_sertifikasi'),
          "tgl_permohonan"        => $request->query('Tgl_Registrasi'),
          "tahun"                 => Carbon::parse($request->query('Tgl_Registrasi'))->format("Y"),
          "id_provinsi"           => $request->query('ID_Propinsi_reg'),
          "id_permohonan"         => $request->query('id_permohonan'),
          "id_status"             => 0,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("LPJK_ENDPOINT") . "Service/History/TA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        // dd($header);

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
        $find = ApprovalTransaction::where("id_personal", $request->query('ID_Personal'))
                                    ->where("id_sub_bidang", $request->query('ID_Sub_Bidang'))
                                    ->where("id_kualifikasi", $request->query('ID_Kualifikasi'))
                                    ->where("status", 0)
                                    ->first();

        if(!$find){
            $approvalTrx                      = new ApprovalTransaction();
            $approvalTrx->id_asosiasi_profesi = $request->query('ID_Asosiasi_Profesi');
            $approvalTrx->id_propinsi_reg     = $request->query('ID_Propinsi_reg');
            $approvalTrx->tipe_sertifikat     = "SKA";
            $approvalTrx->id_personal         = $request->query('ID_Personal');
            $approvalTrx->nama                = $request->query('Nama');
            $approvalTrx->id_sub_bidang       = $request->query('ID_Sub_Bidang');
            $approvalTrx->id_unit_sertifikasi = $request->query('id_unit_sertifikasi');
            $approvalTrx->tgl_registrasi      = $request->query('Tgl_Registrasi');
            $approvalTrx->id_kualifikasi      = $request->query('ID_Kualifikasi');
            $approvalTrx->id_permohonan       = $request->query('id_permohonan');
            $approvalTrx->status              = 0;
            $approvalTrx->created_by          = Auth::id();
            $approvalTrx->save();
        }
    }
}
