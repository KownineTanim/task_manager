@extends('Layout.app')
@section('title','Assignment')
@section('content')

<div id="main-div-assignment"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="add-assignment-btn" class="btn my-3 btn-sm btn-danger">Add Assignment </button>
            <table id="assignment-data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Employee Name</th>
                        <th class="th-sm">Task Name</th>
                        <th class="th-sm">Consumed Time</th>
                        <th class="th-sm">Assigned by</th>
                        <th class="th-sm">Created at</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="assignment-table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- loader div -->
<div id="loader-div-assignment" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
        </div>
    </div>
</div>

<!-- Something Went Wrong ! -->
<div id="wrong-div-assignment" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <h3>Something Went Wrong !</h3>
        </div>
    </div>
</div>

<!-- Assignment add modal -->
<div class="modal fade" id="add-assignment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Assignment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <select id="employees" name="employeelist" form="employeeform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Assign Employee</option>
                            </select>
                            <select id="tasks" name="tasklist" form="taskform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Choose Task</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="assignment-add-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assignment edit modal -->
<div class="modal fade" id="update-assignment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Assignment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h5 id="assignment-edit-id" class="mt-4 d-none">  </h5>
                <div id="assignment-edit-form" class="container d-none">
                    <div class="row">
                        <div class="col-md-12">
                            <select id="employee-update-change" name="projectlist" form="carform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option id="employee-update" value=""></option>
                                <option value="">Choose Project</option>
                            </select>
                            <select id="task-update-change" name="projectlist" form="carform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option id="task-update" value=""></option>
                                <option value="">Choose Project</option>
                            </select>
                        </div>
                    </div>
                    <img id="assignment-edit-loader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
                    <h5 id="assignment-edit-wrong" class="d-none">Something Went Wrong !</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="assignment-update-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assignment Data Deleted -->

<div class="modal fade" id="delete-assignment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-3 text-center">
        <h5 class="mt-4">Do You Want To Delete?</h5>
        <h5 id="assignment-delete-id" class="mt-4 d-none">   </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
        <button  id="assignment-delete-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
// Assignment data load 
getAssignmentData();
function getAssignmentData() {
    axios.get('/assignment?json')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-assignment').removeClass('d-none');
                $('#loader-div-assignment').addClass('d-none');
                $('#assignment-data-table').DataTable().destroy();
                $('#assignment-table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>" + item['employee'].name + "</td>" +
                        "<td>" + item['taskname'].title + "</td>" +
                        "<td>" + new Date(item.consumed_time * 1000).toISOString().substring(11, 19)  + "</td>" +
                        "<td>" + item['user'].name  + "</td>" +
                        "<td>" + item.created_at.substring(0, 10)  + "</td>" +
                        "<td><a class='assignment-edit-btn' data-id="+item.id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='assignment-delete-btn' data-id="+item.id+"><i class='fas fa-trash-alt'></i></a></td>" 
                    ).appendTo('#assignment-table');
                }); 
                $('.assignment-edit-btn').click(function(){
                    var id= $(this).data('id');
                    AssignmentUpdateDetails(id);
                    $('#assignment-edit-id').html(id);
                    $('#update-assignment-modal').modal('show');
                })
                $('.assignment-delete-btn').click(function(){
                    var id= $(this).data('id');
                    $('#assignment-delete-id').html(id);
                    $('#delete-assignment-modal').modal('show');
                })
                $('#assignment-data-table').DataTable({"order":false});
                $('.dataTables_length').addClass('bs-select'); 
            } else {
                $('#loader-div-assignment').addClass('d-none');
                $('#wrong-div-assignment').removeClass('d-none'); 
            }
            })
        .catch(function(error) { 
            $('#loader-div-assignment').addClass('d-none');
            $('#wrong-div-assignment').removeClass('d-none');
        });
}
// Add modal open function
$('#add-assignment-btn').click(function(){
    $('#add-assignment-modal').modal('show');
});
// Employee list load function
$('#employees').on('click', function () { 
    EmployeeList();
});
function EmployeeList() {
    axios.get('/employee-list')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-assignment').removeClass('d-none');
                $('#loader-div-assignment').addClass('d-none');
                var jsonData = response.data;
                $.each(jsonData, function (i, item) {
                    $('#employees').append($('<option>', { 
                        value: item.id ,
                        text : item.name 
                    }));
                });
            } else {
                $('#loader-div-assignment').addClass('d-none');
                $('#wrong-div-assignment').removeClass('d-none'); 
            }
        })
        .catch(function(error) {
            $('#loader-div-assignment').addClass('d-none');
            $('#wrong-div-assignment').removeClass('d-none');
        });    
}
// Task list load function
$('#tasks').on('click', function () { 
    TaskList();
});
function TaskList() {
    axios.get('/task-list')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-assignment').removeClass('d-none');
                $('#loader-div-assignment').addClass('d-none');
                var jsonData = response.data;
                $.each(jsonData, function (i, item) {
                    $('#tasks').append($('<option>', { 
                        value: item.id ,
                        text : item.title 
                    }));
                });
            } else { 
                $('#loader-div-assignment').addClass('d-none');
                $('#wrong-div-assignment').removeClass('d-none'); 
            }
        })
        .catch(function(error) {
            $('#loader-div-assignment').addClass('d-none');
            $('#wrong-div-assignment').removeClass('d-none');
        });    
}
// Add modal open function
$('#assignment-add-confirm-btn').click(function(){
    var employee_id = $('#employees').val();
    var task_id = $('#tasks').val();
    AssignmentAdd (employee_id, task_id);

});
function AssignmentAdd (employee_id, task_id) {
    if (employee_id.length==0) {
        toastr.error('Choose an employee !');
    } else if (task_id.length==0) {
        toastr.error('Select a task !');
    } else {
        $('#assignment-add-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/assignment/add', {
            empoyee_id: employee_id,
            task_id: task_id,                                  
        })
        .then(function(response) {
            $('#assignment-add-confirm-btn').html("Save");
            if  ( response.status==200 ) {
                if (response.data == 1) {
                    $('#add-assignment-modal').modal('hide');
                    toastr.success('Add Success');
                } else {
                    $('#add-assignment-modal').modal('hide');
                    toastr.error('Add Fail');
                }
                getAssignmentData(); 
            } else {
                $('#add-assignment-modal').modal('hide');
                toastr.error('Something Went Wrong 1!');
            }   
        })
        .catch(function(error) {
           $('#add-assignment-modal').modal('hide');
           toastr.error('Something Went Wrong 2!');
        });
    }
}
// Assignment Edit Data
function AssignmentUpdateDetails(detailsID){
    axios.post('/assignment/getDetails', {
    id: detailsID
})
.then(function(response) {
    if(response.status==200){
        $('#assignment-edit-form').removeClass('d-none');
        $('#assignment-edit-loader').addClass('d-none');    
        var jsonData = response.data;
        $('#employee-update').html(jsonData['employee'].name);
        $('#employee-update').val(jsonData.empoyee_id);
        $('#task-update').html(jsonData['taskname'].title);
        $('#task-update').val(jsonData.task_id);
    } else {
        $('#assignment-edit-loader').addClass('d-none');
        $('#assignment-edit-wrong').removeClass('d-none');
    }
})
.catch(function(error) {
    $('#assignment-edit-loader').addClass('d-none');
    $('#assignment-edit-wrong').removeClass('d-none');
});
}
// Employee list load function for edit modal
$('#employee-update-change').on('click', function () { 
    EmployeeListUpdateModal();
});
function EmployeeListUpdateModal() {
    axios.get('employee-list')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-assignment').removeClass('d-none');
                $('#loader-div-assignment').addClass('d-none');
                var jsonData = response.data;
                $.each(jsonData, function (i, item) {
                    $('#employee-update-change').append($('<option>', { 
                        value: item.id ,
                        text : item.name 
                    }));
                });
            } else {
                $('#loader-div-assignment').addClass('d-none');
                $('#wrong-div-assignment').removeClass('d-none'); 
            }
        })
        .catch(function(error) {
            $('#loader-div-assignment').addClass('d-none');
            $('#wrong-div-assignment').removeClass('d-none');   
        }); 
}

// Task list load function for edit modal
$('#task-update-change').on('click', function () { 
    TaskListUpdateModal();
});
function TaskListUpdateModal() {
    axios.get('/task-list')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-assignment').removeClass('d-none');
                $('#loader-div-assignment').addClass('d-none');
                var jsonData = response.data;
                $.each(jsonData, function (i, item) {
                    $('#task-update-change').append($('<option>', { 
                        value: item.id ,
                        text : item.title 
                    }));
                });
            } else { 
                $('#loader-div-assignment').addClass('d-none');
                $('#wrong-div-assignment').removeClass('d-none'); 
            }
        })
        .catch(function(error) {
            $('#loader-div-assignment').addClass('d-none');
            $('#wrong-div-assignment').removeClass('d-none');
        });    
}

// Assignment Data Update
$('#assignment-update-confirm-btn').click(function(){
    var assignment_id = $('#assignment-edit-id').html();
    var employee_id = $('#employee-update-change').val();
    var task_id = $('#task-update-change').val();
    AssignmentUpdate(assignment_id, employee_id, task_id);
});
function AssignmentUpdate(assignment_id, employee_id, task_id) {
    if ( employee_id.length==0 ) {
        toastr.error('Assign an employee!');
    } else if ( task_id.length==0 ) {
        toastr.error('Select a task !');
    } else {
    $('#assignment-update-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/assignment/update', {
            id: assignment_id,
            empoyee_id: employee_id,
            task_id: task_id,
        })
        .then(function(response) {
            $('#assignment-update-confirm-btn').html("Update");
            if(response.status==200){
                if (response.data == 1) {
                    $('#update-assignment-modal').modal('hide');
                    toastr.success('Update Success');
                } else {
                    $('#update-assignment-modal').modal('hide');
                    toastr.error('Update Fail');
                }
                getAssignmentData();  
            } else {
                $('#update-assignment-modal').modal('hide');
                toastr.error('Something Went Wrong 1!');
            }   
        })
        .catch(function(error) {
            $('#update-assignment-modal').modal('hide');
            toastr.error('Something Went Wrong 2!');
        });
    }
}
// Assignment Data Deleted
$('#assignment-delete-confirm-btn').click(function(){
    var id= $('#assignment-delete-id').html();
    AssignmentDelete(id);
});
function AssignmentDelete(deleteID) {
    $('#assignment-delete-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/assignment/delete', {
        id: deleteID
    })
    .then(function(response) {
        $('#assignment-delete-confirm-btn').html("Yes");
        if(response.status==200){
            if (response.data == 1) {
                $('#delete-assignment-modal').modal('hide');
                toastr.success('Delete Success');
            } else {
                $('#delete-assignment-modal').modal('hide');
                toastr.error('Delete Fail');
            }
        } else {
            $('#assignment-delete-confirm-btn').html("Yes");
            $('#delete-assignment-modal').modal('hide');
            toastr.error('Something Went Wrong !');
        }
    })
    .catch(function(error) {
        $('#assignment-delete-confirm-btn').html("Yes");
        $('#delete-assignment-modal').modal('hide');
        toastr.error('Something Went Wrong !');
    });
}
</script>
@endsection