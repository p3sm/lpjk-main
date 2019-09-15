@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <a href="{{url()->previous()}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a> 
        Data Riwayat Pendidikan - {{$personal->Nama}}
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url("siki_personal")}}">Personal</a></li>
        <li class="active"><a href="#">Pendidikan</a></li>
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
                        @foreach($personal->pendidikan as $k => $pendidikan)
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
                            <td><a href="{{url("siki_pendidikan") . "/" . $pendidikan->ID_Personal_Pendidikan . "/sync"}}" class="btn btn-warning btn-xs sync"><i class="fa fa-refresh"></i> Sync</a>
                            <span class="btn btn-default btn-xs syncing" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Syncing...</span>
                            <span class="btn btn-success btn-xs sync-success" style="display:none;"><i class="fa fa-check"></i> Success</span>
                            <span class="btn btn-danger btn-xs sync-fail" style="display:none;"><i class="fa fa-times"></i> Fail</span></td>
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
@endsection

@push('script')
<script>
$(function(){
  $('#table-personals').DataTable();

  $('.sync').on("click", function(e){
    e.preventDefault();
    $sync        = $(this);
    $syncing     = $sync.parent().find(".syncing");
    $syncSuccess = $sync.parent().find(".sync-success");
    $syncFail = $sync.parent().find(".sync-fail");

    $url = $(this).attr("href");
    $sync.hide();
    $syncing.show();

    $.get($url, function(data, status){
      $syncing.hide();

      if(data.code == 200){
        $syncSuccess.fadeIn().delay(1000).fadeOut(100, function() {
          $sync.show();
        });
      } else {
        $syncFail.fadeIn().delay(1000).fadeOut(100, function() {
          $sync.show();
        });
      }
    });
  })
});
</script>
@endpush
