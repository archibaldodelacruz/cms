@extends('install.layouts.base')

@section('progress')
	<p class="has-text-centered">{{ trans('install.step', ['step' => 5, 'last' => 5]) }}</p>
	<progress class="progress is-success is-large" value="100" max="100">100%</progress>
@stop

@section('content')

	<div class="columns">
		<div class="column is-offset-2 is-8">
			<img src="{{ route('web::image', ['image' => $web->logo]) }}" class="image" alt="" style="margin: 10px auto 30px auto; max-width: 160px">

			<h4 class="has-text-centered subtitle is-4" style="margin-top: 50px">Lee y acepta los términos y condiciones del proyecto</h4><br>

			<p>Has completado todos los pasos con éxito. La página web se ha generado correctamente.</p>
			<p>Ya puedes acceder al panel de administración los datos generados que verás debajo. También los recibiréis en el correo electrónico de la protectora.</p>
			<br>
			<p style="text-decoration: underline;">Datos de la protectora:</p>
			<p><strong>Nombre:</strong> {{ $web->name }}</p>
			<p><strong>Página web:</strong> <a href="{{ $web->getUrl() }}">{{ $web->getUrl() }}</a></p>
			<p><strong>Correo electrónico:</strong> {{ $web->email }}</p>
			<br>
			<p style="text-decoration: underline;">Datos de acceso:</p>
			<p><strong>Correo electrónico:</strong> {{ $web->email }}</p>
			<p><strong>Contraseña:</strong> {{ $password }}</p>
			<br><small>La contraseña se ha generado aleatoriamente y se ha almacenado de forma segura en el servidor. En el panel de administración podrás cambiarla.</small>
			<br>
			<p>¡Y eso es todo! Muchas gracias por confiar en el proyecto. <br>Ahora puedes:</p>

			<div class="col-md-offset-3 col-md-6" style="margin-top: 50px">
				<a href="{{ route('web::index') }}" class="btn btn-success btn-block">Ir a la página web</a>
				<a href="{{ route('admin::panel::index') }}" class="btn btn-success btn-block">Ir al panel de administración</a>
			</div>
		</div>
	</div>

@stop