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

class ApprovalRegtaStatus1Controller extends Controller
{
    public function index(Request $request)
    {
        // if(Auth::user()->asosiasi){
        //     return redirect('/approval_regta/' . Auth::user()->asosiasi->asosiasi_id);
        // }
        
    	return view('approval/regta_1/index');
    }

    public function search(Request $request)
    {
        return redirect("approval_1_regta/" . $request->id_personal);
    }
    
    public function list(Request $request)
    {
        $key = ApiKey::first();

        $postData = [
            "status_99" => 1,
            "id_status" => 0,
            "ID_Personal" => $request->nik
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
        // dd($obj);

        if($obj && $obj->response != null){
            $data['response'] = $obj->response;
            $data['results'] = $obj->response > 0 ? $obj->result : [];
            $data['role'] = Auth::user()->role_id;
        } else {
            return redirect()->back()->with('error', "Terjadi kesalahan saat mengambil data, silakan coba lagi");
        }

        return view('approval/regta_1/list')->with($data);
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
          "id_status"             => 1,
          "catatan"               => ""
        ];

        // dd($request);

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
        $find = ApprovalTransaction::where("id_personal", $request->query('ID_Personal'))
                                    ->where("id_sub_bidang", $request->query('ID_Sub_Bidang'))
                                    ->where("id_kualifikasi", $request->query('ID_Kualifikasi'))
                                    ->where("status", 1)
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
            $approvalTrx->status              = 1;
            $approvalTrx->created_by          = Auth::id();
            $approvalTrx->save();
        }
    }
}
