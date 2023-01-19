@extends('Layout.app')
@section('title','User role')
@section('content')

<div id="main-div-role"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="add-role-btn" class="btn my-3 btn-sm btn-danger">Add Role </button>
            <table id="role-data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Role Name</th>
                        <th class="th-sm">Status</th>
                        <th class="th-sm">Created at</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="role-table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- loader div -->
<div id="loader-div-role" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
        </div>
    </div>
</div>

<!-- Something Went Wrong ! -->
<div id="wrong-div-role" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <h3>Something Went Wrong !</h3>
        </div>
    </div>
</div>

<!-- Role add modal -->
<div class="modal fade" id="add-role-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="role_name" type="text" class="form-control mb-3" placeholder="Role Name">
                            <select id="status" name="rolelist" form="roleform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="role-add-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Role Edit Modal -->

<div class="modal fade" id="update-role-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <h5 id="role-edit-id" class="mt-4 d-none">  </h5>
                <div id="role-edit-form" class="container d-none">
                    <div class="row">
                        <input id="role_name_update" type="text" class="form-control mb-3" placeholder="Role Name">
                        <select id="status_update_change" name="rolelist" form="roleform" style="display:block!important;width:100%;margin-bottom:1rem;">
                            <option id="status-update" value=""></option>
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                        <img id="role-edit-loader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
                        <h5 id="role-edit-wrong" class="d-none">Something Went Wrong !</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="role-update-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Role Data Deleted -->

<div class="modal fade" id="delete-role-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-3 text-center">
        <h5 class="mt-4">Do You Want To Delete?</h5>
        <h5 id="role-delete-id" class="mt-4 d-none">   </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
        <button  id="role-delete-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
// User role data load 
getRoleData();

function getRoleData() {
    axios.get('/user_role?json')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-role').removeClass('d-none');
                $('#loader-div-role').addClass('d-none');
                $('#role-data-table').DataTable().destroy();
                $('#role-table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>" + item.name + "</td>" +
                        "<td>" + item.status + "</td>" +
                        "<td>" + item.created_at.substring(0, 10) + "</td>" +
                        "<td><a class='role_edit_btn' data-id="+jsonData[i].id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='role_delete_btn' data-id="+jsonData[i].id+"><i class='fas fa-trash-alt'></i></a></td>"
                    ).appendTo('#role-table');
                    
                }); 
                $('.role_edit_btn').click(function(){
                    var id= $(this).data('id');
                    RoleUpdateDetails(id);
                    $('#role-edit-id').html(id);
                    $('#update-role-modal').modal('show');
                })
                $('.role_delete_btn').click(function(){
                    var id= $(this).data('id');
                    $('#role-delete-id').html(id);
                    $('#delete-role-modal').modal('show');
                })
  
                $('#role-data-table').DataTable({"order":false});
                $('.dataTables_length').addClass('bs-select'); 
            } else {
                $('#loader-div-role').addClass('d-none');
                $('#wrong-div-role').removeClass('d-none'); 
            }
            })
            .catch(function(error) {
                $('#loader-div-role').addClass('d-none');
                $('#wrong-div-role').removeClass('d-none');
            });  
  }
// Role add modal open
$('#add-role-btn').click(function(){
    $('#add-role-modal').modal('show');
});
// Role add function
$('#role-add-confirm-btn').click(function(){
    var role_name = $('#role_name').val();
    var status = $('#status').val();
    RoleAdd ( role_name, status );
});
function RoleAdd ( role_name, status ) {
    if ( role_name.length == 0 ) {
    toastr.error('Role Name is Empty !');
  } else if ( status.length == 0 ){
    toastr.error('Select status !');
  } else {
    $('#role-add-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/role/add', {
            name: role_name,
            status: status,                               
        })
        .then(function(response) {
            $('#role-add-confirm-btn').html("Save");
            if ( response.status == 200 ) {
                if (response.data == 1) {
                    $('#add-role-modal').modal('hide');
                    toastr.success('Add Success');
                    $('#role_name').val('');
                    $('#status').val('');
                } else {
                    $('#add-role-modal').modal('hide');
                    toastr.error('Add Fail');
                    $('#RoleName').val('');
                    $('#Status').val('');
                }
                getRoleData();  
            } else {
                $('#add-role-modal').modal('hide');
                toastr.error('Something Went Wrong !');
            }   
        })
        .catch(function(error) {
            $('#add-role-modal').modal('hide');
            toastr.error('Something Went Wrong !');
        });
    }
}
// Role Edit Data
function RoleUpdateDetails(detailsID){
    axios.post('/role/getDetails', {
        id: detailsID
    })
    .then(function(response) {
        if (response.status == 200) {
            $('#role-edit-form').removeClass('d-none');
            $('#role-edit-loader').addClass('d-none');    
            var jsonData = response.data;
            $('#role_name_update').val(jsonData.name);
            $('#status-update').val(jsonData.status);
            $('#status-update').html(jsonData.status);
        } else {
            $('#role-edit-loader').addClass('d-none');
            $('#role-edit-wrong').removeClass('d-none');
        }
    })
    .catch(function(error) {
        $('#role-edit-loader').addClass('d-none');
        $('#role-edit-wrong').removeClass('d-none');
    });
}
// Role Data Updated
$('#role-update-confirm-btn').click(function(){
    var role_id = $('#role-edit-id').html();
    var role_name = $('#role_name_update').val();
    var role_status = $('#status_update_change').val();
    RoleUpdate(role_id, role_name, role_status);
});
function RoleUpdate ( role_id, role_name, role_status ) {
    if ( role_name.length == 0 ){
        toastr.error('Role Title is Empty !');
    } else if ( role_status.length == 0 ) {
    toastr.error('Task Status is Empty !');
    } else {
        $('#role-update-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/role/update', {
            id: role_id,
            name: role_name,
            status: role_status,
        })
        .then(function(response) {
            $('#role-update-confirm-btn').html("Update");
            if(response.status == 200){
                if (response.data == 1) {
                    $('#update-role-modal').modal('hide');
                    toastr.success('Update Success');
                    $('#role_name_update').val('');
                    $('#status-update').val('');
                    $('#status-update').html('');
                } else {
                    $('#update-role-modal').modal('hide');
                    toastr.error('Update Fail');
                }
                getRoleData();
            } else {
                $('#update-role-modal').modal('hide');
                toastr.error('Something Went Wrong !');
            }   
        })
        .catch(function(error) {
            $('#update-role-modal').modal('hide');
            toastr.error('Something Went Wrong !');
        });
    }
}

// Role Data Deleted
$('#role-delete-confirm-btn').click(function(){
    var id= $('#role-delete-id').html();
    RoleDelete(id);
});
function RoleDelete(deleteID) {
    $('#role-delete-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/task/delete', {
        id: deleteID
    })
    .then(function(response) {
        $('#role-delete-confirm-btn').html("Yes");
        if(response.status==200){
            if (response.data == 1) {
                $('#delete-role-modal').modal('hide');
                toastr.success('Delete Success');
            } else {
                $('#delete-role-modal').modal('hide');
                toastr.error('Delete Fail');
                getTaskData();
            }
        } else {
            $('#role-delete-confirm-btn').html("Yes");
            $('#delete-role-modal').modal('hide');
            toastr.error('Something Went Wrong !');
        }
    })
    .catch(function(error) {
        $('#role-delete-confirm-btn').html("Yes");
        $('#delete-role-modal').modal('hide');
        toastr.error('Something Went Wrong !');
    });
}
</script>
@endsection