@extends('Layout.app')
@section('title','Projects')
@section('content')

<div id="main-div-project"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3">
            <button id="add-project-btn" class="btn my-3 btn-sm btn-danger">Add Project </button>
            <table id="project-data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Created by</th>
                        <th class="th-sm">Created at</th>
                        <th class="th-sm">Edit</th>
                        <th class="th-sm">Delete</th>
                    </tr>
                </thead>
                <tbody id="project-table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- loader div -->
<div id="loader-div-project" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
        </div>
    </div>
</div>

<!-- Something Went Wrong ! -->
<div id="wrong-div-project" class="container d-none">
    <div class="row">
        <div class="col-md-12 text-center p-5">
            <h3>Something Went Wrong !</h3>
        </div>
    </div>
</div>

<!-- Project add modal -->
<div class="modal fade" id="add-project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input id="project-name" type="text" class="form-control mb-3" placeholder="Project Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="project-add-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Project Edit Modal -->

<div class="modal fade" id="update-project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
                <h5 id="project-edit-id" class="mt-4 d-none">  </h5>
                <div id="project-edit-form" class="container d-none">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="project-name-update" type="text" class="form-control mb-3"> 
                        </div>
                    </div>
                        <img id="project-edit-loader" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
                        <h5 id="project-edit-wrong" class="d-none">Something Went Wrong !</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="project-update-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Project Data Deleted -->

<div class="modal fade" id="delete-project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-3 text-center">
        <h5 class="mt-4">Do You Want To Delete?</h5>
        <h5 id="project-delete-id" class="mt-4 d-none">   </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
        <button  id="project-delete-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
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
    axios.get('/project?json')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-project').removeClass('d-none');
                $('#loader-div-project').addClass('d-none');
                $('#project-data-table').DataTable().destroy();
                $('#project-table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>"+item.name+"</td>" +
                        "<td>"+item['user'].name+"</td>" +  
                        "<td>"+item.created_at.substring(0, 10)+"</td>" +
                        "<td><a class='project-edit-btn' data-id="+item.id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='project-delete-btn' data-id="+item.id+"><i class='fas fa-trash-alt'></i></a></td>"
                    ).appendTo('#project-table');
                });
                $('.project-delete-btn').click(function(){
                    var id= $(this).data('id');
                        $('#project-delete-id').html(id);
                        $('#delete-project-modal').modal('show');
                });
                $('.project-edit-btn').click(function(){
                    var id= $(this).data('id');
                    ProjectUpdateDetails(id);
                    $('#project-edit-id').html(id);
                    $('#update-project-modal').modal('show');
                });
                $('#project-data-table').DataTable({"order":false});
                $('.dataTables_length').addClass('bs-select');
            } else {
                $('#loader-div-project').addClass('d-none');
                $('#wrong-div-project').removeClass('d-none');
            }
        })
        .catch(function(error) {
            $('#loader-div-project').addClass('d-none');
            $('#wrong-div-project').removeClass('d-none');
        });
}
// Project data add modal open
$('#add-project-btn').click(function() {
    $('#add-project-modal').modal('show');
});
// Project data add
$('#project-add-confirm-btn').click(function() {
    var name = $('#project-name').val();
    ProjectAdd(name);
});
function ProjectAdd (name) {
    if (name.length==0) {
        toastr.error('Project Name is Empty !');
    } else {
        $('#ProjectAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/project/add', {
            name: name,                                  
        })
        .then(function(response) {
            $('#ProjectAddConfirmBtn').html("Save");
            if ( response.status==200 ) {
                if (response.data == 1) {
                    $('#add-project-modal').modal('hide');
                    toastr.success('Add Success');
                    $('#project-name').val('');
                } else {
                    $('#add-project-modal').modal('hide');
                    toastr.error('Add Fail');
                }
                getProjectData(); 
            } else {
                $('#add-project-modal').modal('hide');
                toastr.error('Something Went Wrong 1!');
            }   
        })
        .catch(function(error) {
            $('#add-project-modal').modal('hide');
            toastr.error('Something Went Wrong 2!');
        });
    }
}

// Project Edit Data
function ProjectUpdateDetails(detailsID){
    axios.post('/project/getDetails', {
        id: detailsID
    })
    .then(function(response) {
        if (response.status == 200) {
            $('#project-edit-form').removeClass('d-none');
            $('#project-edit-loader').addClass('d-none');    
            var jsonData = response.data;
            $('#project-name-update').val(jsonData.name);
        } else {
            $('#project-edit-loader').addClass('d-none');
            $('#project-edit-wrong').removeClass('d-none');
        }
    })
    .catch(function(error) {
        $('#project-edit-loader').addClass('d-none');
        $('#project-edit-wrong').removeClass('d-none');
    });
}

// Project Data Updated
$('#project-update-confirm-btn').click(function(){
    var project_id = $('#project-edit-id').html();
    var project_name = $('#project-name-update').val();
    ProjectUpdate(project_id, project_name);
});
function ProjectUpdate(project_id, project_name) {
    if(project_name.length==0){
        toastr.error('Project Name is Empty !');
    } else {
        $('#project-update-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/project/update', {
            id: project_id,
            name: project_name,
        })
        .then(function(response) {
            $('#project-update-confirm-btn').html("Update");

            if(response.status == 200){
                if (response.data == 1) {
                    $('#update-project-modal').modal('hide');
                    toastr.success('Update Success');
                } else {
                    $('#update-project-modal').modal('hide');
                    toastr.error('Update Fail');
                }
                getProjectData();
            } else {
                $('#update-project-modal').modal('hide');
                toastr.error('Something Went Wrong 1!');
            }   
        })
        .catch(function(error) {
            $('#update-project-modal').modal('hide');
            toastr.error('Something Went Wrong 2!');
        });
    }
}
// Project Data Deleted
$('#project-delete-confirm-btn').click(function(){
   var id= $('#project-delete-id').html();
   ProjectDelete(id);
})
 function ProjectDelete(deleteID) {
    $('#project-delete-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/project/delete', {
        id: deleteID
    })
    .then(function(response) {
        $('#project-delete-confirm-btn').html("Yes");
            if(response.status==200){
                if (response.data == 1) {
                    $('#delete-project-modal').modal('hide');
                    toastr.success('Delete Success');
                } else {
                    $('#delete-project-modal').modal('hide');
                    toastr.error('Delete Fail');
                }
                getProjectData();
            } else {
                $('#project-delete-confirm-btn').html("Yes");
                $('#delete-project-modal').modal('hide');
                toastr.error('Something Went Wrong 1!');
            }
    })
    .catch(function(error) {
        $('#project-delete-confirm-btn').html("Yes");
        $('#delete-project-modal').modal('hide');
        toastr.error('Something Went Wrong 2!');
    });
}
</script>
@endsection