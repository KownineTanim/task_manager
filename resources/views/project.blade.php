@extends('Layout.app')
@section('title','Projects')
@section('content')

<div id="mainDivProject"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="addProjectBtn" class="btn my-3 btn-sm btn-danger">Add New </button>
            <table id="ProjectDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Short Description</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="Project_table">

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

<!-- Project add modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="ProjectName" type="text" class="form-control mb-3" placeholder="Project Name">
                            <input id="ProjectDes" type="text"  class="form-control mb-3" placeholder="Project Short Description">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="ProjectAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Project Edit Modal -->

<div class="modal fade" id="updateProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
      
                <h5 id="ProjectEditId" class="mt-4 d-none">  </h5>

                    <div id="ProjectEditForm" class="container d-none">

                        <div class="row">
                            <div class="col-md-12">
                                <input id="ProjectNameUpdate" type="text" class="form-control mb-3">
                                <input id="ProjectDesUpdate" type="text" class="form-control mb-3">  
                            </div>
                        </div>

                        <img id="ProjectEditLoader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
                        <h5 id="ProjectEditWrong" class="d-none">Something Went Wrong !</h5>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                        <button  id="ProjectUpdateConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Update</button>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Project Data Deleted -->

<div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-3 text-center">
        <h5 class="mt-4">Do You Want To Delete?</h5>
        <h5 id="ProjectDeleteId" class="mt-4 d-none">   </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
        <button  id="ProjectDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
// Project data table 
getProjectData();

function getProjectData() {
    axios.get('/getProjectData')
        .then(function(response) {
            if (response.status == 200) {
                $('#mainDivProject').removeClass('d-none');
                $('#loaderDivProject').addClass('d-none');
                $('#ProjectDataTable').DataTable().destroy();
                
                $('#Project_table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>"+jsonData[i].project_name+"</td>" +
                        "<td>"+jsonData[i].project_desc+"</td>" +  
                        "<td><a class='ProjectEditBtn' data-id="+jsonData[i].id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='ProjectDeleteBtn' data-id="+jsonData[i].id+"><i class='fas fa-trash-alt'></i></a></td>"
                    ).appendTo('#Project_table');
                });
                     $('.ProjectDeleteBtn').click(function(){
                       
                      var id= $(this).data('id');
                     $('#ProjectDeleteId').html(id);
                     $('#deleteProjectModal').modal('show');
                     })
                     $('.ProjectEditBtn').click(function(){
                        var id= $(this).data('id');
                        ProjectUpdateDetails(id);
                        $('#ProjectEditId').html(id);
                        $('#updateProjectModal').modal('show');
                     })
                  $('#ProjectDataTable').DataTable({"order":false});
                  $('.dataTables_length').addClass('bs-select');
            } else {
                $('#loaderDivProject').addClass('d-none');
                $('#WrongDivProject').removeClass('d-none');
            }
        })
        .catch(function(error) {
                $('#loaderDivProject').addClass('d-none');
                $('#WrongDivProject').removeClass('d-none');
        });
}
// Project data add
$('#addProjectBtn').click(function(){
    $('#addProjectModal').modal('show');
});

$('#ProjectAddConfirmBtn').click(function(){
  var ProjectName=$('#ProjectName').val();
  var ProjectDes=$('#ProjectDes').val();
    ProjectAdd(ProjectName,ProjectDes);
});

function ProjectAdd(ProjectName,ProjectDes) {
  
  if(ProjectName.length==0){
   toastr.error('Project Name is Empty !');
  }
  else if(ProjectDes.length==0){
   toastr.error('Project Description is Empty !');
  }
  else{
  $('#ProjectAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
  axios.post('/ProjectAdd', {
          project_name: ProjectName,
          project_desc: ProjectDes,                                   
      })
    .then(function(response) {
          $('#ProjectAddConfirmBtn').html("Save");
          if(response.status==200){
            if (response.data == 1) {
              $('#addProjectModal').modal('hide');
              toastr.success('Add Success');
          } else {
              $('#addProjectModal').modal('hide');
              toastr.error('Add Fail');
          }  
       } 
       else{
           $('#addProjectModal').modal('hide');
           toastr.error('Something Went Wrong !');
       }   
  })
  .catch(function(error) {
           $('#addProjectModal').modal('hide');
           toastr.error('Something Went Wrong !');
 });
}
}

// Project Edit Data
function ProjectUpdateDetails(detailsID){
    axios.post('/getProjectDetails', {
    id: detailsID
})
.then(function(response) {
    if(response.status==200){
        $('#ProjectEditForm').removeClass('d-none');
        $('#ProjectEditLoader').addClass('d-none');    
        var jsonData = response.data;
        $('#ProjectNameUpdate').val(jsonData[0].project_name);
        $('#ProjectDesUpdate').val(jsonData[0].project_desc);
}
                  
    else{
            $('#ProjectEditLoader').addClass('d-none');
            $('#ProjectEditWrong').removeClass('d-none');
        }
})
    .catch(function(error) {
            $('#ProjectEditLoader').addClass('d-none');
            $('#ProjectEditWrong').removeClass('d-none');
        });
}

// Project Data Updated
$('#ProjectUpdateConfirmBtn').click(function(){
var ProjectID=$('#ProjectEditId').html();
var  ProjectName=$('#ProjectNameUpdate').val();
var  ProjectDes=$('#ProjectDesUpdate').val();
ProjectUpdate(ProjectID,ProjectName,ProjectDes);
})

function ProjectUpdate(ProjectID,ProjectName,ProjectDes) {
  
  if(ProjectName.length==0){
   toastr.error('Project Name is Empty !');
  }
  else if(ProjectDes.length==0){
   toastr.error('Project Description is Empty !');
  }
  else{
  $('#ProjectUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
  axios.post('/ProjectUpdate', {
          id: ProjectID,
          project_name:ProjectName,
          project_desc:ProjectDes, 
      })
      .then(function(response) {
          $('#ProjectUpdateConfirmBtn').html("Update");
          if(response.status==200){
            if (response.data == 1) {
              $('#updateProjectModal').modal('hide');
              toastr.success('Update Success');
              getProjectData();
          } else {
              $('#updateProjectModal').modal('hide');
              toastr.error('Update Fail');
              getProjectData();
          }  
       } 
       else{
          $('#updateProjectModal').modal('hide');
           toastr.error('Something Went Wrong !');
       }   
  })
  .catch(function(error) {
      $('#updateProjectModal').modal('hide');
      toastr.error('Something Went Wrong !');
 });
}
}

// Project Data Deleted
$('#ProjectDeleteConfirmBtn').click(function(){
   var id= $('#ProjectDeleteId').html();
   ProjectDelete(id);
})

 function ProjectDelete(deleteID) {
  $('#ProjectDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/ProjectDelete', {
            id: deleteID
        })
        .then(function(response) {
            $('#ProjectDeleteConfirmBtn').html("Yes");
            if(response.status==200){
            if (response.data == 1) {
                $('#deleteProjectModal').modal('hide');
                toastr.success('Delete Success');
        getProjectData();
            } else {
                $('#deleteProjectModal').modal('hide');
                toastr.error('Delete Fail');
        getProjectData();
            }
            }
            else{
              $('#ProjectDeleteConfirmBtn').html("Yes");
             $('#deleteProjectModal').modal('hide');
             toastr.error('Something Went Wrong !');
            }
        })
        .catch(function(error) {
             $('#ProjectDeleteConfirmBtn').html("Yes");
             $('#deleteProjectModal').modal('hide');
             toastr.error('Something Went Wrong !');
        });
}

</script>
@endsection