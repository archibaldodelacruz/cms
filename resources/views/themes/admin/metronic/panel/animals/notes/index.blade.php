@extends('themes.admin.metronic.layouts.base')

@section('page.title')
    Ficha de {{ $animal->name }}
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('admin::panel::animals::index') }}">Animales</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('admin::panel::animals::edit', ['id' => $animal->id]) }}">{{ $animal->name }}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('admin::panel::animals::notes::index', ['id' => $animal->id]) }}">Notas</a>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-2 animal-menu">
            @include('themes.admin.metronic.layouts.partials.animalmenu', [
                'animal' => $animal
            ])
        </div>
        <div class="col-md-10">
            <form action="" method="GET">
                <div class="pull-right">
                    Ordenar por <select name="sort" class="margin-bottom-20" onchange="this.form.submit()">
                        <option value="-published_at" {{ $request->get('sort') == '-published_at' ? 'selected' : '' }}>Fecha</option>
                        <option value="published_at" {{ $request->get('sort') == 'published_at' ? 'selected' : '' }}>Fecha (inversa)</option>
                    </select>
                </div>
                <div class="table-scrollable">
                    <table class="table-center table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        <tr class="help-step-2">
                            <th><input type="text" name="translations.title" class="form-control" placeholder="Título..." value="{{ $request->get('translations_title') }}"></th>
                            <th><input type="text" name="published_at" class="form-control datetimerange" placeholder="Fecha de publicación..." value="{{ $request->get('published_at') }}"></th>
                            <th>
                                <select name="status" class="form-control" placeholder="Tipo...">
                                    <option value="">-- Seleccione --</option>
                                    @foreach(config('protecms.animals.notes.status') as $status)
                                        <option value="{{ $status }}" {{ $request->get('status') == $status ? 'selected' : '' }}>{{ trans('animals.notes.status.' . $status) }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="help-step-3">
                                <button type="submit" class="btn btn-block btn-primary">Filtrar</button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($notes))
                            @foreach ($notes as $note)
                                <tr>
                                    <td>{{ $note->title }}</td>
                                    <td>
                                        <span data-toggle="popover" data-placement="top" data-trigger="hover" data-content="{{ $note->published_at->format('d-m-Y H:i:s') }}">
                                            {{ $note->published_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td>{{ trans('animals.notes.status.' . $note->status) }}</td>
                                    <td class="table-actions">
                                        <div class="col-md-6 col-xs-6">
                                            <a href="{{ route('admin::panel::animals::notes::edit', ['animal_id' => $animal->id, 'id' => $note->id]) }}" class="btn btn-primary btn-block">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-xs-6">
                                            <a href="{{ route('admin::panel::animals::notes::delete', ['animal_id' => $animal->id, 'id' => $note->id]) }}" class="btn btn-danger btn-block confirm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No existen notas de {{ $animal->name }} con esos parámetros.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </form>

            {!! $notes->appends($request->all())->links() !!}
        </div>
    </div>
@stop