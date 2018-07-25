@extends('layouts.app')

@section('content')

<script>

	var count = 0;


	function display(){
		type = event.target.value;
		displaySingle = $('#displaySingle');
		displayGroup = $('#displayGroup');
		if(type === 'single'){
			displayGroup.hide();
			displaySingle.show();
		} else if(type === 'group'){
			displayGroup.show();
			displaySingle.hide();
		}
	}

	function addField(){

		count = count + 1;

		if (count == 5) {
			$('#addfield').attr("disabled","disabled");
		}

		event.preventDefault();
		displayGroup = $('#displayGroup');
		inputField = `<div class="input-group form-group">
		<input required class="form-control" name="mobile_numbers[]">
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


		target = event.target

		$(target).parent().parent().parent().remove();
	}

	function oldField(number, error){
		count = count + 1;

		inputField = `<div class="form-group">
		<div class="input-group"><input required value="${number}" type="text" class="form-control" name="mobile_numbers[]">
		<span class="input-group-btn">
		<i style="padding: 0;" class="btn btn-danger">
		<span style="padding: 10px;" onclick="removeField()" class="glyphicon glyphicon-remove"></span></i></span></div>
		<small class="text-danger">${error}</small>
		</div>
		`
		displayGroup = $('#displayGroup');
		displayGroup.append(inputField);
	}

</script>


<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Generate Clickable WhatsApp Link.</div>
				<div class="panel-body">
					{!! Form::open(['method' => 'POST', 'route' => 'generate.store']) !!}

					<div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
						{!! Form::label('alias', 'Short URL') !!}
						<div class="input-group">
							<span class="input-group-addon">https://hi.jomwasap.my/</span>
							{!! Form::text('alias', null, ['class' => 'form-control']) !!}
						</div>
						<small class="text-danger">{{ $errors->first('alias') }}</small>
						<p class="text-default">If left empty, system will automatically generate the alias.</p>
					</div>


					@if (!old('type'))
					<select id="select-type" onchange="display()" name="type" class="form-control form-group">
						<option>Select Type</option>
						<option value="single">Single</option>
						<option value="group">Group</option>
					</select>

					<div style="display: none" id="displayGroup">
						<div class="form-group">
							<button id="addfield" class="btn btn-primary" onclick="addField()">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</div>
					</div>
					<p class="text-default">Currently we only support Malaysia (+60) country code.</p>

					<div style="display: none" id="displaySingle">
						<div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
							{!! Form::label('mobile_number', 'Mobile Number *') !!}
							{!! Form::text('mobile_number', null, ['class' => 'form-control']) !!}
							<small class="text-danger">{{ $errors->first('mobile_number') }}</small>
							<p class="text-default">Currently we only support Malaysia (+60) country code.</p>
						</div>
					</div>

					@elseif (old('type') === 'single')
					<select id="select-type" onchange="display()" name="type" class="form-control form-group">
						<option>Select Type</option>
						<option selected value="single">Single</option>
						<option value="group">Group</option>
					</select>

					<div style="display: block" id="displaySingle">
						<div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
							{!! Form::label('mobile_number', 'Mobile Number *') !!}
							{!! Form::text('mobile_number', null, ['class' => 'form-control']) !!}
							<small class="text-danger">{{ $errors->first('mobile_number') }}</small>
							<p class="text-default">Currently we only support Malaysia (+60) country code.</p>
						</div>
					</div>

					<div style="display: none" id="displayGroup">
						<div class="form-group">
							<button id="addfield" class="btn btn-primary" onclick="addField()">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</div>
					</div>

					@elseif (old('type') === 'group')

					<select id="select-type" onchange="display()" name="type" class="form-control form-group">
						<option>Select Type</option>
						<option value="single">Single</option>
						<option selected value="group">Group</option>
					</select>

					<div style="display: none" id="displaySingle">
						<div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : '' }}">
							{!! Form::label('mobile_number', 'Mobile Number *') !!}
							{!! Form::text('mobile_number', null, ['class' => 'form-control']) !!}
							<small class="text-danger">{{ $errors->first('mobile_number') }}</small>
							<p class="text-default">Currently we only support Malaysia (+60) country code.</p>
						</div>
					</div>
					<div style="display: block" id="displayGroup">
						<div class="form-group{{ $errors->has('mobile_numbers') ? ' has-error' : '' }}">
							<button id="addfield" class="btn btn-primary" onclick="addField()">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
							<small class="text-danger">{{$errors->first('mobile_numbers')}}</small>
							@if(old('mobile_numbers'));
							@for($i = 0; $i < count(old('mobile_numbers')); $i++)
							<script>
								number = '{!! old('mobile_numbers')[$i] !!}';
								error = '{!! $errors->first('mobile_numbers.' . $i) !!}';
								oldField(number, error);
							</script>
							@endfor
							@endif
						</div>
					</div>

					@endif


					<div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
						{!! Form::label('text', 'Pretext Chat') !!}
						{!! Form::textarea('text', null, ['class' => 'form-control']) !!}
						<small class="text-danger">{{ $errors->first('text') }}</small>
					</div>

					<div class="btn-group pull-right">
						{!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
						{!! Form::submit("Generate", ['class' => 'btn btn-success']) !!}
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
