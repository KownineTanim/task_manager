@extends('Layout.app')
@section('title','Assignment')
@section('content')

<div id="mainDivAssignment"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="addAssignmentBtn" class="btn my-3 btn-sm btn-danger">Add Assignment </button>
            <table id="AssignmentDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Employee Name</th>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Task Name</th>
                        <th class="th-sm">Assign Date</th>
                        <th class="th-sm">End Date</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="Assignment_table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- loader div -->
<div id="loaderDivAssignment" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
        </div>
    </div>
</div>

<!-- Something Went Wrong ! -->
<div id="WrongDivAssignment" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <h3>Something Went Wrong !</h3>
        </div>
    </div>
</div>

<!-- Assignment add modal -->
<div class="modal fade" id="addAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <select id="projects" name="projectlist" form="projectform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Choose Project</option>
                            </select>
                            <select id="tasks" name="tasklist" form="taskform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Choose Task</option>
                            </select>
                            <select id="employees" name="employeelist" form="employeeform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Assign Employee</option>
                            </select>
                            <label for="assignDate">Assign Date:</label>
                            <input type="date" id="assignDate" name="assignDate">
                            <label for="endDate">End Date:</label>
                            <input type="date" id="endDate" name="endDate">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="AssignmentAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
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
    axios.get('/getAssignmentData')

        .then(function(response) {

            if (response.status == 200) {

                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');
                $('#AssignmentDataTable').DataTable().destroy();
                
                $('#Assignment_table').empty();
                var jsonData = response.data;


                $.each(jsonData, function(i, item) {
                    
                    $('<tr>').html(
                        "<td>" + jsonData[i].employee_id + "</td>" +
                        "<td>" + jsonData[i]['project'].project_name + "</td>" +
                        "<td>" + jsonData[i]['task'].task_name + "</td>" +
                        "<td>" + jsonData[i].assign_date  + "</td>" +
                        "<td>" + jsonData[i].end_date  + "</td>" +
                        "<td><a class='AssignmentEditBtn' data-id="+jsonData[i].id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='AssignmentDeleteBtn' data-id="+jsonData[i].id+"><i class='fas fa-trash-alt'></i></a></td>"
                        
                    ).appendTo('#Assignment_table');
                    
                }); 
  
                  $('#TaskDataTable').DataTable({"order":false});
                  $('.dataTables_length').addClass('bs-select'); 
            }

                else {
                    
                    $('#loaderDiv').addClass('d-none');
                    $('#WrongDiv').removeClass('d-none'); 
                }
    
            })
            .catch(function(error) {
                
                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none');
            });
    
  }
// Add modal open function
$('#addAssignmentBtn').click(function(){
    $('#addAssignmentModal').modal('show');
});
// Project list load function
$('#projects').on('click', function () { 
    ProjectList();
});
function ProjectList() {
    axios.get('/ProjectList')

        .then(function(response) {

            if (response.status == 200) {

                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');
                
                var jsonData = response.data;

                $.each(jsonData, function (i, item) {
                    $('#projects').append($('<option>', { 
                        value: item.id ,
                        text : item.project_name 
                    }));
                });
            }
            else {
                    
                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none'); 
            }
            })
            .catch(function(error) {
                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none');
                
            });
    
}

// Project wise task
$('#projects').on('change', function () {
        var idProject = this.value;
        projectWiseTask(idProject);
});
function projectWiseTask(idProject) {
    axios.post('/projectWiseTask', {
        project_id: idProject
        })
        .then(function(response) {

                if(response.status==200){
                    

                    var jsonData = response.data;
                    $.each(jsonData, function (i, item) {
                        $('#tasks').append($('<option>', { 
                            value: item.id ,
                            text : item.task_name 
                        }));
                    });
                    
                }
                else{
                    $('#loaderDiv').addClass('d-none');
                    $('#WrongDiv').removeClass('d-none');
                }
    })
    .catch(function(error) {
                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none'); 
   });

}

// Employee list load function
$('#employees').on('click', function () { 
    EmployeeList();
});
function EmployeeList() {
    axios.get('/EmployeeList')

        .then(function(response) {

            if (response.status == 200) {

                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');
                
                var jsonData = response.data;

                $.each(jsonData, function (i, item) {
                    $('#employees').append($('<option>', { 
                        value: item.id ,
                        text : item.employee_name 
                    }));
                });
            }
            else {
                    
                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none'); 
            }
            })
            .catch(function(error) {
                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none');
                
            });
    
}
// Add modal open function
$('#AssignmentAddConfirmBtn').click(function(){
  var ProjectId = $('#projects').val();
  var TaskId = $('#tasks').val();
  var EmployeesId = $('#employees').val();
  var AssignDate = $('#assignDate').val();
  var EndDate = $('#endDate').val();
  AssignmentAdd(ProjectId,TaskId,EmployeesId,AssignDate,EndDate);
});
function AssignmentAdd(ProjectId,TaskId,EmployeesId,AssignDate,EndDate) {
  
  if(ProjectId.length==0){
   toastr.error('Choose a project !');
  }
  else if(TaskId.length==0){
   toastr.error('Select a task !');
  }
  else if(EmployeesId.length==0){
   toastr.error('Assign an employee !');
  }
  else if(AssignDate.length==0){
   toastr.error('Select from date !');
  }
  else if(EndDate.length==0){
   toastr.error('Select to date !');
  }
  else{
  $('#AssignmentAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
  axios.post('/AssignmentAdd', {
          project_id: ProjectId,
          task_id: TaskId,   
          employee_id: EmployeesId,
          assign_date: AssignDate,
          end_date: EndDate,                                
      })
    .then(function(response) {
          $('#AssignmentAddConfirmBtn').html("Save");
          if(response.status==200){
            if (response.data == 1) {
              $('#addAssignmentModal').modal('hide');
              toastr.success('Add Success');
          } else {
              $('#addAssignmentModal').modal('hide');
              toastr.error('Add Fail');
          }  
       } 
       else{
           $('#addAssignmentModal').modal('hide');
           toastr.error('Something Went Wrong 1 !');
       }   
  })
  .catch(function(error) {
           $('#addAssignmentModal').modal('hide');
           toastr.error('Something Went Wrong 2 !');
 });
}
}

</script>
@endsection