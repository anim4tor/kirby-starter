<?php

$root = dirname(__DIR__, 2);
$projectConfigFile = $root . '/project.json';
$localConfigFile = $root . '/project.local.json';

$project = file_exists($projectConfigFile) ? json_decode(file_get_contents($projectConfigFile), true) : [];
$local = file_exists($localConfigFile) ? json_decode(file_get_contents($localConfigFile), true) : [];

if (is_array($local)) {
    $project = array_replace_recursive($project, $local);
}

return [
    'debug'         => true,
    'panel.install' => true,
    'languages'     => false,
    'u1.git-content' => [
        'enabled'  => true,
        'repo'     => $project['github']['repo'] ?? '',
        'token'    => $project['github']['token'] ?? '',
        'secret'   => $project['github']['secret'] ?? '',
        'author'   => [
            'name'  => 'Kirby Panel (Server)',
            'email' => 'panel@example.com'
        ]
    ]
];
