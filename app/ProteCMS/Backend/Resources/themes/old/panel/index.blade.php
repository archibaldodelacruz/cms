@extends('layouts.base')

@section('content')

<div class="alert alert-info text-center">
    <p>
        <h4>¡El proyecto ya tiene Teaming oficial!</h4> 
        Con solo 1€ al mes ayudarás a costear los gastos de servidores y servicios. 
        <br><small>Esto es totalmente opcional, ProteCMS <strong>siempre será gratis</strong>.</small>
    </p>
    <a href="https://www.teaming.net/protecms" target="_blank" class="btn btn-default margin-top-10">Donar 1€ al mes</a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">Últimos animales</span>
                </div>
            </div>
            <div class="portlet-body">
                @if (Auth::user()->hasPermission('admin.panel.animals'))
                    <div class="table-scrollable">
                        <table class="table table-center table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Especie</th>
                                <th>Género</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($animals as $animal)
                                    <tr>
                                        <td>{{ $animal->name }}</td>
                                        <td>{{ trans_choice('animals.status.' . $animal->status, 1) }}</td>
                                        <td>{{ trans_choice('animals.kind.' . $animal->kind, 1) }}</td>
                                        <td>{{ trans_choice('animals.gender.' . $animal->gender, 1) }}</td>
                                        <td class="table-actions-single">
                                            @cannot('update', $animal)
                                                <a href="{{ route('admin::panel::animals::show', ['id' => $animal->id]) }}" class="btn btn-primary btn-block">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endcannot
                                            @can('update', $animal)
                                                <a href="{{ route('admin::panel::animals::edit', ['id' => $animal->id]) }}" class="btn btn-primary btn-block">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        No tienes permisos para ver esta sección.
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">¿Qué te gustaría tener en el proyecto?</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="alert alert-danger text-center">¡Atención! Ayuda al proyecto a mejorar.</div>
                <p>Actualmente me encuentro trabajando en nuevas mejoras para el proyecto y llegarán antes de verano. Algunas de las mejoras son:</p>
                <ul>
                    <li>Renovación completa del panel de administración, con más opciones, mejoras y más.</li>
                    <li>Traducción del proyecto a inglés, portugués, alemán, francés e italiano.</li>
                    <li>Nuevos diseños para la página web, con más opciones de personalización.</li>
                    <li>Nuevas características como gestión de tareas, generación de informes, gestión de stock...</li>
                    <li>Y muchas características más...</li>
                </ul>
                <p>Por favor, si tiene en mente algo, por mínimo que sea y que pueda venir bien al proyecto, no dude en
                    <a href="{{ route('admin::support::contact') }}">enviar sugerencias.</a></p>
                <p>Gracias.<br>Jaime</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">Últimos artículos</span>
                </div>
            </div>
            <div class="portlet-body">
                @if (Auth::user()->hasPermissions(['admin.panel.posts', 'admin.panel.posts.view', 'admin.panel.posts.crud']))
                    <div class="table-scrollable">
                        <table class="table table-center table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td class="text-left">{{ str_limit($post->title, 80, '...') }}</td>
                                        <td>{{ $post->category->title }}</td>
                                        <td class="table-actions-single">
                                            @cannot('update', $post)
                                                <a href="{{ route('admin::panel::posts::show', ['id' => $post->id]) }}" class="btn btn-primary btn-block">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endcannot
                                            @can('update', $post)
                                                <a href="{{ route('admin::panel::posts::edit', ['id' => $post->id]) }}" class="btn btn-primary btn-block">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        No tienes permisos para ver esta sección.
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">Últimos usuarios</span>
                </div>
            </div>
            <div class="portlet-body">
                @if (Auth::user()->hasPermissions(['admin.panel.users', 'admin.panel.users.view']))
                    <div class="table-scrollable">
                        <table class="table table-center table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo electrónico</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="table-actions-single">
                                        <a href="{{ route('admin::panel::users::edit', ['id' => $user->id]) }}" class="btn btn-primary btn-block"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        No tienes permisos para ver esta sección.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('page.help.text')
    <p>Esta es la página principal del panel de administración. Cuando un voluntario que tiene acceso al panel o un administrador se identifican en el sistema, ven esta página.</p>
    <p>En ella hay 4 bloques (por el momento):</p>
    <p><strong>Últimos animales:</strong><br> Muestra los últimos 5 animales añadidos.</p>
    <p><strong>¡Bienvenidos a la nueva versión!:</strong><br> Muestra un mensaje de bienvenida, que podrá tener información sobre nuevas actualizaciones, correciones, etc..</p>
    <p><strong>Últimos artículos:</strong><br> Muestra los últimos 5 artículos añadidos.</p>
    <p><strong>Últimos usuarios:</strong><br> Muestra los últimos 5 usuarios registrados.</p>
@endsection