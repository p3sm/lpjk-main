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
        <a href="{{url("siki_regta")}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a> 
        Data Registrasi Tenaga Ahli - Tahap {{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}}
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("siki_regta")}}">Reg TA</a></li>
        <li class="active"><a href="#">{{count($regtas) > 0 ? $regtas[0]->tahap1 : "-"}}</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          @if(session()->get('success'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>   
                  <strong>{{ session()->get('success') }}</strong>
          </div>
          @endif

          @if(session()->get('error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>   
                  <strong>{{ session()->get('error') }}</strong>
          </div>
          @endif

          {{-- @foreach($regtas as $k => $regta)
          <div class="box box-primary collapsed-box">
            <div class="box-header with-border row">
              <span class="col-md-2">
                {{$k+1}}. {{$regta->personal->Nama}}
              </span>
              <span class="col-md-4">
                {{$regta->ID_Sub_Bidang}}
              </span>
              <div class="box-tools col-md-2" style="text-align: right;">
                <span class="">Tanggal Tahap: {{$regta->jam_thp}} | {{$regta->tgl_thp}}</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: none;">
              <div class="table-responsive">
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
                          <th>Last Sync Date</th>
                          <th>Synced ID</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($regta->personal->pendidikan as $k => $pendidikan)
                      <tr>
                          <td>{{$k + 1}}</td>
                          <td>{{$pendidikan->ID_Personal_Pendidikan}}</td>
                          <td>{{$pendidikan->Nama_Sekolah}}</td>
                          <td>{{$pendidikan->Alamat1}}</td>
                          <td>{{$pendidikan->Jurusan}}</td>
                          <td>{{$pendidikan->Tahun}}</td>
                          <td>{{$pendidikan->No_Ijazah}}</td>
                          <td>{{$pendidikan->sync ? $pendidikan->sync->updated_at : "-"}}</td>
                          <td>{{$pendidikan->sync ? $pendidikan->sync->id : "-"}}</td>
                          <td><a href="{{url("siki_pendidikan") . "/" . $pendidikan->ID_Personal_Pendidikan . "/sync"}}" class="btn btn-warning btn-xs">Sync</a></td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
              <div class="table-responsive">
                <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Proyek</th>
                      <th>Lokasi</th>
                      <th>Jabatan</th>
                      <th>Tanggal</th>
                      <th>Nilai</th>
                      <th>Last Sync Date</th>
                      <th>Synced ID</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($regta->personal->proyek as $k => $proyek)
                    <tr>
                      <td>{{$k + 1}}</td>
                      <td>{{$proyek->Proyek}}</td>
                      <td>{{$proyek->Lokasi}}</td>
                      <td>{{$proyek->Jabatan}}</td>
                      <td>{{\Carbon\Carbon::parse($proyek->Tgl_Mulai)->format("d F Y")}} - {{\Carbon\Carbon::parse($proyek->Tgl_Selesai)->format("d F Y")}}</td>
                      <td>{{number_format($proyek->Nilai, 0, ",", ".")}}</td>
                      <td>{{$proyek->sync ? $proyek->sync->updated_at : "-"}}</td>
                      <td>{{$proyek->sync ? $proyek->sync->id : "-"}}</td>
                      <td><a href="{{url("siki_proyek") . "/" . $proyek->id_personal_proyek . "/sync"}}" class="btn btn-warning btn-xs">Sync</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
          </div>
          @endforeach --}}
            {{--  table data of car  --}}
            <div class="table-responsive" style="">
                <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Asosiasi</th>
                            <th>Sub Bidang</th>
                            <th>Kualifikasi</th>
                            <th>Provinsi</th>
                            <th>USTK</th>
                            <th>Admin</th>
                            <th>No Tahap</th>
                            <th>Tgl Tahap</th>
                            <th>Jam Tahap</th>
                            <th>Last Sync Date</th>
                            <th>Synced ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($regtas as $k => $regta)
                        <tr>
                          <td>{{$k + 1}}</td>
                          <td>{{$regta->personal->Nama}}</td>
                          <td>{{$regta->ID_Asosiasi_Profesi}}</td>
                          <td>{{$regta->ID_Sub_Bidang}}</td>
                          <td>{{$regta->kualifikasi->Deskripsi_ahli}}</td>
                          <td>{{$regta->ID_Propinsi_reg}}</td>
                          <td>{{$regta->id_unit_sertifikasi}}</td>
                          <td>{{$regta->id_user}}</td>
                          <td>{{$regta->tahap1}}</td>
                          <td>{{$regta->tgl_thp}}</td>
                          <td>{{$regta->jam_thp}}</td>
                          <td>{{$regta->sync ? $regta->sync->updated_at : "-"}}</td>
                          <td>{{$regta->sync ? $regta->sync->sync_id : "-"}}</td>
                        <td>
                          <a href="{{url("siki_personal")."/".$regta->ID_Personal."/plain?ty=ta&th=".$regta->tahap}}" target="_blank" class="btn btn-success btn-xs">Lihat Data</a>
                          {{-- <a href="#" data-url="{{url("siki_personal")."/".$regta->ID_Personal."/plain"}}" class="btn btn-success btn-xs viewDetail">Lihat Data</a> --}}
                          <a href="{{url("siki_regta/".$regta->ID_Registrasi_TK_Ahli."/sync")}}" class="btn btn-warning btn-xs">{{$regta->sync ? "Sync Ulang" : "Sync"}}</a>
                          {{-- @if($regta->sync)
                            <a href="{{url("siki_regta/".$regta->ID_Registrasi_TK_Ahli."/approve")}}" class="btn btn-primary btn-xs">Approve</a>
                          @endif --}}
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            {{--  end of car data  --}}

        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
    <div id="myModal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Data</h4>
                  </div>
                  <div class="modal-body">
                      <p>Mohon Tunggu...</p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
          </div>
      </div>
    </div>
@endsection

@push('script')
<script>
$(function(){
  $('#table-personals').DataTable();

  $('.viewDetail').on('click', function(e){
    $('#myModal').find('.modal-body').html("<p>Mohon Tunggu...</p>");
    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).data('url'));
  });
});
</script>
@endpush
