<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('storage')
    ->notPath('storage/framework')
    ->notPath('storage/framework/views')
    ->notPath('storage/framework/sessions')
    ->notPath('storage/framework/cache')
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true
    ])
    ->setFinder($finder);
