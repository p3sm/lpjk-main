@extends('templates.header')

@section('content')

<style type="text/css">
.box-header .box-title {font-size: 14px; }
.box-header {padding: 8px; font-weight: bold;}
.box {border-top-width: 1px;}
.box{
  border-top-color: #ced4d8!important;
  border: 1px solid #ced4d8;
  margin-bottom: 5px;
}
.modal-dialog {width: 90%; }
</style>
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <a href="{{url("approval_regta")}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a> 
        {{-- Data Registrasi Tenaga Ahli - Tahap {{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}} --}}
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("approval_regta")}}">Biodata</a></li>
        {{-- <li class="active"><a href="#">{{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}}</a></li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          @if(session()->get('success'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button><strong>{{ session()->get('success') }}</strong>
          </div>
          @endif

          @if(session()->get('error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button><strong>{{ session()->get('error') }}</strong>
          </div>
          @endif

          <form action="{{url("biodata")}}" method="post" class="form-inline">
            @csrf

            <div class="box-body">
              <div class="form-group">
                <label for="id_personal">ID Personal</label>
                <input type="text" class="form-control" name="id_personal" id="id_personal" placeholder="Enter ID Personal" value="{{$id_personal}}" required>
                <button type="submit" name="submit" class="btn btn-primary">Search</button>
              </div>
            </div>
          </form>

          {{--  table data  --}}
          <div class="table-responsive" style="">
            <h4>Biodata</h4>
            <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Tgl Lahir</th>
                  <th>Tempat Lahir</th>
                  <th>Tenaga Kerja</th>
                  <th>Asosiasi</th>
                  <th>Email</th>
                  <th>Pernyataan Kebenaran</th>
                  <th>KTP</th>
                  <th>NPWP</th>
                  <th>Riwayat Hidup</th>
                  <th>Photo</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($results as $k => $result)
                    @php
                        $result->Kodepos = $result->Kodepos == "" ? "-" : $result->Kodepos;
                    @endphp
                  <tr>
                    <td>{{$k + 1}}</td>
                    <td>{{$result->id_personal}}</td>
                    <td>{{$result->Nama}}</td>
                    <td>{{$result->Tgl_Lahir}}</td>
                    <td>{{$result->Tempat_Lahir}}</td>
                    <td>{{$result->Tenaga_Kerja}}</td>
                    <td>{{$result->id_Asosiasi}}</td>
                    <td>{{$result->email}}</td>
                    <td><a data-type="iframe" data-fancybox href={{$result->file ? $result->file["persyaratan_4"] : ""}}>View</a></td>
                    <td><a data-type="iframe" data-fancybox href={{$result->file ? $result->file["persyaratan_5"] : ""}}>View</a></td>
                    <td><a data-type="iframe" data-fancybox href={{$result->file ? $result->file["persyaratan_8"] : ""}}>View</a></td>
                    <td><a data-type="iframe" data-fancybox href={{$result->file ? $result->file["persyaratan_11"] : ""}}>View</a></td>
                    <td><a data-type="iframe" data-fancybox href={{$result->file ? $result->file["persyaratan_12"] : ""}}>View</a></td>
                    <td>
                      <a href="{{url("biodata/" . ($result->id_Asosiasi == "" ? "0" : $result->id_Asosiasi) . "/upload") . '?' . http_build_query($result)}}" class="btn btn-primary btn-xs">Upload</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
               
            </table>
          </div>
          <div class="table-responsive">
            <h4>Pendidikan</h4>
            <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>ID</th>
                  <th>Nama Sekolah</th>
                  <th>Alamat</th>
                  <th>Jurusan</th>
                  <th>Tahun</th>
                  <th>No Ijazah</th>
                  <th>Ijazah</th>
                  <th>Keterangan</th>
                  <th>Data Pendidikan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pendidikan as $k => $p)
                <tr>
                  <td>{{$k + 1}}</td>
                  <td>{{$p->ID_Personal_Pendidikan}}</td>
                  <td>{{$p->Nama_Sekolah}}</td>
                  <td>{{$p->Alamat1}}</td>
                  <td>{{$p->Jurusan}}</td>
                  <td>{{$p->Tahun}}</td>
                  <td>{{$p->No_Ijazah}}</td>
                  <td><a data-type="iframe" data-fancybox href={{$p->file ? $p->file["persyaratan_6"] : "#"}}>View</a></td>
                  <td><a data-type="iframe" data-fancybox href={{$p->file ? $p->file["persyaratan_7"] : "#"}}>View</a></td>
                  <td><a data-type="iframe" data-fancybox href={{$p->file ? $p->file["persyaratan_15"] : "#"}}>View</a></td>
                  {{-- <td>{{$p->sync ? $p->sync->updated_at : "-"}}</td> --}}
                  {{-- <td>{{$p->sync ? $p->sync->id : "-"}}</td> --}}
                  <td><a href="{{url("biodata/upload_pendidikan") . '?' . http_build_query($p)}}" class="btn btn-primary btn-xs">Upload</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="table-responsive">
            <h4>Pengalaman</h4>
            <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Proyek</th>
                  <th>Lokasi</th>
                  <th>Jabatan</th>
                  <th>Tanggal</th>
                  <th>Nilai</th>
                  <th>Data Pengalaman</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($proyek as $k => $pr)
                <tr>
                  <td>{{$k + 1}}</td>
                  <td>{{$pr->Proyek}}</td>
                  <td>{{$pr->Lokasi}}</td>
                  <td>{{$pr->Jabatan}}</td>
                  <td>{{\Carbon\Carbon::parse($pr->Tgl_Mulai)->format("d F Y")}} - {{\Carbon\Carbon::parse($pr->Tgl_Selesai)->format("d F Y")}}</td>
                  <td>{{number_format(preg_replace("/\D/","",$pr->Nilai), 0, ",", ".")}}</td>
                  <td><a data-type="iframe" data-fancybox href={{$pr->file ? $pr->file["persyaratan_16"] : "#"}}>View</a></td>
                  {{-- <td>{{$pr->sync ? $pr->sync->updated_at : "-"}}</td> --}}
                  {{-- <td>{{$pr->sync ? $pr->sync->id : "-"}}</td> --}}
                  <td><a href="{{url("biodata/upload_pengalaman") . '?' . http_build_query($pr)}}" class="btn btn-primary btn-xs">Upload</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="table-responsive">
            <h4>Organisasi</h4>
            <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Badan Usaha</th>
                  <th>Alamat</th>
                  <th>Jabatan</th>
                  <th>Role_Pekerjaan</th>
                  <th>Tanggal</th>
                  <th>Data Organisasi</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($organisasi as $k => $org)
                <tr>
                  <td>{{$k + 1}}</td>
                  <td>{{$org->Nama_Badan_Usaha}}</td>
                  <td>{{$org->Alamat}}</td>
                  <td>{{$org->Jabatan}}</td>
                  <td>{{$org->Role_Pekerjaan}}</td>
                  <td>{{\Carbon\Carbon::parse($org->Tgl_Mulai)->format("d F Y")}} - {{\Carbon\Carbon::parse($org->Tgl_Selesai)->format("d F Y")}}</td>
                  <td><a data-type="iframe" data-fancybox href={{$org->file ? $org->file["persyaratan_18"] : "#"}}>View</a></td>
                  <td><a href="{{url("biodata/upload_organisasi") . '?' . http_build_query($org)}}" class="btn btn-primary btn-xs">Upload</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="table-responsive">
            <h4>Kursus</h4>
            <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Penyelenggara</th>
                  <th>Alamat</th>
                  <th>Nama</th>
                  <th>Sertifikat</th>
                  <th>Tahun</th>
                  <th>Data Kursus</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kursus as $k => $kur)
                <tr>
                  <td>{{$k + 1}}</td>
                  <td>{{$kur->Nama_Penyelenggara_Kursus}}</td>
                  <td>{{$kur->Alamat1}}</td>
                  <td>{{$kur->Nama_Kursus}}</td>
                  <td>{{$kur->No_Sertifikat}}</td>
                  <td>{{$kur->Tahun}}</td>
                  <td><a data-type="iframe" data-fancybox href={{$kur->file ? $kur->file["persyaratan_17"] : "#"}}>View</a></td>
                  <td><a href="{{url("biodata/upload_kursus") . '?' . http_build_query($kur)}}" class="btn btn-primary btn-xs">Upload</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="table-responsive" style="">
            <h4>REG TA</h4>
            <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Sub Bidang</th>
                  <th>Asosiasi</th>
                  <th>Kualifikasi</th>
                  <th>Provinsi</th>
                  <th>USTK</th>
                  <th>Tgl Registrasi</th>
                  <th>Status</th>
                  <th>VVA</th>
                  <th>Permohonan</th>
                  <th>Permohonan Asosiasi</th>
                  <th>Penilaian Mandiri</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($klasifikasiTA as $k => $regta)
                <tr>
                  <td>{{$k + 1}}</td>
                  <td>{{$regta->ID_Sub_Bidang}}</td>
                  <td>{{$regta->ID_Asosiasi_Profesi}}</td>
                  <td>{{$regta->ID_Kualifikasi}}</td>
                  <td>{{$regta->ID_Propinsi_reg}}</td>
                  <td>{{$regta->id_unit_sertifikasi}}</td>
                  <td>{{$regta->Tgl_Registrasi}}</td>
                  <td>{{$regta->status_terbaru}}</td>
                  <td><a data-type="iframe" data-fancybox href={{$regta->file ? $regta->file["persyaratan_1"] : "#"}}>View</a></td>
                  <td><a data-type="iframe" data-fancybox href={{$regta->file ? $regta->file["persyaratan_2"] : "#"}}>View</a></td>
                  <td><a data-type="iframe" data-fancybox href={{$regta->file ? $regta->file["persyaratan_3"] : "#"}}>View</a></td>
                  <td><a data-type="iframe" data-fancybox href={{$regta->file ? $regta->file["persyaratan_13"] : "#"}}>View</a></td>
                  <td><a href="{{url("biodata/upload_ska") . '?' . http_build_query($regta)}}" class="btn btn-primary btn-xs">Upload</a></td>
                  {{-- <td>{{$regta->sync ? $regta->sync->updated_at{{--  : "-"}}</td>
                  <td>{{$regta->sync ? $regta->sync->sync_id : "-"}}</td> --}}
                {{-- <td> --}}
                  {{-- <a href="{{url("siki_personal")."/".$regta->ID_Personal."/plain?ty=ta&th=".$regta->tahap}}" target="_blank" class="btn btn-success btn-xs">Lihat Data</a> --}}
                  {{-- <a href="#" data-url="{{url("siki_personal")."/".$regta->ID_Personal."/plain"}}" class="btn btn-success btn-xs viewDetail">Lihat Data</a> --}}
                 {{--  <a href="{{url("siki_regta/".$regta->ID_Registrasi_TK_Ahli."/sync")}}" class="btn btn-warning btn-xs">{{$regta->sync ? "Sync Ulang" : "Sync"}}</a> --}}
                  {{-- @if($regta->sync)
                    <a href="{{url("siki_regta/".$regta->ID_Registrasi_TK_Ahli."/approve")}}" class="btn btn-primary btn-xs">Approve</a>
                  @endif --}}
                {{-- </td> --}}
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{--  end of data  --}}
          <div class="table-responsive" style="">
            <h4>REG TT</h4>
            <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Sub Bidang</th>
                  <th>Asosiasi</th>
                  <th>Kualifikasi</th>
                  <th>Provinsi</th>
                  <th>USTK</th>
                  <th>Tgl Registrasi</th>
                  <th>Status</th>
                  <th>VVA</th>
                  <th>Permohonan</th>
                  <th>Permohonan Asosiasi</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($klasifikasiTT as $k => $regtt)
                <tr>
                  <td>{{$k + 1}}</td>
                  <td>{{$regtt->ID_Sub_Bidang}}</td>
                  <td>{{$regtt->ID_Asosiasi_Profesi}}</td>
                  <td>{{$regtt->ID_Kualifikasi}}</td>
                  <td>{{$regtt->ID_propinsi_reg}}</td>
                  <td>{{$regtt->id_unit_sertifikasi}}</td>
                  <td>{{$regtt->Tgl_Registrasi}}</td>
                  <td>{{$regtt->status_terbaru}}</td>
                  <td><a data-type="iframe" data-fancybox href={{$regtt->file ? $regtt->file["persyaratan_1"] : "#"}}>View</a></td>
                  <td><a data-type="iframe" data-fancybox href={{$regtt->file ? $regtt->file["persyaratan_2"] : "#"}}>View</a></td>
                  <td><a data-type="iframe" data-fancybox href={{$regtt->file ? $regtt->file["persyaratan_3"] : "#"}}>View</a></td>
                  <td><a href="{{url("biodata/upload_skt") . '?' . http_build_query($regtt)}}" class="btn btn-primary btn-xs">Upload</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{--  end of data  --}}

        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
