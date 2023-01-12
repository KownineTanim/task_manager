@extends('Layout.app')
@section('title','Dashboard')
@section('content')

<div class="container mt-5">
	<div class="row">
		<div class="col-md-3 p-2">
			<div class="card" style="background:azure;">
				<div class="card-body">
					<h3 class="count-card-text text-center">Total Project</h3>
                    <h4 class="count-card-title text-center">{{$TotalProject}}</h4>
				</div>
			</div>
		</div>

		<div class="col-md-3 p-2">
			<div class="card" style="background:azure;">
				<div class="card-body">
					<h3 class="count-card-text text-center">Total Task</h3>
                    <h4 class="count-card-title text-center">{{$TotalTask}}</h4>
				</div>
			</div>
		</div>

		<div class="col-md-3 p-2">
			<div class="card" style="background:azure;">
				<div class="card-body">
                    <h3 class="count-card-text text-center">Total Employee</h3>
					<h4 class="count-card-title text-center">{{$TotalEmployee}}</h4>
				</div>
			</div>
		</div>

		<div class="col-md-3 p-2">
			<div class="card" style="background:azure;">
				<div class="card-body">
                    <h3 class="count-card-text text-center">Total Assignment</h3>
					<h4 class="count-card-title text-center">{{$TotalAssignment}}</h4>
				</div>
			</div>
		</div>
	</div>
</div>	

@endsection

@section('script')
<script type="text/javascript">


</script>
@endsection