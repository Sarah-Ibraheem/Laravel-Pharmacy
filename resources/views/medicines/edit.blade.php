@extends ("app")

@section('content')
	<div class="col-md-8 order-md-1">
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		<h4 class="mb-3">Edit Medicine Form</h4>
		<form method="POST" action="{{route('dashboard.medicines.update', ['medicine'=>$medicine->id])}}">
			@method('PATCH')
			@csrf
			<div class="mb-3">
				<label for="name">Name</label>
				<input type="text" class="form-control" id="name" placeholder="" value="{{$medicine->name}}" name="name">
			</div>
			<div class="mb-3">
				<label for="type">Type</label>
				<input type="text" class="form-control" id="type" placeholder="" value="{{$medicine->type}}" name="type">
			</div>
			<hr class="mb-4">
			<button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
			<br>
			<a class="btn btn-lg btn-block btn-success" href="{{route('dashboard.medicines.index')}}">Cancel</a>
		</form>
	</div>
@endsection