@extends('install.layouts.base')

@section('progress')
	<p class="has-text-centered">{{ trans('install.step', ['step' => 2, 'last' => 5]) }}</p>
	<progress class="progress is-success is-large" value="40" max="100">40%</progress>
@stop

@section('content')

	<div class="columns">
		<div class="column is-offset-2 is-8">
			<p>{!! trans('install.data.to_start') !!}</p>

			<p>{!! trans('install.data.fields') !!}</p>

			<p>{!! trans('install.data.no_city') !!}</p>

			<br>

			<div class="notification is-warning has-text-centered">
				{!! trans('install.data.private_data') !!}
			</div>

			<br>

			<form action="{{ route('install::data_post') }}" method="POST">
				{{ csrf_field() }}

				<h4 class="title is-5">{{ trans('install.data.shelter_data') }}</h4>
				<div class="field {{ $errors->has('name') ? 'has-error' : '' }}">
					<label for="name" class="label">{{ trans('install.data.name') }}</label>
					<p class="control">
						<input type="text" class="input" name="name" value="{{ old('name') }}" id="name" class="form-control" required placeholder="{{ trans('install.ex') }} Asociación Defensa Animal">
					</p>
					{!! $errors->first('name', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field {{ $errors->has('description') ? 'has-error' : '' }}">
					<label for="description" class="label">{{ trans('install.data.description') }} <small>({{ trans('install.data.description_help') }})</small></label>
					<p class="control">
						<textarea name="description" id="description" class="textarea" required placeholder="{{ trans('install.ex') }} {{ trans('install.data.description_example') }}">{{ old('description') }}</textarea>
					</p>
					{!! $errors->first('description', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field {{ $errors->has('email') ? 'has-error' : '' }}">
					<label for="email" class="label">{{ trans('install.data.email') }}</label>
					<p class="control">
						<input type="email" name="email" value="{{ old('email') }}" id="email" class="input" required placeholder="{{ trans('install.ex') }} contacto@protectora.com">
					</p>
					{!! $errors->first('email', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field {{ $errors->has('phone') ? 'has-error' : '' }}">
					<label for="phone" class="label">{{ trans('install.data.phone') }}</label>
					<p class="control">
						<input type="number" name="phone" id="phone" value="{{ old('phone') }}" class="input" required placeholder="{{ trans('install.ex') }} 600 00 00 00">
					</p>
					{!! $errors->first('phone', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field {{ $errors->has('address') ? 'has-error' : '' }}">
					<label for="address" class="label">{{ trans('install.data.address') }} <small></small></label>
					<p class="control">
						<input type="text" class="input" name="address" id="address" value="{{ old('address') }}" class="form-control" required placeholder="{{ trans('install.ex') }} Avenida Blas S/N">
					</p>
					{!! $errors->first('address', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field {{ $errors->has('country_id') ? 'has-error' : '' }}">
					<label for="country_id" class="label">{{ trans('install.data.country') }}</label>
					<p class="control">
						<span class="select is-fullwidth">
							<select name="country_id" id="country_id" class="select-country is-fullwidth">
								<option value="" disabled selected>{{ trans('install.data.select_country') }}...</option>
								@foreach (App\Models\Location\Country::orderBy('name')->get() as $country)
									<option value="{{ $country->id }}">{{ $country->name }}</option>
								@endforeach
							</select>
						</span>
					</p>
					{!! $errors->first('country_id', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field {{ $errors->has('state_id') ? 'has-error' : '' }}">
					<label for="state_id" class="label">{{ trans('install.data.state') }}</label>
					<p class="control">
						<span class="select is-fullwidth">
							<select name="state_id" id="state_id" class="select-state is-fullwidth" disabled>
								<option value="" disabled selected>{{ trans('install.data.must_select_country') }}...</option>
							</select>
						</span>
					</p>
					{!! $errors->first('state_id', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field {{ $errors->has('city_id') ? 'has-error' : '' }}">
					<label for="city_id" class="label">{{ trans('install.data.city') }}</label>
					<p class="control">
						<span class="select is-fullwidth">
							<select name="city_id" id="city_id" class="select-city is-fullwidth" disabled>
								<option value="" disabled selected>{{ trans('install.data.must_select_state') }}...</option>
							</select>
						</span>
					</p>
					{!! $errors->first('city_id', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<hr>
				<h4 class="title is-5">{{ trans('install.data.other_data') }}</h4>
				<div class="field {{ $errors->has('contact_name') ? 'has-error' : '' }}">
					<label for="contact_name" class="label">{{ trans('install.data.contact_name') }}</label>
					<p class="control">
						<input type="text" class="input" name="contact_name" id="contact_name" value="{{ old('contact_name') }}" class="select" required placeholder="{{ trans('install.ex') }} Jaime Sares">
					</p>
					{!! $errors->first('contact_name', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field {{ $errors->has('contact_email') ? 'has-error' : '' }}">
					<label for="contact_email" class="label">{{ trans('install.data.contact_email') }}</label>
					<p class="control">
						<input type="text" class="input" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" class="form-control" required placeholder="{{ trans('install.ex') }} web@protecms.com">
					</p>
					{!! $errors->first('contact_email', '<div class="notification is-danger">:message</div>') !!}
				</div>

				<div class="field">
					<div class="columns">
						<div class="column is-offset-4 is-4">
							<input type="submit" class="button is-info is-fullwidth is-medium" value="{{ trans('install.continue') }}">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	@push('scripts')
	<script>

		$('.select-country').on('change', function() {

			var country = $('.select-country option:selected').val();

			$('.select-city').find('option').remove();
			$('.select-city').prop('disabled', true);
			$('.select-city').append($('<option>', {
				value: '',
				text: '{{ trans('install.data.must_select_state') }}',
				disabled: true,
				selected: true
			}));

			$.ajax({
				url: '/api/location/countries/' + country + '/states'
			}).done(function(data) {
				$('.select-state').find('option').remove();
				$('.select-state').prop('disabled', false);

				$('.select-state').append($('<option>', {
					value: '',
					text: '{{ trans('install.data.select_state') }}',
					disabled: true,
					selected: true
				}));
				$.each(data, function (i, state) {
					$('.select-state').append($('<option>', {
						value: state.id,
						text: state.name
					}));
				});
			});

		});

		$('.select-state').on('change', function() {

			var state = $('.select-state option:selected').val();

			$.ajax({
				url: '/api/location/states/' + state + '/cities'
			}).done(function(data) {
				$('.select-city').find('option').remove();
				$('.select-city').prop('disabled', false);

				$('.select-city').append($('<option>', {
					value: '',
					text: '{{ trans('install.data.select_city') }}',
					disabled: true,
					selected: true
				}));
				$.each(data, function (i, state) {
					$('.select-city').append($('<option>', {
						value: state.id,
						text: state.name
					}));
				});
			});

		});

	</script>
	@endpush
@stop
