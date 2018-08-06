@extends('layouts.app')

@section('content')


@push('scripts')
<script>
	let createUrl = new Vue({
		el: '#createUrl',
		data: {
			type: '{{old('type')}}' || 'Select Type',
			mobile_number: '{{old('mobile_number')}}',
			inputs: [],
			mobile_numbers: [],
			optional: false

		},
		methods: {
			addField: function() {
				this.inputs.push({number: '', error: ''})
			},

			removeField: function(index) {
				this.inputs.splice(index, 1);
			},

			active: function(){

				mainNav = $('#mainNav');
				fbmetaNav = $('#fbmetaNav');

				mainTab = $('#mainTab');
				fbmetaTab = $('#fbmetaTab');

				target = $(event.target).parent();

				if (target[0].id == mainNav[0].id) {
					mainNav.addClass('active');
					mainTab.addClass('active');
					fbmetaNav.removeClass('active');
					fbmetaTab.removeClass('active');
				} else if (target[0].id == fbmetaNav[0].id){
					fbmetaTab.addClass('active');
					fbmetaNav.addClass('active');
					mainNav.removeClass('active');
					mainTab.removeClass('active');
				}
			},

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

				if (this.type == 'single') {
					$('#submit').prop('disabled', false);
				}
			})
		},
		mounted() {
			@if(old('mobile_numbers'))
			@for($i = 0; $i < count(old('mobile_numbers')); $i++)
			var mobile_number = {
				number: '{{old('mobile_numbers')[$i]}}',
				error: '{{ $errors->first('mobile_numbers.' . $i) }}',
			}
			this.inputs.push(mobile_number);
			@endfor
			@else
			this.inputs.push({number: '', error: ''})
			this.inputs.push({number: '', error: ''})
			@endif

			$('#mainNav').addClass('active');
			$('#mainTab').addClass('active show');


		},

	})

</script>
@endpush


<div id="createUrl" v-cloak class="container">
	<div class="card">
		<div class="card-header">
			Generate Clickable WhatsApp Link.
		</div>
		<div class="card-body">
			<form action="{{ route('generate.store') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a v-on:click="active" href="#mainTab" class="nav-link" id="mainNav" data-toggle="tab" role="tab">Main</a>
					</li>
					<li class="nav-item">
						<a v-on:click="active" href="#fbmetaTab" class="nav-link" id="fbmetaNav" data-toggle="tab" role="tab">Facebook Meta</a>
					</li>
				</ul>

				<div class="tab-content">
					<div id="mainTab" class="tab-pane fade" role="tabpanel">
						<div class="form-group">
							<br>
							<label for="alias">Short URL</label>
							<div class="input-group">
								<div class="input-group">
									<span class="input-group-text text-monospace">
										https://hi.jomwasap.my/
									</span>
									<input value="{{old('alias') ? old('alias') : ""}}" type="text" name="alias" class="form-control">
								</div>
							</div>
							<small class="text-danger">{{ $errors->first('alias') }}</small>
							<p class="text-default">If left empty, system will automatically generate the alias.</p>
						</div>
						<div class="form-group">
							<label for="type">Type</label>
							<select v-model="type" name="type" class="form-control form-group">
								<option >Select Type</option>
								<option value="single">Single</option>
								<option value="group">Group</option>
							</select>
							<small class="text-danger">{{ $errors->first('type') }}</small>
						</div>
						<div v-if="type == 'group' " id="displayGroup">
							<div class="form-group">
								<button id="addField" v-on:click.prevent="addField" class="btn btn-primary btn-md">
									<span class="fa fa-plus"></span>
								</button>
							</div>
							<label>Mobile Numbers</label>
							<div v-for="(input, index) in inputs">
								<div class="form-group">
									<div class="input-group">
										<input name="mobile_numbers[]" :value="input.number" required class="form-control">
										<div class="input-group-btn">
											<button class="btn btn-danger" v-on:click.prevent="removeField(index)">
												<span class="fa fa-times"></span>
											</button>
										</div>
									</div>
									<small class="text-danger">@{{ input.error }}</small>
								</div>
							</div>
							<p class="text-default">Currently we only support Malaysia (+60) country code.</p>
						</div>
						<div v-if="type == 'single' " id="displaySingle">
							<div class="form-group">
								<label for="mobile_number">Mobile Number</label>
								<input name="mobile_number" type="text" :value="mobile_number" class="form-control">
								<small class="text-danger">{{ $errors->first('mobile_number') }}</small>
							</div>
							<p class="text-default">Currently we only support Malaysia (+60) country code.</p>
						</div>
						<div class="form-group">
							<label for="enable_lead_capture">Lead Capture</label>
							<select name="enable_lead_capture" class="form-control form-group">
								<option {{!old('enable_lead_capture') ? "selected":""}}>Select one</option>
								<option value="1" {{old("enable_lead_capture") == "1" ? "selected":""}}>Enable</option>
								<option value="0" {{old("enable_lead_capture") == "0" ? "selected":""}}>Disable</option>
							</select>
							<small class="text-danger">{{ $errors->first('enable_lead_capture') }}</small>
						</div>
						<div class="form-group">
							<label for="text">Pretext Chat</label>
							<textarea cols="50" rows="10" name="text" class="form-control">{{ old('text') }}</textarea>
							<small class="text-danger">{{ $errors->first('text') }}</small>
						</div>
					</div>
					<div id="fbmetaTab" class="tab-pane fade" role="tabpanel">
						<br>
						<div class="form-group">
							<label for="title">Title</label>
							<input class="form-control" type="text" name="title" value={{old('title') ? old('title') : ""}}>
							<small class="text-danger">{{$errors->first('title')}}</small>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<input class="form-control" type="text" name="description" value={{old('description') ? old('description') : ""}}>
							<small class="text-danger">{{$errors->first('description')}}</small>
						</div>
						<div class="form-group">
							<label for="image">Image</label>
							<input class="form-control" type="file" name="image">
							<small class="text-danger">{{$errors->first('image')}}</small>
						</div>
					</div>
				</div>
				<div class="btn-group pull-right">
					<input type="reset" value="Reset" class="btn btn-warning">
					<input id="submit" type="submit" value="Generate" class="btn btn-success">
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
