@extends('Layout.app')
@section('title','Tasks')
@section('content')
<div id="main-div-task"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="add-task-btn" class="btn my-3 btn-sm btn-danger">Add Task </button>
            <table id="task-data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Task title</th>
                        <th class="th-sm">Task description</th>
                        <th class="th-sm">Created by</th>
                        <th class="th-sm">Created at</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="task-table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- loader div -->
<div id="loader-div-task" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
        </div>
    </div>
</div>

<!-- Something Went Wrong ! -->
<div id="wrong-div-task" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <h3>Something Went Wrong !</h3>
        </div>
    </div>
</div>

<!-- Task add modal -->
<div class="modal fade" id="add-task-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <select id="projects" name="projectlist" form="projectform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option value="">Choose Project</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input id="task-title" type="text" class="form-control mb-3" placeholder="Task Name">
                        </div>
                        <div class="col-md-12">
                            <label for="content" style="float:left!important;">Task Description</label><br>
                            <textarea name="content" id="content" style="height:400px;" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="task-add-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task edit modal -->
<div class="modal fade" id="update-task-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <h5 id="task-edit-id" class="mt-4 d-none">  </h5>
                <div id="task-edit-form" class="container d-none">
                    <div class="row">
                        <div class="col-md-12">
                            <select id="projects-update-change" name="projectlist" form="carform" style="display:block!important;width:100%;margin-bottom:1rem;">
                                <option id="projects-update" value=""></option>
                                <option value="">Choose Project</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <input id="task-title-update" type="text" class="form-control mb-3" placeholder="Task Name">
                        </div>
                        <div class="col-md-12">
                            <label for="contentUpdate" style="float:left!important;">Task Description</label><br>
                            <textarea name="content" id="content-update" style="height:400px;" class="form-control"></textarea>
                        </div>
                    </div>
                    <img id="task-edit-loader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
                    <h5 id="`task-edit-wrong`" class="d-none">Something Went Wrong !</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="task-update-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task Data Deleted -->

<div class="modal fade" id="delete-task-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-3 text-center">
        <h5 class="mt-4">Do You Want To Delete?</h5>
        <h5 id="task-delete-id" class="mt-4 d-none">   </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
        <button  id="task-delete-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
getTaskData();

function getTaskData() {
    axios.get('/task?json')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-task').removeClass('d-none');
                $('#loader-div-task').addClass('d-none');
                $('#task-data-table').DataTable().destroy();
                $('#task-table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {   
                    $('<tr>').html(
                        "<td>" + item['projectname'].name + "</td>" +
                        "<td>" + item.title + "</td>" +
                        "<td>" + item.description  + "</td>" +
                        "<td>" + item['username'].name  + "</td>" +
                        "<td>" + item.created_at.substring(0, 10)  + "</td>" +
                        "<td><a class='task-edit-btn' data-id="+item.id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='task-delete-btn' data-id="+item.id+"><i class='fas fa-trash-alt'></i></a></td>"   
                    ).appendTo('#task-table');
                }); 
                $('.task-edit-btn').click(function(){
                    var id= $(this).data('id');
                    TaskUpdateDetails(id);
                     $('#update-task-modal').modal('show');
                    var config = {};
                    config.allowScriptCode = true;
                    config.file_upload_handler = file_upload_handler;
                    setTimeout(() => {
                        window.editor = new RichTextEditor("#content-update", config);
                    }, 1000);
                    $('#task-edit-id').html(id);
                });
                $('.task-delete-btn').click(function(){
                    var id= $(this).data('id');
                    $('#task-delete-id').html(id);
                    $('#delete-task-modal').modal('show');
                });   
                $('#task-data-table').DataTable({"order":false});
                $('.dataTables_length').addClass('bs-select'); 
            } else {  
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
$('#add-task-btn').click(function(){
    $('#add-task-modal').modal('show');
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
    axios.get('/project-list')
        .then(function(response) {
            if (response.status == 200) {
                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');
                var jsonData = response.data;
                $.each(jsonData, function (i, item) {
                    $('#projects').append($('<option>', { 
                        value: item.id ,
                        text : item.name 
                    }));
                });
            } else { 
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
$('#task-add-confirm-btn').click(function(){
  var projectId = $('#projects').val();
  var taskTitle = $('#task-title').val();
  var taskDesc = $('#content').val();
  TaskAdd(projectId, taskTitle, taskDesc);
});
function TaskAdd (projectId, taskTitle, taskDesc) {
    if (projectId.length==0) {
        toastr.error('Project Name is Empty !');
    } else if (taskTitle.length==0) {
        toastr.error('Task Name is Empty !');
    } else if (taskDesc.length==0) {
        toastr.error('Task Description is Empty !');
    } else {
        $('#task-add-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/task/add', {
            title: taskTitle,
            description: taskDesc,   
            project_id: projectId,                                
        })
        .then(function(response) {
            $('#TaskAddConfirmBtn').html("Save");
            if  ( response.status==200 ) {
                if (response.data == 1) {
                    $('#add-task-modal').modal('hide');
                    toastr.success('Add Success');
                    $('#projects').val('');
                    $('#TaskTitle').val('');
                    $('#content').val('');
                } else {
                    $('#add-task-modal').modal('hide');
                    toastr.error('Add Fail');
                }
                getTaskData();  
            } else {
                $('#add-task-modal').modal('hide');
                toastr.error('Something Went Wrong 1!');
            }   
        })
        .catch(function(error) {
           $('#add-task-modal').modal('hide');
           toastr.error('Something Went Wrong 2!');
        });
    }
}
// Task Edit Data
function TaskUpdateDetails(detailsID){
    axios.post('/task/getDetails', {
    id: detailsID
})
.then(function(response) {
    if(response.status==200){
        $('#task-edit-form').removeClass('d-none');
        $('#task-edit-loader').addClass('d-none');    
        var jsonData = response.data;
        $('#projects-update').val(jsonData.project_id);
        $('#projects-update').html(jsonData['projectname'].name);
        $('#task-title-update').val(jsonData.title);
        $('#content-update').val(jsonData.description);
    } else {
        $('#task-edit-loader').addClass('d-none');
        $('#task-edit-wrong').removeClass('d-none');
    }
})
.catch(function(error) {
    $('#task-edit-loader').addClass('d-none');
    $('#task-edit-wrong').removeClass('d-none');
 });
}
// Project list load function for update task
$('#projects-update-change').on('click', function () { 
    ProjectListUpdateModal();
});
function ProjectListUpdateModal() {
    axios.get('/project-list')
        .then(function(response) {
            if (response.status == 200) {
                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');
                var jsonData = response.data;
                $.each(jsonData, function (i, item) {
                    $('#projects-update-change').append($('<option>', { 
                        value: item.id ,
                        text : item.name 
                    }));
                });
            } else { 
                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none'); 
            }
            })
            .catch(function(error) {
                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none');
            });
}

// Task Data Update
$('#task-update-confirm-btn').click(function(){
    var task_id = $('#task-edit-id').html();
    var project_id = $('#projects-update-change').val();
    var task_title = $('#task-title-update').val();
    var task_desc = $('#content-update').val();
    TaskUpdate(task_id, project_id, task_title, task_desc);
});
function TaskUpdate(task_id, project_id, task_title, task_desc) {
  if ( project_id.length==0 ) {
    toastr.error('Choose a project!');
  } else if ( task_title.length==0 ) {
    toastr.error('Task Title is Empty !');
  } else if ( task_desc.length==0 ) {
    toastr.error('Task Description is Empty !');
  } else {
    $('#task-update-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/task/update', {
            id: task_id,
            title: task_title,
            description: task_desc,
            project_id: project_id, 
        })
        .then(function(response) {
            $('#task-update-confirm-btn').html("Update");
            if(response.status==200){
                if (response.data == 1) {
                    $('#update-task-modal').modal('hide');
                    toastr.success('Update Success');
                } else {
                    $('#update-task-modal').modal('hide');
                    toastr.error('Update Fail');
                }
                getTaskData();  
            } else {
                $('#update-task-modal').modal('hide');
                toastr.error('Something Went Wrong 1!');
            }   
        })
        .catch(function(error) {
            $('#update-task-modal').modal('hide');
            toastr.error('Something Went Wrong 2!');
        });
    }
}
// Task Data Deleted
$('#task-delete-confirm-btn').click(function(){
    var id= $('#task-delete-id').html();
    TaskDelete(id);
});
function TaskDelete(deleteID) {
    $('#task-delete-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/task/delete', {
        id: deleteID
    })
    .then(function(response) {
        $('#task-delete-confirm-btn').html("Yes");
        if(response.status==200){
            if (response.data == 1) {
                $('#delete-task-modal').modal('hide');
                toastr.success('Delete Success');
            } else {
                $('#delete-task-modal').modal('hide');
                toastr.error('Delete Fail');
                getTaskData();
            }
        } else {
            $('#task-delete-confirm-btn').html("Yes");
            $('#delete-task-modal').modal('hide');
            toastr.error('Something Went Wrong !');
        }
    })
    .catch(function(error) {
        $('#task-delete-confirm-btn').html("Yes");
        $('#delete-task-modal').modal('hide');
        toastr.error('Something Went Wrong !');
    });
}
</script>
@endsection