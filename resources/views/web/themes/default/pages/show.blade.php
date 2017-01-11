@extends('web.themes.default.layouts.base')

@section('meta.share')
	@if (preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $page->text, $metaimage))
		<meta itemprop="image" content="{{ $web->getUrl() . $metaimage['src'] }}" />
		<meta name="twitter:image:src" content="{{ $web->getUrl() . $metaimage['src'] }}" />
		<meta property="og:image" content="{{ $web->getUrl() . $metaimage['src'] }}" />
	@else
		<meta itemprop="image" content="{{ route('web::image', ['file' => $web->logo]) }}" />
		<meta name="twitter:image:src" content="{{ route('web::image', ['file' => $web->logo]) }}" />
		<meta property="og:image" content="{{ route('web::image', ['file' => $web->logo]) }}" />
	@endif

	<!-- Schema.org markup for Google+ -->
	<meta itemprop="name" content="{{ $page->title }}">
	<meta itemprop="description" content="{{ strip_tags(str_limit($page->text, 150)) }}">

	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="{{ $page->title }}">
	<meta name="twitter:description" content="{{ strip_tags($page->text) }}">

	<!-- Open Graph data -->
	<meta property="og:title" content="{{ $page->title }}" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="{{ route('web::pages::show', ['id' => $page->id, 'slug' => $page->slug]) }}" />
	<meta property="og:description" content="{{ strip_tags($page->text) }}" />

@stop

@section('content')

	<div class="posts">
		<div class="row post">
			<div class="col-md-12">
				@include('web.themes.default.partials.page', [
					'page' => $page
				])
			</div>
		</div>
	</div>

@stop