<div class="widgets widgets-{{ $side }}">
    @foreach ($widgets as $widget)
        <div class="widget widget-{{ $widget->type }} card">
            <header class="card-header">
                <p class="card-header-title">
                    {{ $widget->title }}
                </p>
            </header>
            <div class="card-content">
                <div class="content">

                    @if ($widget->type === 'custom')
                        {{ $widget->content }}
                    @elseif ($widget->type === 'protecms')
                        @include('themes.web.bulma.partials.widgets.' . $widget->file)
                    @else
                        <ul>
                            @foreach ($widget->links as $link)
                                <li>
                                    <a href="{{ $link->link }}">
                                        @if (Request::path() === trans_choice('routes.animals', 2))
                                            {!! $link->link == '/' . urldecode(trans_choice('routes.animals', 2) . str_replace(Request::url(), '', Request::fullUrl())) ? '<i class="fa fa-chevron-circle-right"></i> '
                                                : '' !!}
                                        @else
                                            {!!
                                                Request::fullUrl() == $link->link ||
                                                Request::url() == $link->link ||
                                                '/'.Request::path() == $link->link
                                                ? '<i class="fa fa-chevron-circle-right"></i> '
                                                : ''
                                            !!}
                                        @endif
                                        {{ $link->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>