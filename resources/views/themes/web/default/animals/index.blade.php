@extends('themes.web.default.layouts.base')

@section('page.title')
	Listado de animales
@stop

@section('page.description')
	En esta página se muestran los animales de la protectora de animales. Se puede acceder a la ficha individual de cada animal y añadir filtros al listado.
@stop

@section('content')

	<h1 class="page-title hidden">Listado de animales</h1>

	<div class="animals row">

		@if (count($animals))
			<h3>Listado de animales <small class="pull-right" style="margin-top: 7px; font-size: 0.6em">{{ $animals->count() }} de {{ $total }}</small></h3>

			<div class="animals-list">
				@foreach ($animals as $animal)
					<div class="col-md-4 col-xs-6 col-sm-4 animal">
						@include('themes.web.default.partials.animal', [
							'animal' => $animal
						])
					</div>
				@endforeach
			</div>

			<div class="clearfix"></div>

			{!! $animals->appends(Request::all())->render() !!}

		@else
			<h4 class="bg-info text-center">No existen fichas de animales.</h4>
		@endif

	</div>

@stop
