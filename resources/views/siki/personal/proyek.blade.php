@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <a href="{{url()->previous()}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a> 
        Data Pengalaman Proyek - {{$personal->Nama}}
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{url("siki_personal")}}">Personal</a></li>
        <li class="active"><a href="#">Pengalaman</a></li>
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
                        @foreach($personal->proyek as $k => $proyek)
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
});
</script>
@endpush
