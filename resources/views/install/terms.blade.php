@extends('install.layouts.base')

@section('progress')
	<p class="has-text-centered">{{ trans('install.step', ['step' => 4, 'last' => 5]) }}</p>
	<progress class="progress is-success is-large" value="80" max="100">80%</progress>
@stop

@section('content')

	<div class="columns">
		<div class="column is-offset-2 is-8">
			<img src="{{ route('web::image', ['image' => $web->logo]) }}" class="image" alt="" style="margin: 10px auto 30px auto; max-width: 160px">

			<h4 class="text-center" style="margin-top: 50px">Lee y acepta los términos y condiciones del proyecto</h4><br>

			<div class="terms">
				<h4 class="subtitle is-5">INFORMACIÓN RELEVANTE</h4>

				<p>Es requisito necesario para la creación de la página web que se ofrece en este sitio, que lea y acepte los siguientes Términos y Condiciones que a continuación se redactan. El uso de nuestros servicios implicará que usted ha leído y aceptado los Términos y Condiciones de Uso en el presente documento. Todas los servicios que son ofrecidos por nuestro sitio web pudieran ser creadas, cobradas, enviadas o presentadas por una página web tercera y en tal caso estarían sujetas a sus propios Términos y Condiciones.</p>

				<p>El usuario puede elegir y cambiar la clave para su acceso de administración de la cuenta en cualquier momento. ProteCMS no asume la responsabilidad en caso de que entregue dicha clave a terceros.</p>

				<h4 class="subtitle is-5">LICENCIA</h4>

				<p>ProteCMS a través de su sitio web concede una licencia para que los usuarios utilicen los servicios que son ofrecidos en este sitio web de acuerdo a los Términos y Condiciones que se describen en este documento.</p>

				<h4 class="subtitle is-5">USO NO AUTORIZADO</h4>

				<p>En caso de que aplique (para venta de software u otro producto de diseño y programación) usted no puede colocar uno de nuestros servicios, modificado o sin modificar, en un CD, sitio web o ningún otro medio y ofrecerlos para la redistribución o la venta de ningún tipo.</p>

				<p>El uso de los servicios tampoco está autorizado a protectoras, empresas u organizaciones no gubernamentales que tengan ánimo de lucro.</p>

				<h4 class="subtitle is-5">PROPIEDAD</h4>

				<p>Usted no puede declarar propiedad intelectual o exclusiva a ninguno de nuestros servicios, modificado o sin modificar. Todos los servicios son propiedad de los proveedores del contenido. En caso de que no se especifique lo contrario, nuestros servicios se proporcionan sin ningún tipo de garantía, expresa o implícita. En ningún caso este proyecto será responsable de ningún daño incluyendo, pero no limitado a, daños directos, indirectos, especiales, fortuitos o consecuentes u otras pérdidas resultantes del uso o de la imposibilidad de utilizar nuestros servicios.</p>

				<h4 class="subtitle is-5">PRIVACIDAD</h4>

				<p>Este sitio web garantiza que la información personal que usted envía cuenta con la seguridad necesaria. Los datos ingresados por usuario no serán entregados a terceros, salvo que deba ser revelada en cumplimiento a una orden judicial o requerimientos legales.</p>

				<p>La suscripción a boletines de correos electrónicos publicitarios es voluntaria y podría ser cancelada en el panel de administración.</p>

				<p>ProteCMS reserva los derechos de cambiar o de modificar estos términos sin previo aviso.</p>
			</div>

			<form action="{{ route('install::terms_post') }}" method="POST">
				{{ csrf_field() }}

				<div class="field notification is-success {{ $errors->has('terms') ? 'has-error' : '' }}">
					<label for="terms" class="control-label">
						<input type="checkbox" id="terms" name="terms" value="1" required>&nbsp; Acepto los términos y condiciones del proyecto
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
