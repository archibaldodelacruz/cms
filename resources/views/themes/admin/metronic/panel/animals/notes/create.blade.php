@extends('themes.admin.metronic.layouts.base')

@section('page.title')
    Añadir nota a la ficha de {{ $animal->name }}
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
        <a href="{{ route('admin::panel::animals::notes::create', ['animal_id' => $animal->id]) }}">Añadir nota</a>
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
                    <form action="{{ route('admin::panel::animals::notes::store', ['animal_id' => $animal->id]) }}" method="POST" class="form-horizontal form-bordered form-label-stripped">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has(config('app.locale').'.title') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.title')) }}</label>
                            <div class="col-md-10">
                                <input type="text" name="{{ config('app.locale') }}[title]" value="{{ old(config('app.locale').'.title') }}" class="form-control" required>
                                {!! $errors->first(config('app.locale') .'.title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.status')) }}</label>
                            <div class="col-md-10">
                                <select name="status" class="form-control" placeholder="Estado...">
                                    @foreach(config('protecms.animals.notes.status') as $status)
                                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ trans('animals.notes.status.' . $status) }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has(config('app.locale') . '.user_id') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.author')) }}</label>
                            <div class="col-md-10">
                                <select name="{{ config('app.locale') }}[user_id]" class="form-control" required>
                                    @foreach ($web->volunteers as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == Request::user()->id ? 'selected' : '' }} {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first(config('app.locale') . '.user_id', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('published_at') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.published_at')) }}</label>
                            <div class="col-md-10">
                                <input type="text" name="published_at" value="{{ date('d-m-Y H:i:s') }}" class="form-control datetimepicker" required>
                                {!! $errors->first('published_at', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has(config('app.locale').'.text') ? 'has-error' : '' }}">
                            <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.text')) }}</label>
                            <div class="col-md-10">
                                <textarea name="{{ config('app.locale') }}[text]" class="form-control tinymce-upload">{{ old(config('app.locale').'.text') }}</textarea>
                                {!! $errors->first(config('app.locale') .'.text', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-4">
                                    <input type="submit" class="btn btn-block btn-primary" value="Añadir">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop