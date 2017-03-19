@extends('install.layouts.base')

@section('progress')
	<p class="has-text-centered">{{ trans('install.step', ['step' => 1, 'last' => 5]) }}</p>
	<progress class="progress is-success is-large" value="20" max="100">20%</progress>
@stop

@section('content')

	<div class="columns">
		<div class="column is-offset-2 is-8">
			<h2 class="subtitle is-4">{{ trans('install.welcome') }}</h2>
			<p>{{ trans('install.description') }}</p>
			<p>{!! trans('install.contact') !!}</p>
			<p>{{ trans('install.security') }}</p>
		</div>
	</div>

	<div class="columns">
		<div class="column is-offset-4 is-4">
			<form action="{{ route('install::data') }}">
				<div class="field {{ $errors->has('code') ? 'has-error' : '' }}">
					<label for="" class="label">{{ trans('install.security_code') }}</label>
					<p class="control">
						<input type="text" class="input" name="code" value="{{ Request::get('code') }}">
					</p>
					{!! $errors->first('code', '<div class="notification is-danger">:message</div>') !!}
				</div>
				<div class="field">
					<p class="control">
						<input type="submit" class="button is-info is-fullwidth is-medium" value="{{ trans('install.start') }}"></input>
					</p>
				</div>
			</form>
		</div>
	</div>

@stop
