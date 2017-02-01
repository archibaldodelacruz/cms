@extends('themes.admin.metronic.layouts.base')

@section('page.title')
    Actualizar nota: {{ $note->hasTranslation($langform) ? $note->translate($langform)->title : '' }}
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
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('admin::panel::animals::notes::edit', ['animal_id' => $animal->id, 'id' => $note->id]) }}">Actualizar nota</a>
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
            <div class="portlet light bordered form-fit">
                <div class="portlet-body form">
                    <form action="{{ route('admin::panel::animals::notes::update', ['animal_id' => $animal->id, 'id' => $note->id]) }}" method="POST" class="form-horizontal form-bordered form-label-stripped">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="langform" value="{{ $langform }}">
                        <div class="form-group {{ $errors->has($langform.'.title') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.title')) }}</label>
                            <div class="col-md-10">
                                <input type="text" name="{{ $langform }}[title]" value="{{ $note->hasTranslation($langform) ? $note->translate($langform)->title : '' }}" class="form-control" required>
                                {!! $errors->first($langform .'.title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.status')) }}</label>
                            <div class="col-md-10">
                                <select name="status" class="form-control" placeholder="Estado...">
                                    @foreach(config('protecms.animals.notes.status') as $status)
                                        <option value="{{ $status }}" {{ $note->status == $status ? 'selected' : '' }}>{{ trans('animals.notes.status.' . $status) }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('published_at') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.published_at')) }}</label>
                            <div class="col-md-10">
                                <input type="text" name="published_at" value="{{ $note->published_at->format('d-m-Y H:i:s') }}" class="form-control datetimepicker" required>
                                {!! $errors->first('published_at', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has($langform.'.text') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.text')) }}</label>
                            <div class="col-md-10">
                                <textarea name="{{ $langform }}[text]" class="form-control tinymce-upload">{{ $note->hasTranslation($langform) ? $note->translate($langform)->text : '' }}</textarea>
                                {!! $errors->first($langform .'.text', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-4">
                                    <input type="submit" class="btn btn-block btn-primary" value="Actualizar">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop