<?php

$projectConfigFile = __DIR__ . '/project.json';
$projectConfig = file_exists($projectConfigFile) ? json_decode(file_get_contents($projectConfigFile), true) : [];

$host = $_SERVER['HTTP_HOST'] ?? '';
$isLocal = str_ends_with($host, '.test') 
    || str_ends_with($host, '.local') 
    || in_array($host, ['localhost', '127.0.0.1']);

$stagingBasePath = $projectConfig['servers']['staging']['base_path'] ?? '';
$basePath = $isLocal ? '' : $stagingBasePath;

define('BASE_PROJECT_PATH', $basePath);

require 'kirby/bootstrap.php';

$local = __DIR__;
$kirby = new Kirby([
    'roots' => [
        'site'       => $local . '/site',
        'snippets'   => $local . '/site/components',
        'templates'  => $local . '/site/components/views',
        'admin'      => $local . '/site/admin',
        'config'     => $local . '/site/config',
        'engine'     => $local . '/site/engine',
        'blueprints' => $local . '/site/engine/blueprints',
        'collections'=> $local . '/site/engine/collections',
        'controllers'=> $local . '/site/engine/controllers',
        'models'     => $local . '/site/engine/models',
        'plugins'    => $local . '/site/engine/plugins',
        'store'      => $local . '/site/store',
        'cache'      => $local . '/site/store/cache',
        'logs'       => $local . '/site/store/logs',
        'accounts'   => $local . '/site/store/safe/accounts',
        'sessions'   => $local . '/site/store/safe/sessions',
        'public'     => $local . '/public',
        'content'    => $local . '/public/content',
        'assets'     => $local . '/public/assets',
        'media'      => $local . '/public/media',
    ]
]);

echo $kirby->render();
