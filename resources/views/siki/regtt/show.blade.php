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
        <a href="{{url("siki_regtt")}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a> 
        Data Registrasi Tenaga Trampil - Tahap {{count($regtts) > 0 ? $regtts[0]->tahap1 : "-"}}
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("siki_regtt")}}">Reg TT</a></li>
        <li class="active"><a href="#">{{count($regtts) > 0 ? $regtts[0]->tahap1 : "-"}}</a></li>
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
                        @foreach($regtts as $k => $regtt)
                        <tr>
                          <td>{{$k + 1}}</td>
                          <td>{{$regtt->personal->Nama}}</td>
                          <td>{{$regtt->ID_Asosiasi_Profesi}}</td>
                          <td>{{$regtt->ID_Sub_Bidang}}</td>
                          <td>{{$regtt->kualifikasi->Deskripsi_trampil}}</td>
                          <td>{{$regtt->ID_propinsi_reg}}</td>
                          <td>{{$regtt->id_unit_sertifikasi}}</td>
                          <td>{{$regtt->id_user}}</td>
                          <td>{{$regtt->tahap1}}</td>
                          <td>{{$regtt->tgl_thp}}</td>
                          <td>{{$regtt->jam_thp}}</td>
                          <td>{{$regtt->sync ? $regtt->sync->updated_at : "-"}}</td>
                          <td>{{$regtt->sync ? $regtt->sync->id : "-"}}</td>
                        <td>
                          <a href="{{url("siki_personal")."/".$regtt->ID_Personal."/plain?ty=tt&th=".$regtt->tahap}}" target="_blank" class="btn btn-success btn-xs">Lihat Data</a>
                          {{-- <a href="#" data-url="{{url("siki_personal")."/".$regtt->ID_Personal."/plain"}}" class="btn btn-success btn-xs viewDetail">Lihat Data</a> --}}
                          <a href="{{url("siki_regtt/".$regtt->ID_Registrasi_TK_Trampil."/sync")}}" class="btn btn-warning btn-xs">Sync</a>
                          {{-- @if($regtt->sync)
                            <a href="{{url("siki_regtt/".$regtt->ID_Registrasi_TK_Trampil."/approve")}}" class="btn btn-primary btn-xs">Approve</a>
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
