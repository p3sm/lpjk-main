@extends('templates/header')

@section('content')
	<section class="content-header">
	  <h1>
	    Beranda
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	  </ol>
	</section>
	<section class="content">
		<div class="row">
			<!-- Left col -->
			<div class="col-md-8">
			  <div class="box box-success">
			    <div class="box-header with-border">
			      <h3 class="box-title">Pemohon Terbaru</h3>

			      <div class="box-tools pull-right">
			        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			        </button>
			        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			      </div>
			    </div>
			    <!-- /.box-header -->
			    <div class="box-body">
			      <div class="table-responsive">
			        <table class="table no-margin">
			          <thead>
			          <tr>
			            <th>No</th>
			            <th>Nama</th>
			            <th>KTP</th>
			          </tr>
			          </thead>
			          <tbody>
			          @foreach($pemohons as $k => $pemohon)
			          <tr>
			            <td>{{$k + 1}}</td>
			            <td>{{$pemohon->nama}}</td>
			            <td>{{$pemohon->ktp}}</td>
			          </tr>
			          @endforeach
			          </tbody>
			        </table>
			      </div>
			      <!-- /.table-responsive -->
			    </div>
			    <!-- /.box-body -->
			    <div class="box-footer clearfix">
			      <a href="{{url("pemohon")}}" class="btn btn-sm btn-warning btn-flat pull-right">Lihat semua pemohon</a>
			    </div>
			    <!-- /.box-footer -->
			  </div>
			</div>
			<!-- /.col -->
		</div>
	</section>
@endsection