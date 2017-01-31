@extends('themes.web.bulma.layouts.base')

@section('content')

    <div class="posts">
        @foreach ($last_posts as $post)
            <div class="post">
                @include('themes.web.bulma.partials.post', [
                    'post' => $post
                ])
            </div>
        @endforeach

        {!! $last_posts->render() !!}
    </div>

@stop