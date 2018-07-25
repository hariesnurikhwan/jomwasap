@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Edit "{{ $url->alias }}" content.</div>
				<div class="panel-body">
					{!! Form::open(['method' => 'POST', 'route' => ['generate.update', $url->hashid]]) !!}

					{{ method_field('PUT') }}

					<div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
						{!! Form::label('alias', 'Short URL') !!}
						<div class="input-group">
							<span class="input-group-addon">https://hi.jomwasap.my/</span>
							{!! Form::text('alias', $url->alias, ['class' => 'form-control']) !!}
						</div>
						<small class="text-danger">{{ $errors->first('alias') }}</small>
						<p class="text-default">If left empty, system will automatically generate the alias.</p>
					</div>

					<input name="type" type="hidden" value="{{$url->type}}" style="display: none;">


					@if($url->type === 'single')
					<div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
						{!! Form::label('mobile_number', 'Mobile Number *') !!}
						{!! Form::text('mobile_number', $url->mobile_number, ['class' => 'form-control', 'required' => 'required']) !!}
						<small class="text-danger">{{ $errors->first('mobile_number') }}</small>
						<p class="text-default">Currently we only support Malaysia (+60) country code.</p>
					</div>
					@elseif($url->type === 'group')
					<div id="displayGroup">
						<div class="form-group">
							<button id="addfield" class="btn btn-primary" onclick="addField()">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</div>
						@php
						$counts = count($url->group->pluck('mobile_number')->toArray());
						echo "<div id='mobile_numbers_count' style='display: none;'>$counts</div>";
						@endphp
						@foreach($url->group as $group)
						<div class="input-group form-group">
							<input value={{$group->mobile_number}} type="text" class="form-control" name="mobile_numbers[]">
							<span class="input-group-btn">
								<i style="padding: 0;" class="btn btn-danger">
									<span style="padding: 10px;" onclick="removeField()" class="glyphicon glyphicon-remove"></span>
								</i>
							</span>
						</div>
						@endforeach
					</div>
					@endif

					<div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
						{!! Form::label('text', 'Pretext Chat') !!}
						{!! Form::textarea('text', $url->text, ['class' => 'form-control']) !!}
						<small class="text-danger">{{ $errors->first('text') }}</small>
					</div>
					<div class="btn-group pull-right">
						{!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
						{!! Form::submit("Update", ['class' => 'btn btn-success']) !!}
					</div>

					{!! Form::close() !!}
				</div>
			</div>
			@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
</div>

<script>

	var count = parseInt($('#mobile_numbers_count').text());

	function addField(){

		count = count + 1;
		console.log(count);
		if (count == 5) {
			$('#addfield').attr("disabled","disabled");
		}

		event.preventDefault();
		displayGroup = $('#displayGroup');
		inputField = `<div class="input-group form-group">
		<input type="text" class="form-control" name="mobile_numbers[]">
		<span class="input-group-btn">
		<i style="padding: 0;" class="btn btn-danger">
		<span style="padding: 10px;" onclick="removeField()" class="glyphicon glyphicon-remove"></span>
		</i>
		</span>
		</div>
		`
		displayGroup.append(inputField);
	}

	function removeField(){
		event.preventDefault();
		count = count - 1;

		$('#addfield').attr("disabled",false);


		target = event.target;

		$(target).parent().parent().parent().remove();
	}



</script>

@endsection
