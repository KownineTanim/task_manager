@extends('Layout.appUser')
@section('title','Assignment')
@section('content')

<div id="main-div-assignment"  class="container ">
    <div class="row">
        <div class="col-md-12 p-3 mt-5">
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
                <h5 class="modal-title">Task timer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body  text-center">
            <div class="container">
                <div class="row">
                        <div class="wrapper col-md-12">
                            <input type="hidden" id="timer_task_id">
                            <p><span id="timer-human">00:00</span><span class="d-none" id="timer">00</span></p>
                            <p><button id="start-assignment-confirm-btn" onclick="stopTimer(event)" class="btn btn-sm btn-danger">Stop</button></p>
                        </div> 
                    </div>
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
    axios.get('/user/task-assigned?json')
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
                        "<td>" + new Date(item.consumed_time * 1000).toISOString().substring(11, 19)  + "</td>" +
                        "<td>" + item['user'].name  + "</td>" +
                        "<td>" + item.created_at.substring(0, 10)  + "</td>" +
                        "<td><button class='btn my-3 btn-sm btn-success font-weight-bold start-assignment-btn' data-id='"+item.id+"' onclick='startTimer("+item.id+", event)'>Start now</button></td>"
                    ).appendTo('#assignment-table');
                });
                $('#assignment-data-table').DataTable({"order":false});
                $('.dataTables_length').addClass('bs-select'); 

                let active_task_id = localStorage.getItem(`active_timer`);

                if(active_task_id) {
                    startTimer(active_task_id, {
                        target : document.querySelector(`[data-id='${active_task_id}']`)
                    });
                }
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

// Task Manager Time Update
function stopTimer(event) {
    clearInterval(window.myInterval);
    localStorage.removeItem(`active_timer`);
    let task_id = $('#timer_task_id').val();
    let consumed_time = localStorage.getItem(`time_for_${task_id}`);
    localStorage.removeItem(`time_for_${task_id}`)

    $('#start-assignment-confirm-btn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/user/task-start', {
        id: task_id,
        consumed_time: consumed_time
    })
    .then(function(response) {
        $('#start-assignment-confirm-btn').html("Start");
        if(response.status == 200){
            if (response.data == 1) {
                $('#start-assignment-modal').modal('hide');
                toastr.success('Time Updated');
                window.location.reload();
            } else {
                $('#start-assignment-modal').modal('hide');
                toastr.error('Time Update Fail');
            } 
        } else {
            $('#start-assignment-modal').modal('hide');
            toastr.error('Something Went Wrong!');
        }   
    })
    .catch(function(error) {
        $('#start-assignment-modal').modal('hide');
        toastr.error('Something Went Wrong!');
    });
}

function startTimer(task_id, event) {
    let active_timer = localStorage.getItem(`active_timer`);
    
    if(active_timer && active_timer == task_id && parseInt(document.querySelector('#timer').innerText) != 0) {
        $('#start-assignment-modal').modal('show');
        return;
    } else if (active_timer && active_timer != task_id) {
        toastr.warning('Another Timer Is Running!');
        return;
    }

    window.myInterval = setInterval(() => {
        let savedTime = localStorage.getItem(`time_for_${task_id}`);
        if (!savedTime) {
            savedTime = parseInt(document.querySelector('#timer').innerText);
        }
        savedTime++;
        document.querySelector('#timer').innerHTML = `${savedTime}`;
        document.querySelector('#timer-human').innerHTML = event.target.innerHTML = new Date(savedTime * 1000).toISOString().substring(11, 19);
        localStorage.setItem(`time_for_${task_id}`, savedTime);
    },1000);
    $('#start-assignment-modal').modal('show');
    $('#timer_task_id').val(task_id);
    localStorage.setItem(`active_timer`, task_id);
}
</script>
@endsection