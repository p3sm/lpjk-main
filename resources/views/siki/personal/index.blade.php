@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Personal
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Personal</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
            {{--  table data of car  --}}
            <div class="table-responsive">
                <table id="table-personals" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>KTP</th>
                            <th>Tanggal Lahir</th>
                            <th>Tempat Lahir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($personals as $k => $personal)
                        <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$personal->Nama}}</td>
                            <td>{{$personal->No_KTP}}</td>
                            <td>{{$personal->Tgl_Lahir}}</td>
                            <td>{{$personal->Tempat_Lahir}}</td>
                        <td>
                            <a href="{{url("siki_personal")."/".$personal->id_personal."/pendidikan"}}" class="btn btn-info btn-xs">Pendidikan</a>
                            <a href="{{url("siki_personal")."/".$personal->id_personal."/proyek"}}" class="btn btn-primary btn-xs">Pengalaman</a>
                          <a href="{{url("siki_personal")."/".$personal->id_personal}}" class="btn btn-success btn-xs">View</a>
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
@endsection

@push('script')
<script>
$(function(){
  $('#table-personals').DataTable();
});
</script>
@endpush
