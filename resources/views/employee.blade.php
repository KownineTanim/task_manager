@extends('Layout.app')
@section('title','Employee')
@section('content')
<div id="mainDivEmployee"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="addEmployeeBtn" class="btn my-3 btn-sm btn-danger">Add Employee </button>
            <table id="EmployeeDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Employee Name</th>
                        <th class="th-sm">Mail Id</th>
                        <th class="th-sm">Phone</th>
                        <th class="th-sm">Employee Role</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="Employee_table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- loader div -->
<div id="loaderDivEmployee" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
        </div>
    </div>
</div>

<!-- Something Went Wrong ! -->
<div id="WrongDivEmployee" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <h3>Something Went Wrong !</h3>
        </div>
    </div>
</div>

<!-- Employee add modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="EmployeeName" type="text" class="form-control mb-3" placeholder="Employee Name">
                            <input id="EmployeeMail" type="text"  class="form-control mb-3" placeholder="Employee Email">
                            <input id="EmployeePhone" type="text" class="form-control mb-3" placeholder="Employee Phone">
                            <select id="EmployeeRole" name="rolelist" form="roleform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="EmployeeAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Employee edit modal -->
<div class="modal fade" id="updateEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
            <h5 id="EmployeeEditId" class="mt-4 d-none">  </h5>
                <div id="EmployeeEditForm" class="container d-none">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="EmployeeNameUpdate" type="text" class="form-control mb-3" placeholder="Employee Name">
                            <input id="EmployeeMailUpdate" type="text"  class="form-control mb-3" placeholder="Employee Email">
                            <input id="EmployeePhoneUpdate" type="text" class="form-control mb-3" placeholder="Employee Phone">
                            <select id="EmployeeRoleUpdate" name="rolelist" form="roleform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                    </div>
                </div>
                    <img id="EmployeeEditLoader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
                    <h5 id="EmployeeEditWrong" class="d-none">Something Went Wrong !</h5>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="EmployeeUpdateConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Employee Data Deleted -->

<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-3 text-center">
        <h5 class="mt-4">Do You Want To Delete?</h5>
        <h5 id="EmployeeDeleteId" class="mt-4 d-none">   </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
        <button  id="EmployeeDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
//Employees data table
getEmployeeData();

function getEmployeeData() {
    axios.get('/getEmployeeData')
        .then(function(response) {
            if (response.status == 200) {
                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');
                $('#EmployeeDataTable').DataTable().destroy();
                
                $('#Employee_table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>"+jsonData[i].employee_name+"</td>" +
                        "<td>"+jsonData[i].employee_mail+"</td>" +  
                        "<td>"+jsonData[i].employee_phone+"</td>" +  
                        "<td>"+jsonData[i].employee_role+"</td>" +  
                        "<td><a class='EmployeeEditBtn' data-id="+jsonData[i].id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='EmployeeDeleteBtn' data-id="+jsonData[i].id+"><i class='fas fa-trash-alt'></i></a></td>"
                    ).appendTo('#Employee_table');
                });
                     $('.EmployeeDeleteBtn').click(function(){
                       
                      var id= $(this).data('id');
                     $('#EmployeeDeleteId').html(id);
                     $('#deleteEmployeeModal').modal('show');
                     })
                     $('.EmployeeEditBtn').click(function(){
                        var id= $(this).data('id');
                        EmployeeUpdateDetails(id);
                        $('#EmployeeEditId').html(id);
                        $('#updateEmployeeModal').modal('show');
                     })
                  $('#EmployeeDataTable').DataTable({"order":false});
                  $('.dataTables_length').addClass('bs-select');
            } else {
                $('#loaderDivEmployee').addClass('d-none');
                $('#WrongDivEmployee').removeClass('d-none');
            }
        })
        .catch(function(error) {
                $('#loaderDivEmployee').addClass('d-none');
                $('#WrongDivEmployee').removeClass('d-none');
        });
}
// Employee add modal open
$('#addEmployeeBtn').click(function(){
    $('#addEmployeeModal').modal('show');
});
// Employee add function
$('#EmployeeAddConfirmBtn').click(function(){
  var EmployeeName = $('#EmployeeName').val();
  var EmployeeMail = $('#EmployeeMail').val();
  var EmployeePhone = $('#EmployeePhone').val();
  var EmployeeRole = $('#EmployeeRole').val();
  EmployeeAdd(EmployeeName,EmployeeMail,EmployeePhone,EmployeeRole);
});
function EmployeeAdd(EmployeeName,EmployeeMail,EmployeePhone,EmployeeRole) {
  
  if(EmployeeName.length==0){
   toastr.error('Employee Name is Empty !');
  }
  else if(EmployeeMail.length==0){
   toastr.error('Employee Mail is Empty !');
  }
  else if(EmployeePhone.length==0){
   toastr.error('Employee Phone is Empty !');
  }
  else if(EmployeeRole.length==0){
   toastr.error('Employee Role is Empty !');
  }
  else{
  $('#EmployeeAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
  axios.post('/EmployeeAdd', {
          employee_name: EmployeeName,
          employee_mail: EmployeeMail,
          employee_phone: EmployeePhone,
          employee_role: EmployeeRole,                                 
      })
    .then(function(response) {
          $('#EmployeeAddConfirmBtn').html("Save");
          if(response.status==200){
            if (response.data == 1) {
              $('#addEmployeeModal').modal('hide');
              toastr.success('Add Success');
          } else {
              $('#addEmployeeModal').modal('hide');
              toastr.error('Add Fail');
          }  
       } 
       else{
           $('#addEmployeeModal').modal('hide');
           toastr.error('Something Went Wrong 1 !');
       }   
  })
  .catch(function(error) {
           $('#addEmployeeModal').modal('hide');
           toastr.error('Something Went Wrong 2 !');
 });
}
}

// Employee Edit Data
function EmployeeUpdateDetails(detailsID){
    axios.post('/getEmployeeDetails', {
    id: detailsID
})
.then(function(response) {
    if(response.status==200){
        $('#EmployeeEditForm').removeClass('d-none');
        $('#EmployeeEditLoader').addClass('d-none');    
        var jsonData = response.data;
        $('#EmployeeNameUpdate').val(jsonData[0].employee_name);
        $('#EmployeeMailUpdate').val(jsonData[0].employee_mail);
        $('#EmployeePhoneUpdate').val(jsonData[0].employee_phone);
        $('#EmployeeRoleUpdate').val(jsonData[0].employee_role);
}
                  
    else{
            $('#EmployeeEditLoader').addClass('d-none');
            $('#EmployeeEditWrong').removeClass('d-none');
        }
})
    .catch(function(error) {
            $('#EmployeeEditLoader').addClass('d-none');
            $('#EmployeeEditWrong').removeClass('d-none');
        });
}

// Employee Data Updated
$('#EmployeeUpdateConfirmBtn').click(function(){
  var EmployeeId=$('#EmployeeEditId').html();
  var EmployeeName = $('#EmployeeNameUpdate').val();
  var EmployeeMail = $('#EmployeeMailUpdate').val();
  var EmployeePhone = $('#EmployeePhoneUpdate').val();
  var EmployeeRoleUpdate = document.getElementById('EmployeeRoleUpdate'),
  EmployeeRoleUpdateValue = EmployeeRoleUpdate.value;
  EmployeeUpdate(EmployeeId,EmployeeName,EmployeeMail,EmployeePhone,EmployeeRoleUpdateValue);
})
function EmployeeUpdate(EmployeeId,EmployeeName,EmployeeMail,EmployeePhone,EmployeeRoleUpdateValue) {
  
  if(EmployeeName.length==0){
   toastr.error('Employee Name is Empty !');
  }
  else if(EmployeeMail.length==0){
   toastr.error('Employee Mail is Empty !');
  }
  else if(EmployeePhone.length==0){
   toastr.error('Employee Phone is Empty !');
  }
  else if(EmployeeRoleUpdateValue.length==0){
   toastr.error('Employee Role is Empty !');
  }
  else{
  $('#EmployeeUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
  axios.post('/EmployeeUpdate', {
          id: EmployeeId,
          employee_name:EmployeeName,
          employee_mail:EmployeeMail, 
          employee_phone:EmployeePhone, 
          employee_role:EmployeeRoleUpdateValue, 
      })
      .then(function(response) {
          $('#EmployeeUpdateConfirmBtn').html("Update");
          if(response.status==200){
            if (response.data == 1) {
              $('#updateEmployeeModal').modal('hide');
              toastr.success('Update Success');
              getEmployeeData();
          } else {
              $('#updateEmployeeModal').modal('hide');
              toastr.error('Update Fail');
              getEmployeeData();
          }  
       } 
       else{
          $('#updateEmployeeModal').modal('hide');
           toastr.error('Something Went Wrong !');
       }   
  })
  .catch(function(error) {
      $('#updateEmployeeModal').modal('hide');
      toastr.error('Something Went Wrong !');
 });
}
}

// Employee Data Deleted
$('#EmployeeDeleteConfirmBtn').click(function(){
   var id= $('#EmployeeDeleteId').html();
   EmployeeDelete(id);
});
function EmployeeDelete(deleteID) {
  $('#EmployeeDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/EmployeeDelete', {
            id: deleteID
        })
        .then(function(response) {
            $('#EmployeeDeleteConfirmBtn').html("Yes");
            if(response.status==200){
            if (response.data == 1) {
                $('#deleteEmployeeModal').modal('hide');
                toastr.success('Delete Success');
                getEmployeeData();
            } else {
                $('#deleteEmployeeModal').modal('hide');
                toastr.error('Delete Fail');
                getEmployeeData();
            }
            }
            else{
              $('#EmployeeDeleteConfirmBtn').html("Yes");
             $('#deleteEmployeeModal').modal('hide');
             toastr.error('Something Went Wrong !');
            }
        })
        .catch(function(error) {
             $('#EmployeeDeleteConfirmBtn').html("Yes");
             $('#deleteEmployeeModal').modal('hide');
             toastr.error('Something Went Wrong !');
        });
}


</script>
@endsection