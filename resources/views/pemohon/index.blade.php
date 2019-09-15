@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Pemohon
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Pemohon</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
            {{--  table data of car  --}}
            <div class="table-responsive">
                <table id="table-pemohons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>KTP</th>
                            <th>Tanggal Lahir</th>
                            <th>Tempat Lahir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemohons as $k => $pemohon)
                        <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$pemohon->nama}}</td>
                            <td>{{$pemohon->ktp}}</td>
                            <td>{{$pemohon->tanggal_lahir}}</td>
                            <td>{{$pemohon->tempat_lahir}}</td>
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
  $('#table-pemohons').DataTable();
});
</script>
@endpush
