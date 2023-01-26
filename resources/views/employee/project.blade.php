@extends('Layout.appUser')
@section('title','Projects')
@section('content')

<div id="main-div-project"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3 mt-5">
            <table id="project-data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Id</th>
                        <th class="th-sm">Project Name</th>
                        <th class="th-sm">Created by</th>
                        <th class="th-sm">Created at</th>
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

@endsection

@section('script')
<script type="text/javascript">
// Project data table 
getProjectData();

function getProjectData() {
    axios.get('/user/project?json')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-project').removeClass('d-none');
                $('#loader-div-project').addClass('d-none');
                $('#project-data-table').DataTable().destroy();
                $('#project-table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>"+item.id+"</td>" +
                        "<td>"+item.name+"</td>" +
                        "<td>"+item['user'].name+"</td>" +  
                        "<td>"+item.created_at.substring(0, 10)+"</td>" 
                    ).appendTo('#project-table');
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

</script>
@endsection