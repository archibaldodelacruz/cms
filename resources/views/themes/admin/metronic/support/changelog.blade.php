@extends('themes.admin.metronic.layouts.base')

@section('page.title')
    Historial de cambios
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('admin::support::index') }}">Soporte</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
    	<a href="{{ route('admin::support::changelog') }}">Historial de cambios</a>
    </li>
@stop

@section('content')
<div class="row changelog">
    <div class="col-md-12">

        <h2>Versión 2.1.3 <small>(actual)</small></h2>
        <h4>09-03-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadidas las opciones trimestral y semestral a las cuotas de los socios.</li>
            <li><span class="label label-info">novedad</span> Ahora cuando se accede a una página que no existe, aparece el error integrado en la web.</li>
            <li><span class="label label-warning">corrección</span> Corregido un error que bloqueaba al usuario cuando no tenía permisos para acceder al panel de administración.</li>
        </ul>

        <h4>03-03-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Ahora los mails se envían desde la dirección <span class="label label-info">mail@protecms.com</span>. Añádela a los contactos de los emails de la protectora para que no se reciban como spam.</li>
            <li><span class="label label-info">novedad</span> Se ha cambiado el sistema de envíos de emails, ahora los correos de hotmail no deberían de tener problemas al recibir emails.</li>
            <li><span class="label label-warning">corrección</span> Ahora cuando llegue un mail solicitando información de un animal, al hacer clic en responder en el cliente de correo, se reponderá al usuario.</li>
        </ul>

        <h4>03-02-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Mejoras en el SEO de la página web.</li>
            <li><span class="label label-info">novedad</span> Añadido el <a href="/sitemap.xml" target="_blank">sitemap</a> a la página de la protectora (útil para buscadores). Se actualiza semanalmente.</li>
        </ul>

        <h4>01-02-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadidas las notas de los animales.</li>
        </ul>

        <h2>Versión 2.1.2</h2>
        <h4>30-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadidas mejoras internas en la aplicación de nuevas actualizaciones.</li>
            <li><span class="label label-warning">corrección</span> Corregido un error que provocaba que los enlaces de *Eliminar* no funcionasen correctamente.</li>
        </ul>

        <h2>Versión 2.1.1</h2>
        <h4>28-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadidas mejoras internas.</li>
        </ul>

        <h2>Versión 2.1.0</h2>
        <h4>27-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Aplicadas varias actualizaciones estructurales importantes de forma interna.</li>
            <li><span class="label label-info">novedad</span> El proyecto se ha actualizado a la versión 2.1.0</li>
        </ul>

        <h2>Versión 2.0.1</h2>
        <h4>25-01-2017</h4>
        <ul>
            <li><span class="label label-warning">corrección</span> Corregidos varios errores del sistema de permisos.</li>
        </ul>
        <h4>22-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Ahora cuando se intenta erróneamente 5 veces el acceso al panel, se bloquea al usuario durante 1 minuto.</li>
            <li><span class="label label-warning">corrección</span> Optimizada la carga de la página web y el panel de administración.</li>
            <li><span class="label label-warning">corrección</span> Corregido un error que provocaba que los campos de los formularios insertados en las páginas no apareciesen en el orden correcto.</li>
            <li><span class="label label-warning">corrección</span> Corregido un error que provocaba que, sin tener permisos, un voluntario pudiese acceder a las secciones Página web y Soporte.</li>
        </ul>
        <h4>21-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadida la personalización del color y/o imagen de fondo de la página web en el apartado Página web.</li>
            <li><span class="label label-info">novedad</span> Cambiado el nombre del enlace del menú superior, antes Diseño, ahora Página web.</li>
        </ul>
        <h4>20-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadido el sistema de notificaciones.
            </li>
            <li><span class="label label-info">novedad</span> El proyecto se ha actualizado a la versión 2.0.1</li>
        </ul>

        <h2>Versión 2.0.0</h2>
        <h4>19-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadido el botón de volver arriba en la página web.
            </li>
            <li><span class="label label-warning">corrección</span> Corregido un error que provocaba que no se pudiesen crear artículos, páginas, etc, con emojis.</li>
        </ul>
        <h4>18-01-2017</h4>
        <ul>
            <li><span class="label label-warning">corrección</span> Corregido un error que provocaba que no se pudiesen editar eventos del calendario.</li>
        </ul>
        <h4>17-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Ahora se puede subir un favicon en el apartado de diseño.
            </li>
            <li><span class="label label-info">novedad</span> Ahora aparecen botones para crear en los listados vacíos. También encima de los listados, solo para móviles y tablets, para que sea más fácil acceder a dichas secciones (gracias a Alberto).
            </li>
            <li><span class="label label-warning">corrección</span> Arreglado el error que provocaba que al buscar por macho, apareciésen también las hembras.</li>
        </ul>
        <h4>16-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadida la ayuda en todas las páginas del panel de administración. Al hacer clic en el botón de <button class="btn btn-primary btn-xs"><i class="fa fa-question-circle"></i> Ayuda</button> aparecerá una ventana con la información de esa página.
            </li>
        </ul>
        <h4>11-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Modificado el asunto en el formulario de contacto de un animal cuando está perdido o ha sido encontrado.</li>
            <li><span class="label label-warning">corrección</span> Ahora es posible fijar uno o varios artículos en la página principal.</li>
        </ul>
        <h4>04-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadido el tipo Enfermedad a la salud de los animales.</li>
            <li><span class="label label-info">novedad</span> Ahora al crear un registro de salud de un animal se puede añadir el gasto automáticamente a las finanzas.</li>
        </ul>
        <h4>03-01-2017</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Ahora los formularios tienen un captcha de seguridad para evitar el SPAM.</li>
            <li><span class="label label-info">novedad</span> Integración de la salud de los animales con el calendario. Ahora cuando se añadan tratamientos, operaciones, revisiones, etc, aparecerán en el calendario de la protectora.</li>
            <li><span class="label label-warning">corrección</span> Ahora al insertar un vídeo (por ejemplo de Youtube), el vídeo se adapta al tamaño del dispositivo.</li>
        </ul>
        <h4>22-12-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadido el tipo Prueba y el campo Resultado en la salud de los animales.</li>
            <li><span class="label label-warning">corrección</span> Corregido un error que provocaba que al seleccionar un bloque como inactivo apareciese en la web.</li>
        </ul>
        <h4>20-12-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadido el sistema de permisos. Ahora un administrador podrá asignar permisos personalizados a los voluntarios.</li>
            <li><span class="label label-warning">corrección</span> Correcciones menores.</li>
        </ul>
        <h4>17-12-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Ahora se puede añadir CSS personalizado desde la sección <a href="{{ route('admin::design::css') }}">Diseño</a>.</li>
            <li><span class="label label-info">novedad</span> A partir de ahora para ver la listas de tareas pendientes, en proceso, realizadas y errores conocidos se hará a través de <a href="https://trello.com/b/j4eAFtN1/protecms" target="_blank">Trello</a>.</li>
            <li><span class="label label-warning">corrección</span> Ahora cuando una protectora tenga un dominio asignado el subdominio redirigirá automáticamente a éste.</li>
            <li><span class="label label-warning">corrección</span> Los bloques de la página web ahora tienen un correcto espaciado tanto superior como inferior.</li>
        </ul>
        <h4>14-12-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadida la alerta de política de cookies obligatoria por la <a href="https://www.agpd.es/portalwebAGPD/canaldocumentacion/cookies/index-ides-idphp.php">ley europea de cookies</a>.</li>
        </ul>
        <h4>09-12-2016</h4>
        <ul>
            <li><span class="label label-warning">corrección</span> Corregido problema que impedía la creación de bloques.</li>
        </ul>
        <h4>04-12-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Ahora se puede modificar el tamaño, color y tipo de fuente en los textos.</li>
            <li><span class="label label-warning">corrección</span> Corregido problema que provocaba que no se cambiase el logo o cabecera correctamente.</li>
        </ul>
        <h4>25-11-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadida la gestión de apadrinamientos de los animales.</li>
        </ul>
        <h4>21-11-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Ahora se puede exportar a PDF la ficha de un animal.</li>
            <li><span class="label label-warning">correción</span> Corregidos errores menores.</li>
        </ul>
        <h4>18-11-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadida la gestión de salud de los animales.</li>
            <li><span class="label label-info">novedad</span> Añadida la gestión de casas de acogida.</li>
        </ul>
        <h4>17-11-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Añadidas a la página de <a href="{{ route('admin::panel::stats') }}">estadísticas</a> las visitas y visualizaciones del último mes.</li>
            <li><span class="label label-warning">corrección</span> Corregido un error que no permitia subir fotos a las fichas de los animales superiores a 1mb. </li>
            <li><span class="label label-warning">corrección</span> Ahora es posible acceder al panel de administración mediante la url /administracion. </li>
            <li><span class="label label-warning">corrección</span> Ahora aparece el enlace "Acceder al Panel de administración" al pié de la página web. </li>
        </ul>
        <h4>16-11-2016</h4>
        <ul>
            <li><span class="label label-info">novedad</span> Lanzamiento de la versión 2.0 (beta) del proyecto. </li>
        </ul>
    </div>
</div>
@stop

@section('page.help.text')
    <p>Esta página muestra el historial de cambios.</p>
    <p>Se podrán ver las novedades y corecciones implementadas cada día.</p>
@stop
