@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users Management
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("users")}}">Users</a></li>
        <li class="active"><a href="#">Create</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-6  col-md-offset-3">

	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title">Create User</h3>
	          </div>
	          <!-- /.box-header -->
            @if(session()->get('error'))
            <div class="alert alert-error">
              {{ session()->get('error') }}  
            </div><br />
            @endif
	          <!-- form start -->
	          <form role="form" method="post" action="{{url("users")}}">
              @csrf
	            <div class="box-body">
	              <div class="form-group">
	                <label for="name">Nama</label>
	                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required>
	              </div>
	              <div class="form-group">
	                <label for="username">Username</label>
	                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
	              </div>
	              <div class="form-group">
	                <label for="password">Password</label>
	                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
	              </div>
	              <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="role_id">
                    @foreach ($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                  </select>
                </div>
				
				<div class="form-group">
                  <label>Asosiasi</label>
                  <select class="form-control" name="asosiasi_id">
										<option value="">-- pilih asosiasi --</option>
                    @foreach ($asosiasi as $as)
                    <option value="{{$as->id_asosiasi}}">{{$as->nama}}</option>
                    @endforeach
                  </select>
                </div>
	              <div class="form-group">
                  <label>Provinsi</label>
                  <select class="form-control" name="provinsi_id">
										<option value="">-- pilih provinsi --</option>
										@foreach ($provinsi as $prov)
											<option value="{{$prov->id_provinsi}}">{{$prov->nama}}</option>
                    @endforeach
                  </select>
                </div>
	              <div class="checkbox">
	                <label>
	                  <input type="checkbox" name="is_active" checked="checked"> Active
	                </label>
	              </div>
	            </div>
	            <!-- /.box-body -->

	            <div class="box-footer">
	              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
	            </div>
	          </form>
	        </div>
	        <!-- /.box -->

	      </div>

	    </div>
    </section>
    <!-- /.content -->
@endsection
