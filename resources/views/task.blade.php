@extends('Layout.app')
@section('title','Tasks')
@section('content')
<div id="mainDivProject"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="addTaskBtn" class="btn my-3 btn-sm btn-danger">Add Task </button>
            <table id="TaskDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Task Name</th>
                        <th class="th-sm">Task Description</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="Task_table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- loader div -->
<div id="loaderDivProject" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
        </div>
    </div>
</div>

<!-- Something Went Wrong ! -->
<div id="WrongDivProject" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <h3>Something Went Wrong !</h3>
        </div>
    </div>
</div>

<!-- Task add modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <select id="projects" name="projectlist" form="carform" style="display:block!important;width:100%;margin-bottom:1rem;">
                            <option value="">Choose Project</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input id="TaskName" type="text" class="form-control mb-3" placeholder="Task Name">
                        </div>
                        <div class="col-md-12">
                            <label for="content" style="float:left!important;">Task Description</label><br>
                            <textarea name="content" id="content" style="height:400px;" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="TaskAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
getTaskData();

function getTaskData() {
    axios.get('/getTaskData')

        .then(function(response) {

            if (response.status == 200) {

                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');
                $('#TaskDataTable').DataTable().destroy();
                
                $('#Task_table').empty();
                var jsonData = response.data;


                $.each(jsonData, function(i, item) {
                    
                    $('<tr>').html(

                        "<td>" + jsonData[i]['project'].project_name + "</td>" +
                        "<td>" + jsonData[i].task_name + "</td>" +
                        "<td>" + jsonData[i].task_desc  + "</td>" +
                        "<td><a class='TaskEditBtn' data-id="+jsonData[i].id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='TaskDeleteBtn' data-id="+jsonData[i].id+"><i class='fas fa-trash-alt'></i></a></td>"
                        
                    ).appendTo('#Task_table');
                    
                }); 
                    $('.TaskEditBtn').click(function(){
                        var id= $(this).data('id');
                        alert(id);
                     })

                     $('.TaskDeleteBtn').click(function(){
                        var id= $(this).data('id');
                        alert(id);
                     })   
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
$('#addTaskBtn').click(function(){
    $('#addTaskModal').modal('show');
    var config = {};
    config.allowScriptCode = true;
    config.file_upload_handler = file_upload_handler;
    setTimeout(() => {
        window.editor = new RichTextEditor("#content", config);
    }, 1000);
});

function file_upload_handler(file, callback, optionalIndex, optionalFiles) {
        var formData = new FormData();
        formData.append("file", file);
        formData.append("_token", "{{ csrf_token() }}");

        $.ajax({
          url : "",
          type : 'POST',
          enctype: 'multipart/form-data',
          processData: false,
          contentType: false,
          cache: false,
          data : formData,
          success : function(response) {
              if(response.status == 'success') {
                  callback(response.path);
              } else {
                  callback(null);
                  alert(response.message);
              }
          },
          error : function(error) {
              callback(null);
              alert("Something went wrong!");
          }
        });
}
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
//Task add function
$('#TaskAddConfirmBtn').click(function(){
  var ProjectId = $('#projects').val();
  var TaskName = $('#TaskName').val();
  var TaskDesc = $('#content').val();
  TaskAdd(ProjectId,TaskName,TaskDesc);
});
function TaskAdd(ProjectId,TaskName,TaskDesc) {
  
  if(ProjectId.length==0){
   toastr.error('Project Name is Empty !');
  }
  else if(TaskName.length==0){
   toastr.error('Task Name is Empty !');
  }
  else if(TaskDesc.length==0){
   toastr.error('Task Description is Empty !');
  }
  else{
  $('#TaskAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
  axios.post('/TaskAdd', {
          project_id: ProjectId,
          task_name: TaskName,   
          task_desc: TaskDesc,                                
      })
    .then(function(response) {
          $('#TaskAddConfirmBtn').html("Save");
          if(response.status==200){
            if (response.data == 1) {
              $('#addTaskModal').modal('hide');
              toastr.success('Add Success');
          } else {
              $('#addTaskModal').modal('hide');
              toastr.error('Add Fail');
          }  
       } 
       else{
           $('#addTaskModal').modal('hide');
           toastr.error('Something Went Wrong 1 !');
       }   
  })
  .catch(function(error) {
           $('#addTaskModal').modal('hide');
           toastr.error('Something Went Wrong 2 !');
 });
}
}

</script>
@endsection