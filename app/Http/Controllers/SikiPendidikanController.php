<?php

namespace App\Http\Controllers;

use App\SikiAsosiasi;
use App\SikiPersonalPendidikan;
use App\PersonalPendidikanSync;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class SikiPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function createSyncLog($pendidikan, $sync)
    {
        if($pendidikan->sync){
            $data = PersonalPendidikanSync::find($pendidikan->sync->id);
            $data->updated_at = Carbon::now();
        } else {
            $data = new PersonalPendidikanSync();
        }

        $data->personal_pendidikan_id = $pendidikan->ID_Personal_Pendidikan;
        $data->sync_id = $sync->ID_Personal_Pendidikan;
        $data->synced_by = Auth::id();

        if($data->save())
            return true;
        else
            return false;
    }

    public function sync(Request $request, $id)
    {
        $asosiasi = SikiAsosiasi::find($request->query("as"));
        
        if(!$asosiasi)
            return redirect("/");

        $date = Carbon::now();
        $pendidikan = SikiPersonalPendidikan::find($id);

        if(!file_exists("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $pendidikan->ID_Personal . "/IJZ.pdf")){
            return redirect()->back()->with('error', 'File Ijazah tidak tersedia');
        }

        $postData = [
            "id_personal_pendidikan"                     => $pendidikan->sync ? $pendidikan->sync->sync_id : 0,
            "id_personal"                                => $pendidikan->ID_Personal,
            "nama_sekolah"                               => $pendidikan->Nama_Sekolah,
            "alamat_sekolah"                             => $pendidikan->Alamat1,
            "id_propinsi_sekolah"                        => 99,
            "id_kabupaten_sekolah"                       => 9999,
            "id_negara_sekolah"                          => $pendidikan->ID_Countries,
            "tahun"                                      => $pendidikan->Tahun,
            "jenjang"                                    => $pendidikan->Jenjang,
            "jurusan"                                    => $pendidikan->Jurusan,
            "no_ijazah"                                  => $pendidikan->No_Ijazah,
            "url_pdf_ijazah"                             => curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $pendidikan->ID_Personal . "/IJZ.pdf")),
            "url_pdf_data_pendidikan"                    => curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $pendidikan->ID_Personal . "/IJZ.pdf")),
            "url_pdf_data_surat_keterangan_dari_sekolah" => curl_file_create(realpath("uploads/source/dokumen-upload/BIODATA/" . $date->format("Y/m/d/") . $pendidikan->ID_Personal . "/IJZ.pdf")),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $asosiasi->apikey->lpjk_key;
        $header[] = "Token:" . $asosiasi->apikey->token;
        $header[] = "Content-Type:multipart/form-data";

        curl_setopt_array($curl, array(
        CURLOPT_URL => config("app.lpjk_endpoint") . "Service/Pendidikan/" . ($pendidikan->sync ? "Ubah" : "Tambah"),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        // $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // $httpstatus = Response::$statusTexts[$httpcode];
        
        // if($httpcode == Response::HTTP_OK){
        //     if($obj = json_decode($response)){
        //         if($obj->response) {
        //             if($this->createSyncLog($pendidikan, $obj))
        //                 return response()->json(['code' => $httpcode, 'status' => $httpstatus, 'data' => $obj]);
        //         }
        //         return response()->json(['code' => $httpcode, 'status' => $httpstatus, 'data' => $obj]);
        //     }
        // }

        // return response()->json(['code' => $httpcode, 'status' => $httpstatus, 'data' => '']);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                if($this->createSyncLog($pendidikan, $obj))
                    return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }
}
