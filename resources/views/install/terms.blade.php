@extends('install.layouts.base')

@section('progress')
	<p class="has-text-centered">{{ trans('install.step', ['step' => 4, 'last' => 5]) }}</p>
	<progress class="progress is-success is-large" value="80" max="100">80%</progress>
@stop

@section('content')

	<div class="columns">
		<div class="column is-offset-2 is-8">
			<img src="{{ route('web::image', ['image' => $web->logo]) }}" class="image" alt="" style="margin: 10px auto 30px auto; max-width: 160px">

			<h4 class="title is-4 has-text-centered">{{ trans('install.terms.title') }}</h4><br>

			<div class="terms">
				{!! trans('install.terms.terms') !!}
			</div>

			<form action="{{ route('install::terms_post') }}" method="POST">
				{{ csrf_field() }}

				<div class="field notification is-success {{ $errors->has('terms') ? 'has-error' : '' }}">
					<label for="terms" class="control-label">
						<input type="checkbox" id="terms" name="terms" value="1" required>&nbsp;{{ trans('install.terms.accept') }}
						{!! $errors->first('terms', '<span class="help-block">:message</span>') !!}
					</label>
				</div>

				<div class="field">
					<div class="columns">
						<div class="column is-offset-4 is-4">
							<input type="submit" class="button is-info is-fullwidth is-medium" value="{{ trans('install.finish') }}">
						</div>
					</div>
				</div>

			</form>
		</div>
	</div>

@stop
