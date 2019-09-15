@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users Management
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Users</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">User Lists</h3>
        </div>
        <div class="box-body">
            @if(session()->get('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}  
            </div><br />
            @endif
            {{--  sub menu  --}}
            <div style="margin-bottom: 20px">
                 <a href="{{url('users/create')}}" class="btn bg-olive"><span>Add User</span></a>
            </div>
            {{--  end of sub menu  --}}

            {{--  table data of user  --}}
            <div>
                <table id="table-user" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Date added</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   <tbody>
                       
                   </tbody>
                </table>
            </div>
            {{--  end of user data  --}}
            

            <!-- modal konfirmasi -->
   
            <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                    </div>
                    <div class="modal-body" id="konfirmasi-body">
                        test
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-id="" id="btn-hapus">Yes</button>
                    </div>
                    </div>
                </div>
                </div>
            <!-- end of modal konfirmais -->
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
var apiUrl = "{{ url('api/v1') }}/";

function initialized(){
    let body = "";
    $.get(apiUrl+"users", function(response){
        let data1 = response.data1;
        let i = 1;
        $.each(data1, function(index, data){
            body += "<tr>";
            body += "<td>"+i+"</td>";
            body += "<td>"+data.name+"</td>";
            body += "<td>"+data.username+"</td>";
            body += `<td> `+ (
                data.role_id == 1 ? "Admin" : 
                data.role_id == 2 ? "Input Pusat" : 
                data.role_id == 3 ? "Input Provinsi" : 
                data.role_id == 4 ? "Approve" : 
                "-") +` </td>`;
            body += "<td>"+data.created_at.substring(0, 10)+"</td>";
            body += "<td><input type='checkbox' "+ (data.is_active == 1 ? "checked" : "") +"></td>";
            body += `<td><a href='{{url('users')}}/`+data.id+`/edit' class='btn btn-xs btn-warning'><span class='glyphicon glyphicon-pencil'></span></a>

            <button class='btn btn-xs btn-danger' onclick='deleteUser(true, "`+data.id+`", "`+data.name+`")'><span class='glyphicon glyphicon-trash'></span></button></td>`;
            body += "</tr>";
            i++;
        });

        $("#table-user tbody").append(body);
        $("#table-user").DataTable();
    })
}

function deleteUser(type, id, $name){
    let text = "";
    $("#modal-konfirmasi").modal('show');
    if(type)
        text = "Delete Data User " + name;
    else
        text = "Delete Data Driver " + name;

    $("#modal-konfirmasi").find("#btn-hapus").data("id", id);
    $("#konfirmasi-body").text(text);
}

$(function(){
    initialized();

    $('#btn-hapus').click(function(){
        var id = $(this).data("id");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax(
        {
            url: "users/"+id,
            type: 'delete', // replaced from put
            dataType: "JSON",
            data: {
                "id": id // method and token not needed in data
            },
            success: function (response)
            {
                location.reload();
            },
            error: function(xhr) {
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
            // do something here because of error
        }
        });
    });
});
</script>
@endpush
