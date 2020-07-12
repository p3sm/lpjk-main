<?php

namespace App\Http\Controllers;

use App\SikiRegta;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class SikiRegtaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
        $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();

        if($user->role->id == 1){
            $data['regtas'] = SikiRegta::whereDate("tgl_thp", ">=", $from->format('Y-m-d'))
            ->whereDate("tgl_thp", "<=", $to->format('Y-m-d'))
            // ->take(100)
            ->groupBy('tahap1')
            ->orderByDesc("tgl_thp")
            ->get();
        } else {
            $data['regtas'] = SikiRegta::where("id_user", $user->username)
            ->whereDate("tgl_thp", ">=", $from->format('Y-m-d'))
            ->whereDate("tgl_thp", "<=", $to->format('Y-m-d'))
            // ->take(100)
            ->groupBy('tahap1')
            ->orderByDesc("tgl_thp")
            ->get();
        }

        $data['from'] = $from;
        $data['to'] = $to;

    	return view('siki/regta/index')->with($data);
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
        $user = Auth::user();

        if($user->role->id == 1){
            $data['regtas'] = SikiRegta::where("tahap", $id)->orderByDesc("ID_Registrasi_TK_Ahli")->get();
        } else {
            $data['regtas'] = SikiRegta::where("tahap", $id)->where("id_user", $user->username)->orderByDesc("ID_Registrasi_TK_Ahli")->get();
        }

    	return view('siki/regta/show')->with($data);
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

    public function createSyncLog($reg, $sync)
    {
        if($reg->sync){
            $data = PersonalRegTaSync::find($reg->sync->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalRegTaSync();
        }

        $data->registrasi_tk_ahli_id = $reg->ID_Registrasi_TK_Ahli;
        $data->sync_id = $sync->ID_Registrasi_TK_Ahli;
        $data->synced_by = Auth::id();

        if($data->save())
            return true;
        else
            return false;
    }

    public function createApproveLog($reg)
    {
        if($reg->approve){
            $data = PersonalRegTaApprove::find($reg->approve->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalRegTaApprove();
        }

        $data->registrasi_tk_ahli_id = $reg->ID_Registrasi_TK_Ahli;
        $data->approved_by = Auth::id();

        if($data->save())
            return true;
        else
            return false;
    }

    public function sync($id)
    {
        $reg = SikiRegta::find($id);

        if(!file_exists("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/VVA_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")){
            return redirect()->back()->with('error', 'File VVA tidak tersedia');
        }
        if(!file_exists("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SPENG_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")){
            return redirect()->back()->with('error', 'File SPENG tidak tersedia');
        }
        if(!file_exists("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SUB_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")){
            return redirect()->back()->with('error', 'File SUB tidak tersedia');
        }
        if(!file_exists("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SA_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")){
            return redirect()->back()->with('error', 'File SA tidak tersedia');
        }

        $postData = [
          "id_registrasi_tk_ahli" => $reg->sync ? $reg->sync->sync_id : 0,
          "id_personal"           => $reg->ID_Personal,
          "id_sub_bidang"         => $reg->ID_Sub_Bidang,
          "id_asosiasi_profesi"   => $reg->ID_Asosiasi_Profesi,
          "id_kualifikasi"        => $reg->ID_Kualifikasi,
          "tgl_registrasi"        => $reg->Tgl_Registrasi,
          "id_propinsi_reg"       => $reg->ID_Propinsi_reg,
          "no_reg_asosiasi"       => $reg->No_Reg_Asosiasi ? $reg->No_Reg_Asosiasi : "-",
          "id_unit_sertifikasi"   => $reg->id_unit_sertifikasi,
          "id_permohonan"         => $reg->id_permohonan,
          "url_pdf_berita_acara_vva"          => curl_file_create(realpath("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/VVA_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")),
          "url_pdf_surat_permohonan_asosiasi" => curl_file_create(realpath("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SPENG_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")),
          "url_pdf_surat_permohonan"          => curl_file_create(realpath("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SUB_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")),
          "url_pdf_penilaian_mandiri_f19"     => curl_file_create(realpath("uploads/source/dokumen-upload/TAHAP/" . $reg->tahap1 . "/SA_" . $reg->ID_Personal . "_" . $reg->ID_Sub_Bidang . ".pdf")),
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $reg->asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $reg->asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => config("app.lpjk_endpoint") . "Service/Klasifikasi/" . ($reg->sync ? "Ubah" : "Tambah") . "-TA",
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
                if($this->createSyncLog($reg, $obj))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function approve($id)
    {
        $reg = SikiRegta::find($id);

        $postData = [
          "id_personal"           => $reg->ID_Personal,
          "id_sub_bidang"         => $reg->ID_Sub_Bidang,
          "id_kualifikasi"        => $reg->ID_Kualifikasi,
          "id_unit_sertifikasi"   => $reg->id_unit_sertifikasi,
          "tgl_permohonan"        => Carbon::parse($reg->Tgl_Registrasi)->format("Y-m-d"),
          "tahun"                 => Carbon::parse($reg->Tgl_Registrasi)->format("Y"),
          "id_provinsi"           => $reg->ID_Propinsi_reg,
          "id_permohonan"         => $reg->id_permohonan,
          "id_status"             => 99,
          "catatan"               => ""
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $reg->asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $reg->asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL => config("app.lpjk_endpoint") . "Service/History/TA",
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
                if($this->createApproveLog($reg))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }
}
