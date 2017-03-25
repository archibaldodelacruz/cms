<!DOCTYPE html>
<html>
<head>
	<title>{{ trans('install.page_title') }} · ProteCMS</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="{{ elixir('assets/install/css/install.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ elixir('assets/install/css/install-plugins.css') }}">

	<link rel="shortcut icon" href="/favicon.png">

	@stack('styles')
</head>
<body>

	<div class="container">
		<header>
			<div class="columns">
				<div class="column is-3">
					<img src="/assets/images/logo_original.png" alt="ProteCMS logo">
				</div>
				<div class="column is-6 has-text-centered">
					<h4 class="title is-3">{{ trans('install.install') }}</h4>
				</div>
				<div class="column is-3">
					<form action="{{ route('install::lang') }}" method="POST">
						{{ csrf_field() }}
						<div class="field has-text-centered">
							<p>{{ trans('general.language') }}</p>
							<span class="select is-fullwidth">
								<select name="lang" onchange="this.form.submit()">
									@foreach (config('app.languages') as $lang)
										<option value="{{ $lang }}" {{ $web->lang === $lang ? 'selected' : '' }}>{{ trans("general.languages.{$lang}") }}</option>
									@endforeach
								</select>
								<small>{{ trans('install.change_lang_alert') }}</small>
							</span>
						</div>
					</form>
				</div>
			</div>
		</header>

		<div class="progress-block">
			@yield('progress')
		</div>

		@yield('content')
	</div>

	<footer>
		<p class="has-text-centered">
			Copyright &copy; {{ date('Y') }} <a href="http://protecms.com" target="_blank">ProteCMS</a>. {{ trans('general.all_rights_reserved') }}.
		</p>
	</footer>

	<script type="text/javascript" src="{{ elixir('assets/install/js/app.js') }}"></script>

	@stack('scripts')
</body>
</html>
