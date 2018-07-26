@extends('layouts.app')

@section('content')


@push('scripts')
<script>

	$(window).on('load', function(){

		let createUrl = new Vue({
			el: '#createUrl',
			data: {
				type: '',
				mobile_number: '{{old('mobile_number')}}',
				inputs: [],
				mobile_numbers: [],
				selected: '{{old('enable_lead_capture')}}',

			},
			methods: {
				addField: function() {
					this.inputs.push({number: '', error: ''})
				},

				removeField: function(index) {
					this.inputs.splice(index, 1);
				}

			},
			updated: function() {
				this.$nextTick(function() {
					if (this.inputs.length >= 5) {
						$('#addField').prop('disabled', true);
					}

					if (this.inputs.length < 5) {
						$('#addField').prop('disabled', false);
					}

					if (this.inputs.length < 2) {
						$('#submit').prop('disabled', true);
					}

					if (this.inputs.length > 1) {
						$('#submit').prop('disabled', false);
					}
				})
			},
			mounted() {
				this.type = '{{old('type')}}';
				@if(old('mobile_numbers'))
				@for($i = 0; $i < count(old('mobile_numbers')); $i++)
				var mobile_number = {
					number: '{!! old('mobile_numbers')[$i] !!}',
					error: '{!! $errors->first('mobile_numbers.' . $i) !!}',
				}
				this.inputs.push(mobile_number);
				@endfor
				@endif

			},

		})
	})


</script>
@endpush

<div id="createUrl" class="container">
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
					<select v-model="type" name="type" class="form-control form-group">
						<option>Select Type</option>
						<option value="single">Single</option>
						<option value="group">Group</option>
					</select>
					<div v-if="type == 'group' " id="displayGroup">
						<div class="form-group">
							<button id="addField" v-on:click.prevent="addField" class="btn btn-primary">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</div>
						<div v-for="(input, index) in inputs">
							<div class="form-group">
								<div class="input-group">
									<input :value="input.number" required name="mobile_numbers[]" class="form-control">
									<div class="input-group-btn">
										<button class="btn btn-danger" v-on:click.prevent="removeField(index)">
											<span class="glyphicon glyphicon-remove"></span>
										</button>
									</div>
								</div>
								<small class="text-danger">@{{ input.error }}</small>
							</div>
						</div>
					</div>
					<div v-if="type == 'single' " id="displaySingle">
						<div class="form-group{{ $errors->has('mobile_number') ? ' has-error' : ''}}">
							<label for="mobile_number">Mobile Number</label>
							<input name="mobile_number" type="text" :value="mobile_number" class="form-control">
							<small class="text-danger">{{$errors->first('mobile_number')}}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('enable_lead') ? ' has-error' : '' }}">
						<label for="enable_lead">Lead Capture</label>
						<select v-model="selected" name="enable_lead_capture">
							<option value="0">Disable</option>
							<option value="1">Enable</option>
						</select>
					</div>
					<div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
						<label for="text">Pretext Chat</label>
						<textarea cols="50" rows="10" name="text" class="form-control"></textarea>
						<small class="text-danger">{{$errors->first('text')}}</small>
					</div>
					<div class="btn-group pull-right">
						<input type="reset" value="Reset" class="btn btn-warning">
						<input id="submit" type="submit" value="Generate" class="btn btn-success">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
