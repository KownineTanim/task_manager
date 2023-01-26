@extends('Layout.app')
@section('title','User')
@section('content')

<div id="main-div-user"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="add-user-btn" class="btn my-3 btn-sm btn-danger">Add User</button>
            <table id="user-data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">User Name</th>
                        <th class="th-sm">Mail Id</th>
                        <th class="th-sm">User Role</th>
                        <th class="th-sm">Created at</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="user-table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- loader div -->
<div id="loader-div-user" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
        </div>
    </div>
</div>

<!-- Something Went Wrong ! -->
<div id="wrong-div-user" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <h3>Something Went Wrong !</h3>
        </div>
    </div>
</div>

<!-- User add modal -->
<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="user_name" type="text" class="form-control mb-3" placeholder="User Name">
                            <input id="user_mail" type="text" class="form-control mb-3" placeholder="User Email">
                            <input id="user_pass" type="password"  class="form-control mb-3" placeholder="User Password">
                            <input id="confirm_pass" type="password"  class="form-control mb-3" placeholder="Re-type Password">
                            <select id="user_role" name="rolelist" form="roleform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Select Role</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="user-add-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Edit Modal -->

<div class="modal fade" id="update-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <h5 id="user-edit-id" class="mt-4 d-none">  </h5>
                <div id="user-edit-form" class="container d-none">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="user_name_update" type="text" class="form-control mb-3" placeholder="User Name">
                            <input id="user_mail_update" type="text"  class="form-control mb-3" placeholder="User Email">
                            <select id="user_role_update-change" name="rolelist" form="roleform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option id="user_role_update" value=""></option>
                                <option value="">Select Role</option>
                            </select>
                        </div>
                    </div>
                        <img id="user-edit-loader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
                        <h5 id="user-edit-wrong" class="d-none">Something Went Wrong !</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="user-update-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Data Deleted -->

<div class="modal fade" id="delete-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-3 text-center">
        <h5 class="mt-4">Do You Want To Delete?</h5>
        <h5 id="user-delete-id" class="mt-4 d-none">   </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
        <button  id="user-delete-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>



@endsection

@section('script')
<script type="text/javascript">
// User model data loaded here
getUserData();
function getUserData() {
    axios.get('/user?json')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-user').removeClass('d-none');
                $('#loader-div-user').addClass('d-none');
                $('#user-data-table').DataTable().destroy();
                $('#user-table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>" + item.name + "</td>" +
                        "<td>" + item.email + "</td>" +
                        "<td>" + item['role'].name + "</td>" +
                        "<td>" + item.created_at.substring(0, 10)  + "</td>" +
                        "<td><a class='user-edit-btn' data-id="+item.id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='user-delete-btn' data-id="+item.id+"><i class='fas fa-trash-alt'></i></a></td>"
                    ).appendTo('#user-table')
                }); 
                $('.user-edit-btn').click(function(){
                    var id= $(this).data('id');
                    UserUpdateDetails(id);
                    $('#user-edit-id').html(id);
                    $('#update-user-modal').modal('show');
                })
                $('.user-delete-btn').click(function(){
                    var id= $(this).data('id');
                    $('#user-delete-id').html(id);
                    $('#delete-user-modal').modal('show');
                })
                $('#user-data-table').DataTable({"order":false});
                $('.dataTables_length').addClass('bs-select'); 
            } else {
                $('#loader-div-user').addClass('d-none');
                $('#wrong-div-user').removeClass('d-none'); 
            }
        })
        .catch(function(error) {  
            $('#loader-div-user').addClass('d-none');
            $('#wrong-div-user').removeClass('d-none');
        });  
} 
// Role list load function
$('#user_role').on('click', function () { 
    RoleList();
});
function RoleList() {
    axios.get('/role-list')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-user').removeClass('d-none');
                $('#loader-div-user').addClass('d-none');
                var jsonData = response.data;
                $.each(jsonData, function (i, item) {
                    $('#user_role').append($('<option>', { 
                        value: item.id ,
                        text : item.name 
                    }));
                });
            } else {  
                $('#loader-div-user').addClass('d-none');
                $('#wrong-div-user').removeClass('d-none'); 
            }
        })
        .catch(function(error) {
            $('#loaderDiv').addClass('d-none');
            $('#WrongDiv').removeClass('d-none');   
        });
}
// User add modal open
$('#add-user-btn').click(function(){
    $('#add-user-modal').modal('show');
});
// User add function
$('#user-add-confirm-btn').click(function(){
    var UserName = $('#user_name').val();
    var UserMail = $('#user_mail').val();
    var UserPassword = $('#user_pass').val();
    var ConfirmPassword = $('#confirm_pass').val();
    var UserRole = $('#user_role').val();
    UserAdd ( UserName, UserMail, UserPassword, ConfirmPassword, UserRole);
});
function UserAdd ( UserName, UserMail, UserPassword, ConfirmPassword, UserRole ) {
    if( UserName.length == 0 ) {
    toastr.error('User Name is Empty !');
    } else if ( UserMail.length == 0 ) {
    toastr.error('User Mail is Empty !');
    } else if ( UserPassword.length == 0 ) {
    toastr.error('User password is Empty !');
    } else if ( ConfirmPassword.length == 0 ) {
    toastr.error('Confirm password is Empty !');
    } else if ( UserPassword !== ConfirmPassword ) {
    toastr.error('Enter Same Password!');
    } else if ( UserRole.length == 0 ) {
    toastr.error('User Role is Empty !');
    } else {
    $('#user-add-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/user/add', {
            name: UserName,
            email: UserMail,
            password: UserPassword,
            role_id: UserRole,                                 
        })
        .then(function(response) {
            $('#user-add-confirm-btn').html("Save");
            if ( response.status == 200 ) {
                if (response.data == 1) {
                    $('#add-user-modal').modal('hide');
                    toastr.success('Add Success');
                    $('#user_name').val('');
                    $('#user_mail').val('');
                    $('#user_pass').val('');
                    $('#confirm_pass').val('');
                    $('#user_role').val('');
                } else {
                $('#add-user-modal').modal('hide');
                    toastr.error('Add Fail');
                    $('#user_name').val('');
                    $('#user_mail').val('');
                    $('#user_pass').val('');
                    $('#confirm_pass').val('');
                    $('#user_role').val('');
                }
                getUserData();
            } else {
                $('#add-user-modal').modal('hide');
                toastr.error('Something Went Wrong 1 !');
            }   
        })
        .catch(function(error) {
            $('#add-user-modal').modal('hide');
            toastr.error('Something Went Wrong 2 !');
        });
    }
}
// User Edit Data
function UserUpdateDetails(detailsID){
    axios.post('/user/getDetails', {
    id: detailsID
})
.then(function(response) {
    if(response.status==200){
        $('#user-edit-form').removeClass('d-none');
        $('#user-edit-loader').addClass('d-none');    
        var jsonData = response.data;
        $('#user_name_update').val(jsonData.name);
        $('#user_mail_update').val(jsonData.email);
        $('#user_role_update').html(jsonData['role'].name);
        $('#user_role_update').val(jsonData.role_id);
    } else {
        $('#user-edit-loader').addClass('d-none');
        $('#user-edit-wrong').removeClass('d-none');
        }
    })
    .catch(function(error) {
            $('#user-edit-loader').addClass('d-none');
            $('#user-edit-wrong').removeClass('d-none');

    });
}
// User data deleted
$('#user-delete-confirm-btn').click(function(){
   var id= $('#user-delete-id').html();
   UserDelete(id);
})
function UserDelete(deleteID) {
    $('#user-delete-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('user/delete', {
        id: deleteID
    })
    .then(function(response) {
        $('#user-delete-confirm-btn').html("Yes");
            if(response.status==200){
                if (response.data == 1) {
                    $('#delete-user-modal').modal('hide');
                    toastr.success('Delete Success');
                } else {
                    $('#delete-user-modal').modal('hide');
                    toastr.error('Delete Fail');
                }
                getProjectData();
            } else {
                $('#user-delete-confirm-btn').html("Yes");
                $('#delete-user-modal').modal('hide');
                toastr.error('Something Went Wrong !');
            }
    })
    .catch(function(error) {
        $('#user-delete-confirm-btn').html("Yes");
        $('#delete-user-modal').modal('hide');
        toastr.error('Something Went Wrong !');
    });
}
</script>
@endsection