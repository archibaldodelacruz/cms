@extends('admin.layouts.base')

@section('page.title')
    Listado de veterinarios <div class="pull-right"><small>Mostrando {{ $veterinarians->count() }} veterinarios de un total de {{ $total }}.</small></div>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('admin::panel::veterinarians::index') }}">Veterinarios</a>
    </li>
@stop

@section('content')
    <form action="" method="GET">
        <div class="pull-right">
            Ordenar por <select name="sort" class="margin-bottom-20" onchange="this.form.submit()">
                <option value="name" {{ $request->get('sort') == 'name' ? 'selected' : '' }}>Nombre</option>
                <option value="contact_name" {{ $request->get('sort') == 'contact_name' ? 'selected' : '' }}>Persona de contacto</option>
                
                <option value="email" {{ $request->get('sort') == 'email' ? 'selected' : '' }}>Correo electrónico</option>
            </select>
        </div>
        <div class="table-scrollable">
            <table class="table table-center table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Persona de contacto</th>
                        <th>Correo electrónico</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    <tr>
                        <th><input type="text" name="name" class="form-control" placeholder="Nombre..." value="{{ $request->get('name') }}"></th>
                        <th><input type="text" name="contact_name" class="form-control" placeholder="Persona de contacto..." value="{{ $request->get('contact_name') }}"></th>
                        <th><input type="email" name="email" class="form-control" placeholder="Correo electrónico..." value="{{ $request->get('email') }}"></th>
                        <th><input type="number" name="phone" class="form-control" placeholder="Teléfono..." value="{{ $request->get('phone') }}"></th>
                        <th>
                        <select name="status" class="form-control">
                            <option value="">-- Seleccione --</option>
                            @foreach(config('protecms.veterinarians.status') as $status)
                                <option value="{{ $status }}" {{ $request->get('status') == $status ? 'selected' : '' }}>{{ trans('veterinarians.status.' . $status) }}</option>
                            @endforeach
                        </select>
                        </th>
                        <th>
                            <button type="submit" class="btn btn-block btn-primary">Filtrar</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                @if (count($veterinarians))
                    @foreach ($veterinarians as $veterinary)
                        <tr>
                            <td>{{ $veterinary->name }}</td>
                            <td>{{ $veterinary->contact_name }}</td>
                            <td>{{ $veterinary->email }}</td>
                            <td>{{ $veterinary->phone }}</td>
                            <td>{{ trans('veterinarians.status.' . $veterinary->status) }}</td>
                            <td class="table-actions">
                                @if (! Auth::user()->isAdmin() && Auth::user()->hasPermission('admin.panel.veterinarians.view'))
                                    <div class="col-md-offset-3 col-md-6 col-xs-12">
                                        <a href="{{ route('admin::panel::veterinarians::show', ['id' => $veterinary->id]) }}" class="btn btn-primary btn-block">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-md-6 col-xs-6">
                                        <a href="{{ route('admin::panel::veterinarians::edit', ['id' => $veterinary->id]) }}" class="btn btn-primary btn-block">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <a href="{{ route('admin::panel::veterinarians::delete', ['id' => $veterinary->id]) }}" class="btn btn-danger confirm btn-block">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            @if ($total)
                                No existen veterinarios con esos parámetros.
                            @else
                                <p class="bg-info text-center">Aún no se han creado veterinarios.</p>
                            @endif
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </form>

    {!! $veterinarians->appends($request->all())->links() !!}
@stop