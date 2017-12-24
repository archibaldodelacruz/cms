let mix = require('laravel-mix');

let frontendThemes = [
    'default'
];

let backendThemes = [
    'default'
];

for (let i = 0; i < frontendThemes.length; i++) {
    mix.js(
        'app/ProteCMS/Frontend/Resources/themes/' + frontendThemes[i] + '/assets/js/app.js',
        'public/build/themes/frontend/' + frontendThemes[i] + '/js/app.js'
    ).sass(
        'app/ProteCMS/Frontend/Resources/themes/' + frontendThemes[i] + '/assets/sass/app.scss',
        'public/build/themes/frontend/' + frontendThemes[i] + '/css/app.css'
    ).copy(
        'app/ProteCMS/Frontend/Resources/themes/' + frontendThemes[i] + '/assets/images',
        'public/build/themes/frontend/' + frontendThemes[i] + '/images',
    ).version([
        'public/build/themes/frontend/' + frontendThemes[i] + '/js/app.js',
        'public/build/themes/frontend/' + frontendThemes[i] + '/css/app.css'
    ]);
}

for (let i = 0; i < backendThemes.length; i++) {
    mix.js(
        'app/ProteCMS/Backend/Resources/themes/' + backendThemes[i] + '/assets/js/app.js',
        'public/build/themes/backend/' + backendThemes[i] + '/js/app.js'
    ).sass(
        'app/ProteCMS/Backend/Resources/themes/' + backendThemes[i] + '/assets/sass/app.scss',
        'public/build/themes/backend/' + backendThemes[i] + '/css/app.css'
    ).copy(
        'app/ProteCMS/Backend/Resources/themes/' + frontendThemes[i] + '/assets/fonts',
        'public/build/themes/backend/' + frontendThemes[i] + '/fonts',
    ).version([
        'public/build/themes/backend/' + backendThemes[i] + '/js/app.js',
        'public/build/themes/backend/' + backendThemes[i] + '/css/app.css'
    ]).options({
        processCssUrls: false
    });
}