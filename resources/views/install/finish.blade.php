@extends('install.layouts.base')

@section('progress')
	<p class="has-text-centered">{{ trans('install.step', ['step' => 5, 'last' => 5]) }}</p>
	<progress class="progress is-success is-large" value="100" max="100">100%</progress>
@stop

@section('content')

	<div class="columns">
		<div class="column is-offset-2 is-8">

			<h4 class="has-text-centered subtitle is-4" style="margin-top: 50px">{{ trans('install.finish_step.title') }}</h4><br>

			<p>{{ trans('install.finish_step.description') }}</p>
			<p>{{ trans('install.finish_step.description2') }}</p>
			<br>

			<div class="notification">
				<p style="text-decoration: underline;">{{ trans('install.finish_step.shelter_data') }}:</p>
				<p><strong>{{ trans('install.finish_step.name') }}:</strong> {{ $web->name }}</p>
				<p><strong>{{ trans('install.finish_step.url') }}:</strong> <a href="{{ $web->getUrl() }}">{{ $web->getUrl() }}</a></p>
				<p><strong>{{ trans('install.finish_step.email') }}:</strong> {{ $web->email }}</p>
			</div>

			<br>

			<div class="notification">
				<p style="text-decoration: underline;">{{ trans('install.finish_step.access_data') }}:</p>
				<p><strong>{{ trans('install.finish_step.email') }}:</strong> {{ $web->email }}</p>
				<p><strong>{{ trans('install.finish_step.password') }}:</strong> {{ $password }}</p>
			</div>

			<small>{{ trans('install.finish_step.password_saved') }}</small>
			<br><br>
			<p class="has-text-centered">{!! trans('install.finish_step.last_text') !!}</p>
			<br>

			<div class="columns">
				<div class="column is-offset-3 is-6">
					<a href="{{ route('web::index') }}" target="_blank" class="button is-info is-fullwidth is-medium">{{ trans('install.finish_step.go_web') }}</a>
					<br>
					<a href="{{ route('admin::panel::index') }}" target="_blank" class="button is-info is-fullwidth is-medium">{{ trans('install.finish_step.go_admin') }}</a>
				</div>
			</div>

			<br>
		</div>
	</div>

@stop