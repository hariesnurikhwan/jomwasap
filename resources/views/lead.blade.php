@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-md-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					Lead Capture
				</div>
				<div class="card-body">
					{!! Form::open(['method' => 'POST', 'route' => 'lead']) !!}
					<input type="hidden" name="alias" value="{{$alias}}">
					<div class="form-group{{ $errors->has('name') ? 'has-error' : '' }}">
						{!! Form::label('name', 'Name') !!}
						{!! Form::text('name', null, ['class' => 'form-control']) !!}
						<small class="text-danger">{{  $errors->first('name')  }}</small>
					</div>
					<div class="form-group{{ $errors->has('mobile_number') ? 'has-error' : '' }}">
						{!! Form::label('mobile_number', 'Mobile Number') !!}
						{!! Form::text('mobile_number', null, ['class' => 'form-control']) !!}
						<small class="text-danger">{{  $errors->first('mobile_number')  }}</small>
					</div>
					<div class="btn-group pull-right">
						{!! Form::submit("Submit", ['class' => 'btn btn-success']) !!}
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
