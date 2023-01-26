@extends('Layout.appUser')
@section('title','Tasks')
@section('content')
<div id="main-div-task"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3 mt-5">
            <table id="task-data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Task title</th>
                        <th class="th-sm">Task description</th>
                        <th class="th-sm">Created by</th>
                        <th class="th-sm">Created at</th>
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

@endsection

@section('script')
<script type="text/javascript">
getTaskData();

function getTaskData() {
    axios.get('/user/task?json')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-task').removeClass('d-none');
                $('#loader-div-task').addClass('d-none');
                $('#task-data-table').DataTable().destroy();
                $('#task-table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {   
                    $('<tr>').html(
                        "<td>" + item.id + "</td>" +
                        "<td>" + item['projectname'].name + "</td>" +
                        "<td>" + item.title + "</td>" +
                        "<td>" + item.description  + "</td>" +
                        "<td>" + item['username'].name  + "</td>" +
                        "<td>" + item.created_at.substring(0, 10) + "</td>"
                    ).appendTo('#task-table');
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
</script>
@endsection