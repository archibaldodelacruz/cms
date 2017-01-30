<?php

namespace Deployer;

require 'recipe/laravel.php';

// Configuration

set('repository', 'git@github.com:protecms/cms.git');
set('writable_use_sudo', false);
set('writable_mode', 'chmod');

add('shared_files', []);
add('shared_dirs', [
    'public/uploads',
    'node_modules',
]);

add('writable_dirs', [
    'public/uploads',
]);

// Servers

server('production', 'protecms.com')
    ->user('USER')
    ->identityFile('~/.ssh/id_rsa.pub', '~/.ssh/id_rsa')
    ->set('deploy_path', 'PATH');

// Tasks

task('composer:install', function () {
    run('cd {{release_path}} && composer install');
});

task('compile:assets', function () {
    run('cd {{release_path}} && npm install && gulp --production');
});

before('deploy:symlink', 'composer:install');
before('deploy:symlink', 'compile:assets');
