@extends('templates.header')

@section('content')
{{-- {{dd(Storage::url("source"))}} --}}
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        File Manager
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">File Manager</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <iframe frameborder="0" style="border: 0; width: 100%; height: 600" height="600" src="{{url("vendor/filemanager/dialog.php?type=0&fldr=")}}">Your browser doesn't support iFrames.</iframe>

    </section>
    <!-- /.content -->
@endsection
