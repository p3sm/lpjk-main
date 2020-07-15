<?php

namespace App\Http\Controllers;

use App\ApprovalTransaction;
use App\ApiKey;
use App\TeamKontribusiTa;
use App\Personal;
use App\PersonalKursus;
use App\PersonalOrganisasi;
use App\PersonalPendidikan;
use App\PersonalProyek;
use App\PersonalRegTA;
use App\PersonalRegTT;
use App\PersonalRegTaSync;
use App\PersonalRegTaApprove;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if(Auth::user()->asosiasi){
        //     return redirect('/approval_regta/' . Auth::user()->asosiasi->asosiasi_id);
        // }
        
    	return view('biodata/index');
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
        return redirect("biodata/" . $request->id_personal);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id_personal)
    {
        $obj = $this->getBiodata($id_personal);

        if(!$obj){
          $result = new \stdClass();
          $result->message = "Error while refreshing token, please contact Administrator";
          $result->status = 401;

          return response()->json($result, 401);
        }

        try{
          if($obj && $obj->response){
            if($obj->response > 0){
              $local = Personal::find($obj->result[0]->id_personal);
              $obj->result[0]->file = null;
    
              if($local && $obj->response > 0){
                  $obj->result[0]->file = [
                    "persyaratan_4" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_4,
                    "persyaratan_5" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_5,
                    "persyaratan_8" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_8,
                    "persyaratan_11" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_11,
                    "persyaratan_12" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_12,
                  ];
              }
            }

            $data['id_personal']   = $id_personal;
            $data['response']      = $obj->response;
            $data['results']       = $obj->response > 0 ? $obj->result : [];
            $data['role']          = Auth::user()->role_id;
            $data['pendidikan']    = $this->getPendidikan($id_personal);
            $data['proyek']        = $this->getProyek($id_personal);
            $data['organisasi']    = $this->getOrganisasi($id_personal);
            $data['kursus']        = $this->getKursus($id_personal);
            $data['klasifikasiTA'] = $this->getKlasifikasiTA($id_personal);
            $data['klasifikasiTT'] = $this->getKlasifikasiTT($id_personal);

            if($obj->response < 1)
              $request->session()->flash('error', $obj->message);
            else if(count($data['results']) < 1)
              $request->session()->flash('error', 'Biodata tidak ditemukan');
          } else {
            $request->session()->flash('error', "Terjadi kesalahan saat mengambil data, silakan coba lagi");
          }

        } catch (Exception $err){
          $request->session()->flash('error', $err);
        }


    	return view('biodata/list')->with($data);
    }

    private function getBiodata($id_personal){
      $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

      $postData = [
          "id_personal" => $id_personal,
          // "limit" => 10
        ];

      $curl = curl_init();
      $header[] = "X-Api-Key:" . $key->lpjk_key;
      $header[] = "Token:" . $key->token;
      $header[] = "Content-Type:multipart/form-data";
      curl_setopt_array($curl, array(
          CURLOPT_URL            => config("app.lpjk_endpoint") . "Service/Biodata/Get",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST  => "POST",
          CURLOPT_POSTFIELDS     => $postData,
          CURLOPT_HTTPHEADER     => $header,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0
      ));
      $response = curl_exec($curl);

      $obj = json_decode($response);
      
      if($obj->message == "Token Anda Sudah Expired ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru." || $obj->message == "Parameter Token Tidak Ditemukan ! " || $obj->message == "Token Anda Tidak Terdaftar ! Silahkan Lakukan Aktivasi Token Untuk Mendapatkan Token Baru."){
        if($this->refreshToken()){
            return $this->getBiodata($id_personal);
        } else {
          return false;
        }
      }

      return $obj;
    }

    private function getPendidikan($id_personal){
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
            "id_personal" => $id_personal,
            // "limit" => 10
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "Service/Pendidikan/Get",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);
        // dd($obj);

        try{
          
          if($obj->response > 0){
            foreach($obj->result as $key => $data){
              $data->file = null;
              $local = PersonalPendidikan::find($data->ID_Personal_Pendidikan);
    
              if($local){
                  $data->file = [
                    "persyaratan_6" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_6,
                    "persyaratan_7" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_7,
                    "persyaratan_15" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_15,
                  ];
              }
            }
          }

          $result = $obj->response > 0 ? $obj->result : [];

        } catch (Exception $err){
          return [];
        }


      return $result;
    }

    private function getProyek($id_personal){
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
            "id_personal" => $id_personal,
            // "limit" => 10
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "Service/Proyek/Get",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);
        // dd($obj);

        try{
          
          if($obj->response > 0){
            foreach($obj->result as $key => $data){
              $data->file = null;
              $local = PersonalProyek::find($data->id_personal_proyek);
    
              if($local){
                  $data->file = [
                    "persyaratan_16" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_16,
                  ];
              }
            }
          }

          $result = $obj->response > 0 ? $obj->result : [];

        } catch (Exception $err){
          return [];
        }


      return $result;
    }

    private function getOrganisasi($id_personal){
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
            "id_personal" => $id_personal,
            // "limit" => 10
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "Service/Organisasi/Get",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);
        // dd($obj);

        try{
          
          if($obj->response > 0){
            foreach($obj->result as $key => $data){
              $data->file = null;
              $local = PersonalOrganisasi::find($data->ID_Personal_Pengalaman);
    
              if($local){
                  $data->file = [
                    "persyaratan_18" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_18,
                  ];
              }
            }
          }

          $result = $obj->response > 0 ? $obj->result : [];

        } catch (Exception $err){
          return [];
        }


      return $result;
    }

    private function getKursus($id_personal){
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
            "id_personal" => $id_personal,
            // "limit" => 10
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "Service/Kursus/Get",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);
        // dd($obj);

        try{
          
          if($obj->response > 0){
            foreach($obj->result as $key => $data){
              $data->file = null;
              $local = PersonalKursus::find($data->ID_Personal_Kursus);
    
              if($local){
                  $data->file = [
                    "persyaratan_17" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_17,
                  ];
              }
            }
          }

          $result = $obj->response > 0 ? $obj->result : [];

        } catch (Exception $err){
          return [];
        }


      return $result;
    }

    private function getKlasifikasiTA($id_personal){
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
            "ID_Personal" => $id_personal,
            "status_99" => 1,
            "id_status" => 99
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "Service/Klasifikasi/Get-TA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);

        try{
          
          if($obj->response > 0){
            foreach($obj->result as $key => $data){
              $data->file = null;
              $local = PersonalRegTA::find($data->ID_Registrasi_TK_Ahli);
    
              if($local){
                  $data->file = [
                    "persyaratan_1" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_1,
                    "persyaratan_2" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_2,
                    "persyaratan_3" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_3,
                    "persyaratan_13" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_13,
                  ];
              }
            }
          }

          $result = $obj->response > 0 ? $obj->result : [];
          
          $result = array_merge($result, $this->getKlasifikasiTA_0($id_personal));

        } catch (Exception $err){
          return [];
        }


      return $result;
    }

    private function getKlasifikasiTA_0($id_personal){
      $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
            "ID_Personal" => $id_personal,
            "status_99" => 1,
            "id_status" => 0
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "Service/Klasifikasi/Get-TA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);
        // dd($obj);

        try{
          
          if($obj->response > 0){
            foreach($obj->result as $key => $data){
              $data->file = null;
              $local = PersonalRegTA::find($data->ID_Registrasi_TK_Ahli);
    
              if($local){
                  $data->file = [
                    "persyaratan_1" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_1,
                    "persyaratan_2" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_2,
                    "persyaratan_3" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_3,
                    "persyaratan_13" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_13,
                  ];
              }
            }
          }

          $result = $obj->response > 0 ? $obj->result : [];

        } catch (Exception $err){
          return [];
        }


      return $result;
    }

    private function getKlasifikasiTT($id_personal){
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
            "ID_Personal" => $id_personal,
            "status_99" => 1,
            "id_status" => 99
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "Service/Klasifikasi/Get-TT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);
        // dd($obj);

        try{
          
          if($obj->response > 0){
            foreach($obj->result as $key => $data){
              $data->file = null;
              $local = PersonalRegTT::find($data->ID_Registrasi_TK_Trampil);
    
              if($local){
                  $data->file = [
                    "persyaratan_1" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_1,
                    "persyaratan_2" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_2,
                    "persyaratan_3" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_3,
                  ];
              }
            }
          }

          $result = $obj->response > 0 ? $obj->result : [];
          
          $result = array_merge($result, $this->getKlasifikasiTT_0($id_personal));

        } catch (Exception $err){
          return [];
        }


      return $result;
    }

    private function getKlasifikasiTT_0($id_personal){
      $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
            "ID_Personal" => $id_personal,
            "status_99" => 1,
            "id_status" => 0
          ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => env("LPJK_ENDPOINT") . "Service/Klasifikasi/Get-TT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);

        $obj = json_decode($response);
        // dd($obj);

        try{
          
          if($obj->response > 0){
            foreach($obj->result as $key => $data){
              $data->file = null;
              $local = PersonalRegTT::find($data->ID_Registrasi_TK_Trampil);
    
              if($local){
                  $data->file = [
                    "persyaratan_1" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_1,
                    "persyaratan_2" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_2,
                    "persyaratan_3" => env("DOCUMENT_ENDPOINT") . "storage/" . $local->persyaratan_3,
                  ];
              }
            }
          }

          $result = $obj->response > 0 ? $obj->result : [];

        } catch (Exception $err){
          return [];
        }


      return $result;
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

    public function upload(Request $request, $id)
    {
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
          "id_personal"         => $request->query('id_personal'),
          "no_ktp"              => $request->query('No_KTP'),
          "nama"                => $request->query('Nama'),
          "nama_tanpa_gelar"    => $request->query('nama_tanpa_gelar'),
          "alamat"              => $request->query('Alamat1'),
          "kodepos"             => $request->query('Kodepos'),
          "id_kabupaten_alamat" => $request->query('ID_Kabupaten_Alamat'),
          "tgl_lahir"           => $request->query('Tgl_Lahir'),
          "jenis_kelamin"       => $request->query('jenis_kelamin'),
          "tempat_lahir"        => $request->query('Tempat_Lahir'),
          "id_kabupaten_lahir"  => $request->query('ID_Kabupaten_Lahir'),
          "id_propinsi"         => $request->query('ID_Propinsi'),
          "npwp"                => $request->query('npwp'),
          "email"               => $request->query('email'),
          "no_hp"               => $request->query('no_hp'),
          "id_negara"           => $request->query('ID_Negara'),
          "jenis_tenaga_kerja"  => $request->query("Tenaga_Kerja") == "AHLI" ? "tenaga_ahli" : "tenaga_terampil",
          "url_pdf_ktp"                             => $request->query('persyaratan_4'),
          "url_pdf_npwp"                            => $request->query('persyaratan_5'),
          "url_pdf_photo"                           => $request->query('persyaratan_8'),
          "url_pdf_surat_pernyataan_kebenaran_data" => $request->query('persyaratan_11'),
          "url_pdf_daftar_riwayat_hidup"            => $request->query('persyaratan_12')
        ];

        // dd($postData);

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "LPJK-Service/Biodata/Tambah",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        
        if($objResponse = json_decode($response)){
            if($objResponse->message == "Data Biodata Tersebut Sudah Pernah Didaftarkan !"){
                curl_setopt_array($curl, array(
                    CURLOPT_URL            => config("app.lpjk_endpoint") . "LPJK-Service/Biodata/Ubah",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST  => "POST",
                    CURLOPT_POSTFIELDS     => $postData,
                    CURLOPT_HTTPHEADER     => $header,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0
                ));
                $response = curl_exec($curl);
            }
        }
        
        if($obj = json_decode($response)){
            if($obj->response) {
                // $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function uploadPendidikan(Request $request)
    {
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
          "id_personal"          => $request->query('ID_Personal'),
          "nama_sekolah"         => $request->query('Nama_Sekolah'),
          "alamat_sekolah"       => $request->query('Alamat1'),
          "id_propinsi_sekolah"  => $request->query('ID_Propinsi'),
          "id_kabupaten_sekolah" => $request->query('ID_Kabupaten'),
          "id_negara_sekolah"    => $request->query('ID_Countries'),
          "tahun"                => $request->query('Tahun'),
          "jenjang"              => $request->query('Jenjang'),
          "jurusan"              => $request->query('Jurusan'),
          "no_ijazah"            => $request->query('No_Ijazah'),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "LPJK-Service/Pendidikan/Tambah",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                // $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function uploadPengalaman(Request $request)
    {
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
          "id_personal"  => $request->query('id_personal'),
          "nama_proyek"  => $request->query('Proyek'),
          "lokasi"       => $request->query('Lokasi'),
          "tgl_mulai"    => $request->query('Tgl_Mulai'),
          "tgl_selesai"  => $request->query('Tgl_Selesai'),
          "jabatan"      => $request->query('Jabatan'),
          "nilai_proyek" => $request->query('Nilai'),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "LPJK-Service/Proyek/Tambah",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                // $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function uploadOrganisasi(Request $request)
    {
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
          "id_personal"      => $request->query('ID_Personal'),
          "nama_badan_usaha" => $request->query('Nama_Badan_Usaha'),
          "NRBU"             => $request->query('NRBU') == "" || $request->query('NRBU') == " " ? "-" : $request->query('NRBU'),
          "alamat"           => $request->query('Alamat'),
          "jenis_bu"         => $request->query('Jenis_BU'),
          "jabatan"          => $request->query('Jabatan'),
          "tgl_mulai"        => $request->query('Tgl_Mulai'),
          "tgl_selesai"      => $request->query('Tgl_Selesai'),
          "role_pekerjaan"   => $request->query('Role_Pekerjaan'),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "LPJK-Service/Organisasi/Tambah",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                // $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function uploadKursus(Request $request)
    {
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
          "id_personal"               => $request->query('ID_Personal'),
          "nama_penyelenggara_Kursus" => $request->query('Nama_Penyelenggara_Kursus'),
          "alamat"                    => $request->query('Alamat1'),
          "id_kabupaten"              => $request->query('ID_Kabupaten'),
          "id_propinsi"               => $request->query('ID_Propinsi'),
          "id_countries"              => $request->query('ID_Countries'),
          "tahun"                     => $request->query('Tahun'),
          "nama_kursus"               => $request->query('Nama_Kursus'),
          "no_sertifikat"             => $request->query('No_Sertifikat'),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "LPJK-Service/Kursus/Tambah",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                // $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function uploadSKA(Request $request)
    {
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
          "id_personal"         => $request->query('ID_Personal'),
          "id_sub_bidang"       => $request->query('ID_Sub_Bidang'),
          "id_kualifikasi"      => $request->query('ID_Kualifikasi'),
          "id_asosiasi"         => $request->query('ID_Asosiasi_Profesi'),
          "no_reg_asosiasi"     => $request->query('No_Reg_Asosiasi'),
          "id_unit_sertifikasi" => $request->query('id_unit_sertifikasi'),
          "id_permohonan"       => $request->query('id_permohonan'),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "LPJK-Service/Klasifikasi/Tambah-TA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                // $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function uploadSKT(Request $request)
    {
        $key = ApiKey::where('provinsi_id', Auth::user()->asosiasi->provinsi_id)->first();

        $postData = [
          "id_personal"         => $request->query('ID_Personal'),
          "id_sub_bidang"       => $request->query('ID_Sub_Bidang'),
          "id_kualifikasi"      => $request->query('ID_Kualifikasi'),
          "id_asosiasi"         => $request->query('ID_Asosiasi_Profesi'),
          "no_sk"               => $request->query('no_sk') == "" ? "-" : $request->query('no_sk'),
          "no_reg_asosiasi"     => $request->query('No_Reg_Asosiasi'),
          "id_unit_sertifikasi" => $request->query('id_unit_sertifikasi'),
          "id_permohonan"       => $request->query('id_permohonan'),
        ];

        $curl = curl_init();
        $header[] = "X-Api-Key:" . $key->lpjk_key;
        $header[] = "Token:" . $key->token;
        $header[] = "Content-Type:multipart/form-data";
        curl_setopt_array($curl, array(
            CURLOPT_URL            => config("app.lpjk_endpoint") . "LPJK-Service/Klasifikasi/Tambah-TT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));
        $response = curl_exec($curl);
        
        if($obj = json_decode($response)){
            if($obj->response) {
                // $this->ApproveTransaction($request);
                // if($this->createApproveLog($reg))
                return redirect()->back()->with('success', $obj->message);
            }
            return redirect()->back()->with('error', $obj->message);
        }

        return redirect()->back()->with('error', "An error has occurred");
    }

    public function ApproveTransaction($request){
        
        $teamKontribusi = TeamKontribusiTa::where("team_id", $request->query('team'))
        ->where("id_asosiasi_profesi", $request->query('ID_Asosiasi_Profesi'))
        ->where("id_propinsi_reg", $request->query('ID_Propinsi_reg'))
        ->where("id_kualifikasi", $request->query('ID_Kualifikasi'))
        ->first();
        
        $approvalTrx                      = new ApprovalTransaction();
        $approvalTrx->id_asosiasi_profesi = $request->query('ID_Asosiasi_Profesi');
        $approvalTrx->id_propinsi_reg     = $request->query('ID_Propinsi_reg');
        $approvalTrx->team_id             = $request->query('team');
        $approvalTrx->tipe_sertifikat     = "SKA";
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
