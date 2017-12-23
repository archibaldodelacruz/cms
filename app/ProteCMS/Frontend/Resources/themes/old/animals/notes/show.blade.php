@extends('themes.web.default.layouts.base')

@section('meta.share')
    @if (preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $note->text, $metaimage))
        <meta itemprop="image" content="{{ $web->getUrl() . $metaimage['src'] }}" />
        <meta name="twitter:image:src" content="{{ $web->getUrl() . $metaimage['src'] }}" />
        <meta property="og:image" content="{{ $web->getUrl() . $metaimage['src'] }}" />
    @else
        <meta itemprop="image" content="{{ route('web::image', ['file' => $web->logo]) }}" />
        <meta name="twitter:image:src" content="{{ route('web::image', ['file' => $web->logo]) }}" />
        <meta property="og:image" content="{{ route('web::image', ['file' => $web->logo]) }}" />
    @endif

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $note->title }}">
    <meta itemprop="description" content="{{ strip_tags(str_limit($note->text, 150)) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $note->title }}">
    <meta name="twitter:description" content="{{ strip_tags($note->text) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $note->title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('web::animals::notes::show', ['animal_id' => $note->animal->id, 'id' => $note->id]) }}" />
    <meta property="og:description" content="{{ strip_tags($note->text) }}" />

@stop

@section('content')

    <div class="posts notes">
        <div class="row post note">
            <a href="{{ route('web::animals::show', ['id' => $note->animal->id]) }}#notas" class="btn btn-default"><i class="fa fa-caret-left"></i> Volver a la ficha</a>
            <div class="col-md-12">
                <h3><a href="{{ route('web::animals::notes::show', ['animal_id' => $note->animal->id, 'id' => $note->id]) }}">{{ $note->title }}</a></h3>
                <div class="post-content">{!! $note->text !!}</div>

                <div class="clearfix"></div>
                <div class="post-bottom row">
                    <div class="post-data col-md-4 col-xs-5">
                        <p>
                            <i class="fa fa-user"></i> {{ $note->author->name }}<br>
                            <i class="fa fa-clock-o"></i> {{ $note->published_at->format('d-m-Y') }}
                        </p>
                    </div>
                    <div class="post-share col-md-8 col-xs-7">
                        <p>¡Comparte!</p>

                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('web::animals::notes::show', ['animal_id' => $note->animal->id, 'id' => $note->id]) }}"><i class="fa fa-facebook-square"></i></a>
                        <a href="https://twitter.com/home?status={{ str_limit($note->title, 120, '...') }} - {{ route('web::animals::notes::show', ['animal_id' => $note->animal->id, 'id' => $note->id]) }}"><i class="fa fa-twitter-square"></i></a>
                        <a href="http://pinterest.com/pin/create/link/?url={{ route('web::animals::notes::show', ['animal_id' => $note->animal->id, 'id' => $note->id]) }}"><i class="fa fa-pinterest-square"></i></a>
                        <a href="https://plus.google.com/share?url={{ route('web::animals::notes::show', ['animal_id' => $note->animal->id, 'id' => $note->id]) }}"><i class="fa fa-google-plus-square"></i></a>
                        <a href="mailto:?&subject={{ $note->title }}&body=Echa un vistazo a este enlace: {{ route('web::animals::notes::show', ['animal_id' => $note->animal->id, 'id' => $note->id]) }}"><i class="fa fa-envelope-square"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop