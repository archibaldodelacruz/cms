@extends('layouts.base')

@section('page.title')
    Diseño
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('admin::design::index') }}">Diseño</a>
    </li>
@stop

@section('content')
    <div class="portlet light bordered form-fit">
        <div class="portlet-body form">
            <form action="{{ route('admin::design::update') }}" method="POST" class="form-horizontal form-bordered form-label-stripped" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.theme')) }}</label>
                    <div class="col-md-10">
                        <select class="form-control" disabled>
                            <option value="">Por defecto</option>
                        </select>
                        <div class="help-block">Actualmente sólo hay 1 tema. En breve habrá más disponibles.</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">* Bordes redondeados</label>
                    <div class="col-md-10">
                        <select class="form-control" name="border_radius">
                            <option value="0">No</option>
                            <option value="1" {{ $web->getConfig('themes.default.border_radius', true) ? 'selected' : '' }}>Si</option>
                        </select>
                        <div class="help-block">Indica si quieres los bordes de los elementos de la página web redondeados o no.</div>
                        {!! $errors->first('border_radius', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}">
                    <label class="control-label col-md-2">* {{ ucfirst(trans('validation.attributes.color')) }} principal</label>
                    <div class="col-md-10">
                        <input type="text" name="color" value="{{ $web->getConfig('themes.default.color') }}" class="form-control colorpicker" required>
                        {!! $errors->first('color', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">* Fondo</label>
                    <div class="col-md-10">
                        <p class="bg-info">La mejor combinación es la de imagen de fondo y el color del contenido en blanco.</p>
                        <select name="select_background" class="form-control">
                            <option value="">Por defecto</option>
                            <option value="background-color" {{ $web->getConfig('themes.default.background_type') == 'background_color' ? 'selected' : '' }}>Color del fondo</option>
                            <option value="background-content-color" {{ $web->getConfig('themes.default.background_type') == 'background_content_color' ? 'selected' : '' }}>Color del fondo y del contenido</option>
                            <option value="background-image" {{ $web->getConfig('themes.default.background_type') == 'background_image' ? 'selected' : '' }}>Imagen de fondo</option>
                            <option value="background-image-content" {{ $web->getConfig('themes.default.background_type') == 'background_image_content' ? 'selected' : '' }}>Imagen de fondo y color del contenido</option>
                        </select>
                        <div class="background-color {{ $web->getConfig('themes.default.background_type') == 'background_color' ? '' : 'hide' }}">
                            <p class="margin-top-20">Seleccione un color para el fondo</p>
                            <input type="text" name="background_color[background_color]" value="{{ $web->hasConfig('themes.default.background_color') ? $web->getConfig('themes.default.background_color') : '#efefef' }}" class="form-control colorpicker">
                        </div>
                        <div class="background-content-color {{ $web->getConfig('themes.default.background_type') == 'background_content_color' ? '' : 'hide' }}">
                            <p class="margin-top-20">Seleccione un color para el fondo</p>
                            <input type="text" name="background_content_color[background_color]" value="{{ $web->hasConfig('themes.default.background_color') ? $web->getConfig('themes.default.background_color') : '#efefef' }}" class="form-control colorpicker">
                            <p class="margin-top-20">Seleccione un color para el contenido</p>
                            <input type="text" name="background_content_color[background_content_color]" value="{{ $web->hasConfig('themes.default.background_content_color') ? $web->getConfig('themes.default.background_content_color') : '#ffffff' }}" class="form-control colorpicker">
                        </div>
                        <div class="background-image {{ $web->getConfig('themes.default.background_type') == 'background_image' ? '' : 'hide' }}">
                            <div class="background-preview">
                                <a href="{{ $web->hasConfig('themes.default.background_image') ? '/assets/images/backgrounds/' . $web->getConfig('themes.default.background_image') : '/assets/images/backgrounds/' . $backgrounds[0] }}" class="lightbox-image"><img src="{{ $web->hasConfig('themes.default.background_image') ? '/assets/images/backgrounds/' . $web->getConfig('themes.default.background_image') : '/assets/images/backgrounds/' . $backgrounds[0] }}" alt="" width="100px" height="100px" style="margin: 20px"></a>
                            </div>
                            <p class="margin-top-20">Seleccione un fondo</p>
                            <select class="form-control" name="background_image[background_image]">
                                @foreach($backgrounds as $background)
                                    <option value="{{ $background }}" {{ $web->getConfig('themes.default.background_image') == $background ? 'selected' : '' }}>{{ $background }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="background-image-content {{ $web->getConfig('themes.default.background_type') == 'background_image_content' ? '' : 'hide' }}">
                            <div class="background-preview">
                                <a href="{{ $web->hasConfig('themes.default.background_image') ? '/assets/images/backgrounds/' . $web->getConfig('themes.default.background_image') : '/assets/images/backgrounds/' . $backgrounds[0] }}" class="lightbox-image"><img src="{{ $web->hasConfig('themes.default.background_image') ? '/assets/images/backgrounds/' . $web->getConfig('themes.default.background_image') : '/assets/images/backgrounds/' . $backgrounds[0] }}" alt="" width="100px" height="100px" style="margin: 20px"></a>
                            </div>
                            <p class="margin-top-20">Seleccione un fondo</p>
                            <select class="form-control" name="background_image_content[background_image]">
                                @foreach($backgrounds as $background)
                                    <option value="{{ $background }}" {{ $web->getConfig('themes.default.background_image') == $background ? 'selected' : '' }}>{{ $background }}</option>
                                @endforeach
                            </select>
                            <p class="margin-top-20">Seleccione un color para el contenido</p>
                            <input type="text" name="background_image_content[background_content_color]" value="{{ $web->hasConfig('themes.default.background_content_color') ? $web->getConfig('themes.default.background_content_color') : '#ffffff' }}" class="form-control colorpicker">
                        </div>
                        {!! $errors->first('background_image', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                    <label class="control-label col-md-2">{{ ucfirst(trans('validation.attributes.logo')) }}</label>
                    <div class="col-md-10">
                        <p class="bg-info">Las dimensiones recomendadas son 400px de ancho por 400px de alto.</p>
                        <a href="{{ route('web::image', ['file' => $web->logo]) }}" target="_blank"><img src="{{ route('web::image', ['file' => $web->logo]) }}" alt="" style="max-width: 100%; max-height: 150px; padding: 15px" class=""></a>
                        <div class="image-editor-logo">
                            <input type="file" class="cropit-image-input">
                            <div class="cropit-preview"></div>
                            <div class="image-size-label">
                                Redimensionar imagen
                            </div>
                            <input type="range" class="cropit-image-zoom-input">
                            <input type="hidden" name="logo" class="hidden-image-data-logo" />
                        </div>
                        <div class="help-block">Si no selecciona uno se mantendrá el actual.</div>
                        {!! $errors->first('logo', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('header') ? 'has-error' : '' }}">
                    <label class="control-label col-md-2">{{ ucfirst(trans('validation.attributes.header_image')) }}</label>
                    <div class="col-md-10">
                        <p class="bg-info">Las dimensiones recomendadas son 1200px de ancho por 200px de alto.</p>
                        @if ($web->hasConfig('themes.default.header_image'))
                            <a href="{{ route('web::image', ['file' => $web->getConfig('themes.default.header_image')]) }}" target="_blank"><img src="{{ route('web::image', ['file' => $web->getConfig('themes.default.header_image')]) }}" alt="" style="max-width: 100%; max-height: 150px; padding: 15px" class=""></a>
                        @endif
                        <div class="image-editor-header">
                            <input type="file" class="cropit-image-input">
                            <div class="cropit-preview"></div>
                            <div class="image-size-label">
                                Redimensionar imagen
                            </div>
                            <input type="range" class="cropit-image-zoom-input">
                            <input type="hidden" name="header" class="hidden-image-data-header" />
                        </div>
                        <div class="help-block">Si no selecciona uno se mantendrá el actual.</div>
                        {!! $errors->first('header', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('favicon') ? 'has-error' : '' }}">
                    <label class="control-label col-md-2">{{ ucfirst(trans('validation.attributes.favicon')) }}</label>
                    <div class="col-md-10">
                        <p class="bg-info">Las dimensiones recomendadas son 32px de ancho por 32px de alto. Puede generar un favicon haciendo clic <a href="http://www.favicon-generator.org/" target="_blank">aquí.</a></p>
                        @if ($web->hasConfig('themes.default.favicon'))
                            <a href="{{ route('web::image', ['file' => $web->getConfig('themes.default.favicon')]) }}" target="_blank"><img src="{{ route('web::image', ['file' => $web->getConfig('themes.default.favicon')]) }}" alt="" style="max-width: 100%; max-height: 150px; padding: 15px" class=""></a>
                        @endif
                        <div class="form-control">
                            <input type="file" name="favicon">
                        </div>
                        <div class="help-block">Si no selecciona uno se mantendrá el actual.</div>
                        {!! $errors->first('header', '<span class="help-block">:message</span>') !!}
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
@stop

@push('styles')
<style>
    .image-editor-header .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 600px;
        height: 100px;
    }

    .image-editor-header .cropit-preview-image-container {
        cursor: move;
    }

    .image-editor-header .image-size-label {
        margin-top: 10px;
    }

    .image-editor-header .cropit-preview-background {
        opacity: .2;
    }

    .image-editor-logo .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 400px;
        height: 400px;
    }

    .image-editor-logo .cropit-preview-image-container {
        cursor: move;
    }

    .image-editor-logo .image-size-label {
        margin-top: 10px;
    }

    .image-editor-logo .cropit-preview-background {
        opacity: .2;
    }
</style>
@endpush

@push('scripts')
<script>
    /**
     * Backgrounds
     */
    $('select[name="select_background"]').on('change', function() {
        console.log($(this).find(':selected').val());
        $('.background-color').addClass('hide');
        $('.background-content-color').addClass('hide');
        $('.background-image').addClass('hide');
        $('.background-image-content').addClass('hide');
        $('.' + $(this).find(':selected').val()).removeClass('hide');
    });

    // Background preview
    $('select[name="background_image[background_image]"], select[name="background_image_content[background_image]"]').on('change', function() {
        $('.background-preview img').attr('src', '/assets/images/backgrounds/' + $(this).find(':selected').text());
        $('.background-preview a').attr('href', '/assets/images/backgrounds/' + $(this).find(':selected').text());
    });

    /**
     * Image resize
     */
    $('.image-editor-logo').cropit({
        smallImage: 'allow',
        freeMove: true,
        width: 400,
        height: 400,
        maxZoom: 2.5
    });
    $('.image-editor-header').cropit({
        smallImage: 'allow',
        width: 1200,
        height: 200,
        freeMove: true,
        maxZoom: 2.5
    });

    $('form').submit(function() {
        // Move cropped image data to hidden input
        var imageData = $('.image-editor-logo').cropit('export');
        $('.hidden-image-data-logo').val(imageData);

        var imageData = $('.image-editor-header').cropit('export');
        $('.hidden-image-data-header').val(imageData);
    });

    /**
     * Throttle Resize-triggered Events
     * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
     * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
     */
    var waitForFinalEvent = (function () {
        var timers = {};
        return function (callback, ms, uniqueId) {
            if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
            if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
            timers[uniqueId] = setTimeout(callback, ms);
        };
    })();


    var timeToWaitForLast = 100, // How often to run the resize event during resize (ms)
            $imageCropperLogo; // Set up a global object to hold image cropper container


    /**
     * Runs on window resize
     */
    function resizeHandler()
    {
        /**
         * Adjust the size of the preview area to be 100% of the image cropper container
         */
        if ( $imageCropperHeader )
        {
            var finalWidth  = 1200, // The desired width for final image output
                    finalHeight = 200, // The desired height for final image output
                    sizeRatio   = finalHeight / finalWidth,
                    newWidth    = $imageCropperHeader.width(),
                    newHeight   = newWidth * sizeRatio,
                    newZoom     = finalWidth / newWidth;

            $imageCropperHeader.cropit('previewSize', { width: newWidth, height: newHeight });
            $imageCropperHeader.cropit('exportZoom', newZoom);
        }

        if ( $imageCropperLogo )
        {
            var finalWidth  = 400, // The desired width for final image output
                    finalHeight = 400, // The desired height for final image output
                    sizeRatio   = finalHeight / finalWidth,
                    newWidth    = $imageCropperHeader.width(),
                    newHeight   = newWidth * sizeRatio,
                    newZoom     = finalWidth / newWidth;

            if (newWidth > 400) {
                newWidth = 400;
                newHeight = 400;
            }

            $imageCropperLogo.cropit('previewSize', { width: newWidth, height: newHeight });
            $imageCropperLogo.cropit('exportZoom', newZoom);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        /**
         * Set up the image cropper when the DOM is loaded
         */
        $imageCropperHeader = jQuery('.image-editor-header');
        $imageCropperHeader.cropit({
            exportZoom: 3, // This will get adjusted when we change the size of the preview
            onImageLoaded: function() {
                resizeHandler();
            },
        });

        /**
         * Set up the image cropper when the DOM is loaded
         */
        $imageCropperLogo = jQuery('.image-editor-logo');
        $imageCropperLogo.cropit({
            exportZoom: 3, // This will get adjusted when we change the size of the preview
            onImageLoaded: function() {
                resizeHandler();
            },
        });

        /**
         * Set up the resize event
         */
        resizeHandler();
        window.addEventListener('resize', function() {
            waitForFinalEvent(resizeHandler, timeToWaitForLast, 'mainresize');
        });
    });
</script>
@endpush

@section('page.help.text')
    <p>En esta página se pueden añadir y modificar el diseño general de la página web, como el logo, la cabecera o el favicon.</p>
    <p class="bg-info">Por favor, respete las dimensiones recomendadas de los archivos para su óptima visualización del mismo en la página web.</p>
@stop