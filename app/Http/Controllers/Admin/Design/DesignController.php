<?php

namespace App\Http\Controllers\Admin\Design;

use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Design\UpdateRequest;
use App\Http\Controllers\Admin\BaseAdminController;

class DesignController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->customAuthorize('admin.design');

        chdir(public_path('assets/images/backgrounds'));
        $backgrounds = glob('*.png');

        return view('design.index', compact('backgrounds'));
    }

    public function config()
    {
        $this->customAuthorize('admin.design');

        return view('design.config');
    }

    public function css()
    {
        $this->customAuthorize('admin.design');

        return view('design.css');
    }

    public function css_update(Request $request)
    {
        $this->customAuthorize('admin.design');

        $this->web->setConfig('themes.default.css', $request->get('css'));

        flash('CSS actualizado correctamente');

        return redirect()->route('admin::design::css');
    }

    public function config_update(Request $request)
    {
        $this->customAuthorize('admin.design');

        $this->web->setConfig('posts.pagination', $request->get('posts_pagination'));
        $this->web->setConfig('animals.fields', json_encode($request->get('animals_fields')));
        $this->web->setConfig('animals.contact_email', $request->get('animals_contact_email'));

        flash('Configuración actualizado correctamente');

        return redirect()->route('admin::design::config');
    }

    public function update(UpdateRequest $request)
    {
        $this->customAuthorize('admin.design');

        if ($request->has('logo') && !empty($request->get('logo'))) {
            $logo = Image::make($request->get('logo'))->resize(400, 400, function ($constraint) {
                $constraint->upsize();
            });

            $mime = $logo->mime();

            switch ($mime) {
                case 'image/jpeg':
                    $extension = 'jpg';
                    break;
                case 'image/png':
                    $extension = 'png';
                    break;
                case 'image/gif':
                    $extension = 'gif';
                    break;
                default:
                    $extension = 'png';
                    break;
            }

            $name = 'logo.'.$extension;

            Storage::put('web/'.$this->web->id.'/images/'.$name, $logo->stream($extension, 100)->__toString(), 'public');

            $this->web->update([
                'logo' => $name,
            ]);
        }

        if ($request->has('header') && !empty($request->get('header'))) {
            $header = Image::make($request->get('header'))->resize(1200, 200, function ($constraint) {
                $constraint->upsize();
            });

            $mime = $header->mime();

            switch ($mime) {
                case 'image/jpeg':
                    $extension = 'jpg';
                    break;
                case 'image/png':
                    $extension = 'png';
                    break;
                case 'image/gif':
                    $extension = 'gif';
                    break;
                default:
                    $extension = 'png';
                    break;
            }

            $name = 'header.'.$extension;

            Storage::put('web/'.$this->web->id.'/images/'.$name, $header->stream($extension, 100)->__toString(), 'public');

            $this->web->setConfig('themes.default.header_image', $name);
        }

        if ($request->hasFile('favicon') && $request->file('favicon')->isValid()) {
            $favicon = Image::make($request->file('favicon')->path())->resize(32, 32);

            $mime = $favicon->mime();

            switch ($mime) {
                case 'image/jpeg':
                    $extension = 'jpg';
                    break;
                case 'image/png':
                    $extension = 'png';
                    break;
                case 'image/gif':
                    $extension = 'gif';
                    break;
                case 'image/x-icon':
                    $extension = 'ico';
                    break;
                default:
                    $extension = 'png';
                    break;
            }

            $name = 'favicon.'.$extension;

            Storage::put('web/'.$this->web->id.'/images/'.$name, $favicon->stream($extension, 100)->__toString(), 'public');
            $this->web->setConfig('themes.default.favicon', $name);
        }

        $this->web->setConfig('themes.default.color', $request->get('color'));
        $this->web->setConfig('themes.default.border_radius', $request->get('border_radius'));

        switch ($request->get('select_background')) {
            case 'background-color':
                $this->web->setConfig('themes.default.background_type', 'background_color');
                $this->web->setConfig('themes.default.background_color', $request->get('background_color')['background_color']);
                $this->web->unsetConfig('themes.default.background_image');
                $this->web->unsetConfig('themes.default.background_content_color');
                break;

            case 'background-content-color':
                $this->web->setConfig('themes.default.background_type', 'background_content_color');
                $this->web->setConfig('themes.default.background_color', $request->get('background_content_color')['background_color']);
                $this->web->setConfig('themes.default.background_content_color', $request->get('background_content_color')['background_content_color']);
                $this->web->unsetConfig('themes.default.background_image');
                break;

            case 'background-image':
                $this->web->setConfig('themes.default.background_type', 'background_image');
                $this->web->setConfig('themes.default.background_image', $request->get('background_image')['background_image']);
                $this->web->unsetConfig('themes.default.background_color');
                $this->web->unsetConfig('themes.default.background_content_color');
                break;

            case 'background-image-content':
                $this->web->setConfig('themes.default.background_type', 'background_image_content');
                $this->web->setConfig('themes.default.background_image', $request->get('background_image_content')['background_image']);
                $this->web->setConfig('themes.default.background_content_color', $request->get('background_image_content')['background_content_color']);
                $this->web->unsetConfig('themes.default.background_color');
                break;

            default:
                $this->web->unsetConfig('themes.default.background_type');
                $this->web->unsetConfig('themes.default.background_color');
                $this->web->unsetConfig('themes.default.background_image');
                $this->web->unsetConfig('themes.default.background_content_color');
                break;
        }

        flash('Diseño actualizado correctamente');

        return redirect()->route('admin::design::index');
    }

    public function getSidebar()
    {
        return [
            [
                'title' => 'Diseño',
                'menu'  => [
                    'title'   => 'Diseño',
                    'icon'    => 'fa fa-picture-o',
                    'url'     => 'javascript:;',
                    'base'    => 'admin/design*',
                    'submenu' => [
                        [
                            'title'       => 'Principal',
                            'icon'        => 'fa fa-picture-o',
                            'url'         => route('admin::design::index'),
                            'permissions' => ['admin.design', 'admin.design.view'],
                        ],
                        [
                            'title'       => 'Configuración',
                            'icon'        => 'fa fa-cogs',
                            'url'         => route('admin::design::config'),
                            'permissions' => ['admin.design'],
                        ],
                        [
                            'title'       => 'CSS Personalizado',
                            'icon'        => 'fa fa-css3',
                            'url'         => route('admin::design::css'),
                            'permissions' => ['admin.design'],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Bloques',
                'menu'  => [
                    'title'   => 'Bloques',
                    'icon'    => 'fa fa-clone',
                    'url'     => 'javascript:;',
                    'base'    => 'admin/design*',
                    'submenu' => [
                        [
                            'title'       => 'Bloques',
                            'icon'        => 'fa fa-clone',
                            'url'         => route('admin::design::widgets::index'),
                            'permissions' => ['admin.design', 'admin.design.view'],
                        ],
                        [
                            'title'       => 'Crear bloque',
                            'icon'        => 'fa fa-plus-square',
                            'url'         => route('admin::design::widgets::create'),
                            'permissions' => ['admin.design'],
                        ],
                        [
                            'title'       => 'Bloques eliminados',
                            'icon'        => 'fa fa-trash',
                            'url'         => route('admin::design::widgets::deleted'),
                            'permissions' => ['admin.design'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
