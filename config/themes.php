<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Switch this package on/off. Usefull for testing...
    |--------------------------------------------------------------------------
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | File path where themes will be located.
    | Can be outside default views path EG: resources/themes
    | Leave it null if you place your themes in the default views folder
    | (as defined in config\views.php)
    |--------------------------------------------------------------------------
    */

    'themes_path' => realpath(base_path('resources/views/themes')), // eg: realpath(base_path('resources/themes'))

    /*
    |--------------------------------------------------------------------------
    | Set behavior if an asset is not found in a Theme hierarcy.
    | Available options: THROW_EXCEPTION | LOG_ERROR | ASSUME_EXISTS | IGNORE
    |--------------------------------------------------------------------------
    */

    'asset_not_found' => 'LOG_ERROR',

    /*
    |--------------------------------------------------------------------------
    | Set the Active Theme. Can be set at runtime with:
    |  Themes::set('theme-name');
    |--------------------------------------------------------------------------
    */

    'active' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Define available themes. Format:
    |
    | 	'theme-name' => [
    | 		'extends'	 	=> 'theme-to-extend',  // optional
    | 		'views-path' 	=> 'path-to-views',    // defaults to: resources/views/theme-name
    | 		'asset-path' 	=> 'path-to-assets',   // defaults to: public/theme-name
    |
    |		// you can add your own custom keys and retrieve them with Theme::config('key');
    | 		'key' 			=> 'value',
    | 	],
    |
    |--------------------------------------------------------------------------
    */

    'themes' => [

        /*
         * Web themes
         */
        'default' => [
            'extends'       => null,
            'views-path'    => 'web/default',
            'asset-path'    => 'themes/default',
        ],

        'bulma' => [
            'extends'       => null,
            'views-path'    => 'web/bulma',
            'asset-path'    => 'themes/bulma',
        ],

        /*
         * Admin themes
         */
        'admin' => [
            'extends'       => null,
            'views-path'    => 'admin/metronic',
            'asset-path'    => 'themes/default',
        ],
    ],
];
