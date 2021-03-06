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
      <h1>VVA</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("pengajuan_naik_status")}}">Proses VVA SKT</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          <form method="get" style="margin-bottom: 20px" action="" class="form-inline float-right">
            <label class="" for="inlineFormCustomSelectPref">filter: </label>
            <div class="input-group input-daterange">
              <input type="text" name="from" class="form-control input-sm" value="{{$from->format("d/m/Y")}}">
              <div class="input-group-addon">to</div>
              <input type="text" name="to" class="form-control input-sm" value="{{$to->format("d/m/Y")}}">
            </div>
            <select name="as" class="form-control input-sm">
              <option value="">-- Pilih Asosiasi --</option>
              @foreach ($asosiasi as $data)
                <option value="{{$data->id_asosiasi}}" {{$as == $data->id_asosiasi ? "selected" : ""}}>{{$data->id_asosiasi}} - {{$data->nama}}</option>
              @endforeach
            </select>
            <select name="us" class="form-control input-sm">
              <option value="">-- Pilih USTK --</option>
              @foreach ($ustk as $data)
                <option value="{{$data->id_unit_sertifikasi}}" {{$us == $data->id_unit_sertifikasi ? "selected" : ""}}>{{$data->nama}}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm my-1">Apply</button>
          </form>

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

          {{--  table data  --}}
          <div class="table-responsive" style="">
            <h4>Kirim VVA SKT</h4>
            <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Klasifikasi</th>
                  <th>Kualifikasi</th>
                  <th>Asosiasi</th>
                  <th>USTK</th>
                  <th>Tanggal Permohonan</th>
                  <th>Tanggal Pengajuan</th>
                  <th>Di Ajukan oleh</th>
                  <th>Dokumen</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pengajuan as $k => $result)
                  <tr>
                    <td>{{$k + 1}}</td>
                    <td>{{$result->id_personal}}</td>
                    <td>{{$result->nama}}</td>
                    <td>{{$result->sub_bidang}}</td>
                    <td>{{$result->kualifikasi}}</td>
                    <td>{{$result->asosiasi}}</td>
                    <td>{{$result->ustk}}</td>
                    <td>{{\Carbon\Carbon::createFromFormat('Y-m-d', $result->date)->format("d-m-Y")}}</td>
                    <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result->created_at, 'UTC')->setTimezone('Asia/Jakarta')->format("d-m-Y H:i:s")}}</td>
                    <td>{{$result->createdBy->name}}</td>
                    <td><a class="fancybox" href="javascript:;" data-src={{"/pdf?src=document&data=" . \Illuminate\Support\Facades\Crypt::encryptString("2." . $result->id  . "." . $result->id_personal . "." . $result->asosiasi . "." . date('Y-m-d', strtotime($result->date)))}}>View</a></td>
                    <td>
                      <a href="{{url("biodata/" . $result->id_personal)}}" class="btn btn-primary btn-xs">Cari</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
               
            </table>
          </div>

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
  $('.input-daterange').datepicker({format: 'dd/mm/yyyy'});
  $(".fancybox").fancybox({
    // "iframe" : {
		//   "preload" : false
	  // },
    // 'width': 600,
    // 'height': 250,
    // 'transitionIn': 'elastic', // this option is for v1.3.4
    // 'transitionOut': 'elastic', // this option is for v1.3.4
    // if using v2.x AND set class fancybox.iframe, you may not need this
    'type': 'iframe',
    // 'autoSize': false,
    // if you want your iframe always will be 600x250 regardless the viewport size
    // 'fitToView' : false  // use autoScale for v1.3.4
  });
});
</script>
@endpush

<style>
  /* .fancybox-content {
    width: 900px!important;
    padding: 20px!important;
  }
  .fancybox-iframe {
    padding: 40px!important;
  } */
</style>
