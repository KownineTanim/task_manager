@extends('Layout.appUser')
@section('title','Assignment')
@section('content')

<div id="main-div-assignment"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3 mt-5">
        <!-- <button class='btn my-3 btn-sm btn-danger start-assignment-btn'>Start now</button> -->
            <table id="assignment-data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Id</th>
                        <th class="th-sm">Employee Name</th>
                        <th class="th-sm">Task Name</th>
                        <th class="th-sm">Consumed Time</th>
                        <th class="th-sm">Assigned by</th>
                        <th class="th-sm">Created at</th>
                        <th class="th-sm">Action</th>
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

<!-- Assignment start modal -->
<div class="modal fade" id="start-assignment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Start timer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
            <h5 id="assignment-id" class="mt-4 d-none">  </h5>
                <div class="container">
                <div class="row">
                        <div class="wrapper col-md-12">
                            <p><span id="timer-human">00</span>:<span id="timer">00</span></p>
                            <p><button id="timer-btn">Timer</button></p>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
                    <button  id="start-assignment-confirm-btn" type="button" class="btn  btn-sm  btn-danger">Update</button>
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
    axios.get('/user/assignment?json')
        .then(function(response) {
            if (response.status == 200) {
                $('#main-div-assignment').removeClass('d-none');
                $('#loader-div-assignment').addClass('d-none');
                $('#assignment-data-table').DataTable().destroy();
                $('#assignment-table').empty();
                var jsonData = response.data;
                $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>" + item.id + "</td>" +
                        "<td>" + item['employee'].name + "</td>" +
                        "<td>" + item['taskname'].title + "</td>" +
                        "<td>" + item.consumed_time  + "</td>" +
                        "<td>" + item['user'].name  + "</td>" +
                        "<td>" + item.created_at.substring(0, 10)  + "</td>" +
                        "<td><button class='btn my-3 btn-sm btn-danger start-assignment-btn' data-id=" + item.id + ">Start now</button></td>"
                    ).appendTo('#assignment-table');
                });
                // start assignment modal open
                $('.start-assignment-btn').click(function(){
                    var id= $(this).data('id');
                    $('#assignment-id').html(id);
                    $('#start-assignment-modal').modal('show');
                });
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
// Timer starts here
var button = document.getElementById("timer-btn");
var timer = document.getElementById("timer");
var timer_human = document.getElementById("#timer-human");
var time = 0;
var myInterval = -1;
button.addEventListener("click", function(event){
    if (myInterval == -1) {
        button.innerHTML = "Pause";
        myInterval = setInterval(function(){
            let savedTime = localStorage.getItem('time');
            if (!savedTime) {
                savedTime = parseInt(document.querySelector('#timer').innerText);
            }
            savedTime++;
            document.querySelector('#timer').innerHTML = `${savedTime}`;
            document.querySelector('#timer-human').innerHTML = new Date(savedTime * 1000).toISOString().substring(11, 19);
            localStorage.setItem('time', savedTime);
        },1000);
    } else {
        button.innerHTML = "Start";
        clearInterval(myInterval);
        myInterval = -1;
    }
});
// Timer ends here

// Assignment Time Update
$('#start-assignment-confirm-btn').click(function(){
    var assignment_id = $('#assignment-id').html();
    var timer = $('#timer').html();
    AssignmentStart(assignment_id, timer);
});
function AssignmentStart(assignment_id, timer) {
    $('#start-assignment-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
        axios.post('/user/start', {
            id: assignment_id,
            consumed_time: timer,
        })
        .then(function(response) {
            $('#start-assignment-confirm-btn').html("Update");
            if(response.status==200){
                if (response.data == 1) {
                    $('#start-assignment-modal').modal('hide');
                    toastr.success('Time Updated');
                    document.querySelector('#timer').innerHTML = 0;
                } else {
                    $('#start-assignment-modal').modal('hide');
                    toastr.error('Time Update Fail');
                }
                getAssignmentData();  
            } else {
                $('#start-assignment-modal').modal('hide');
                toastr.error('Something Went Wrong 1!');
            }   
        })
        .catch(function(error) {
            $('#start-assignment-modal').modal('hide');
            toastr.error('Something Went Wrong 2!');
        });
}

</script>
@endsection