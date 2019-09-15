@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <a href="{{url()->previous()}}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> kembali</a> 
        Detail Data Personal
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("siki_personal")}}">Personal</a></li>
        <li class="active"><a href="#">{{$personal->id_personal}}</a></li>
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
            <div class="col-md-8">
              <div class="table-responsive">
                  <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <tbody>
                          <tr>
                            <th>KTP</th>
                            <td>{{$personal->No_KTP}}</td>
                          </tr>
                          <tr>
                            <th>Nama</th>
                            <td>{{$personal->Nama}}</td>
                          </tr>
                          <tr>
                            <th>Nama Tanpa Gelar</th>
                            <td>{{$personal->nama_tanpa_gelar}}</td>
                          </tr>
                          <tr>
                            <th>Alamat</th>
                            <td>{{$personal->Alamat1}}</td>
                          </tr>
                          <tr>
                            <th>Kodepos</th>
                            <td>{{$personal->Kodepos}}</td>
                          </tr>
                          <tr>
                            <th>Kabupaten Alamat</th>
                            <td>{{$personal->ID_Kabupaten_Alamat}}</td>
                          </tr>
                          <tr>
                            <th>Provinsi Alamat</th>
                            <td>{{$personal->ID_Propinsi}}</td>
                          </tr>
                          <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{$personal->Tgl_Lahir}}</td>
                          </tr>
                          <tr>
                            <th>Tempat Lahir</th>
                            <td>{{$personal->Tempat_Lahir}}</td>
                          </tr>
                          <tr>
                            <th>Kabupaten Lahir</th>
                            <td>{{$personal->ID_Kabupaten_Lahir}}</td>
                          </tr>
                          <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{$personal->jenis_kelamin}}</td>
                          </tr>
                          <tr>
                            <th>NPWP</th>
                            <td>{{$personal->npwp}}</td>
                          </tr>
                          <tr>
                            <th>Email</th>
                            <td>{{$personal->email}}</td>
                          </tr>
                          <tr>
                            <th>No HP</th>
                            <td>{{$personal->hp_personal}}</td>
                          </tr>
                      </tbody>
                      <tbody>
                      </tbody>
                    
                  </table>
              </div>
            </div>
            <div class="col-md-4">
                <a class="btn btn-success btn-block" href="{{url("siki_personal/".$personal->id_personal."/sync")}}">SYNC TO LPJK</a>
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
