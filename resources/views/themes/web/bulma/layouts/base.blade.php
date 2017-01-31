<!DOCTYPE html>
<html>
<head>
    <title>{{ $web->name }}</title>
    <meta name="description" content="{{ $web->description }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ elixir('themes/bulma/css/bulma.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ elixir('themes/bulma/css/app.css') }}">

    @if ($web->hasConfig('themes.bulma.css'))
        <style>
            {{ $web->getConfig('themes.bulma.css') }}
        </style>
    @endif

    <meta property="og:site_name" content="{{ $web->name }}" />

    @include('partials.favicon')

    @section('meta.share')

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="{{ $web->name }}">
        <meta itemprop="description" content="{{ $web->description }}">
        <meta itemprop="image" content="{{ route('web::image', ['file' => $web->logo]) }}">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $web->name }}">
        <meta name="twitter:description" content="{{ $web->description }}">
        <meta name="twitter:image:src" content="{{ route('web::image', ['file' => $web->logo]) }}">

        <!-- Open Graph data -->
        <meta property="og:title" content="{{ $web->name }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ $web->getUrl() }}" />
        <meta property="og:image" content="{{ route('web::image', ['file' => $web->logo]) }}" />
        <meta property="og:description" content="{{ $web->description }}" />

    @show

</head>
<body>

    <div class="container">
        <div class="columns">
            <div class="column is-narrow" style="width: 220px">
                @include('themes.web.bulma.partials.widgets', [
                    'widgets' => $widgets_left,
                    'side' => 'left'
                ])
            </div>
            <div class="column">
                @yield('content')
            </div>
            <div class="column is-narrow" style="width: 220px">
                @include('themes.web.bulma.partials.widgets', [
                    'widgets' => $widgets_right,
                    'side' => 'right'
                ])
            </div>
        </div>
    </div>

    @include('partials.cookies')

    <script type="text/javascript" src="{{ elixir('themes/bulma/js/app.js') }}"></script>
    @include('partials.flash')
    @include('partials.googleanalytics')

    @stack('scripts')

</body>
</html>
