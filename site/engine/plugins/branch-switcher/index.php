<?php

Kirby::plugin('starter/branch-switcher', [
    'snippets' => [
        'organisms/BranchSwitcher' => __DIR__ . '/snippet.php'
    ],
    'routes' => [
        [
            'pattern' => ['api-git-branches', 'git-branches.json', 'git-branches'],
            'method'  => 'GET',
            'action'  => function () {
                $data = starterGetBranchData();
                return \Kirby\Http\Response::json($data);
            }
        ],
        [
            'pattern' => ['api-git-switch', 'git-switch.json', 'git-switch'],
            'method'  => 'POST',
            'action'  => function () {
                $data   = kirby()->request()->data();
                $target = trim($data['branch'] ?? '');

                if (empty($target) || !preg_match('/^[a-zA-Z0-9._\-\/]+$/', $target)) {
                    return \Kirby\Http\Response::json(['status' => 'error', 'message' => 'Neplatný název větve.'], 400);
                }

                $res = starterDeployServerBranch($target);
                return \Kirby\Http\Response::json($res, $res['status'] === 'success' ? 200 : 500);
            }
        ]
    ]
]);

function starterGetProjectConfig(): array {
    $root = kirby()->root('index');
    $file = $root . '/project.json';
    $localFile = $root . '/project.local.json';
    $c = file_exists($file) ? json_decode((string)file_get_contents($file), true) : [];
    $local = file_exists($localFile) ? json_decode((string)file_get_contents($localFile), true) : [];
    if (is_array($local) && is_array($c)) {
        $c = array_replace_recursive($c, $local);
    }
    return is_array($c) ? $c : [];
}

function starterGetBranchData(): array {
    $config = starterGetProjectConfig();
    $repo = $config['github']['repo'] ?? '';
    $token = $config['github']['token'] ?? '';
    $hidden = $config['github']['system_branches'] ?? ['main', 'master', 'staging', 'content', 'engine'];
    
    $repoDir = kirby()->root('index');
    $currentFile = $repoDir . '/.current-branch';
    $current = 'design';

    if (file_exists($currentFile)) {
        $c = trim((string)@file_get_contents($currentFile));
        if (!empty($c)) $current = $c;
    }

    $cacheFile = sys_get_temp_dir() . '/starter_gh_branches.json';
    $branchesRaw = null;
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 30)) {
        $branchesRaw = json_decode((string)@file_get_contents($cacheFile), true);
    }

    if (!is_array($branchesRaw) && !empty($repo)) {
        $ch = curl_init("https://api.github.com/repos/{$repo}/branches");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 6,
            CURLOPT_HTTPHEADER     => [
                'User-Agent: PHP-BranchSwitcher',
                'Authorization: Bearer ' . $token,
                'Accept: application/vnd.github.v3+json'
            ],
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && !empty($response)) {
            $branchesRaw = json_decode($response, true);
            if (is_array($branchesRaw)) {
                @file_put_contents($cacheFile, $response);
            }
        }
    }

    $branches = [];
    if (is_array($branchesRaw)) {
        foreach ($branchesRaw as $b) {
            $name = $b['name'] ?? '';
            if (empty($name) || in_array(strtolower($name), $hidden, true)) continue;
            $branches[] = [
                'name'   => $name,
                'active' => ($name === $current)
            ];
        }
    }

    if (empty($branches)) {
        $branches[] = ['name' => 'design', 'active' => ($current === 'design')];
    }

    return [
        'status'   => 'success',
        'current'  => $current,
        'branches' => $branches
    ];
}

function starterDeployServerBranch(string $target): array {
    @ini_set('max_execution_time', 300);
    @ini_set('memory_limit', '512M');

    $config = starterGetProjectConfig();
    $repo = $config['github']['repo'] ?? '';
    $token = $config['github']['token'] ?? '';
    $repoDir = kirby()->root('index');

    $zipUrl = "https://api.github.com/repos/{$repo}/zipball/{$target}";
    $tempZip = sys_get_temp_dir() . '/deploy_switch_' . uniqid() . '.zip';

    $fp = fopen($tempZip, 'w+');
    $ch = curl_init($zipUrl);
    curl_setopt_array($ch, [
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_FILE           => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_HTTPHEADER     => [
            'User-Agent: PHP-BranchSwitcher',
            'Authorization: Bearer ' . $token,
            'Accept: application/vnd.github.v3+json'
        ],
        CURLOPT_SSL_VERIFYPEER => true
    ]);

    $success  = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error    = curl_error($ch);
    curl_close($ch);
    fclose($fp);

    if (!$success || $httpCode >= 400 || filesize($tempZip) === 0) {
        @unlink($tempZip);
        return [
            'status'  => 'error',
            'message' => "Nepodařilo se stáhnout větev '{$target}' z GitHubu (HTTP {$httpCode}). " . ($error ?: '')
        ];
    }

    $zip = new ZipArchive();
    if ($zip->open($tempZip) !== true) {
        @unlink($tempZip);
        return ['status' => 'error', 'message' => 'Nelze otevřít stažený archiv ZIP.'];
    }

    $rootPrefix = '';
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $name = $zip->getNameIndex($i);
        if (strpos($name, '/') !== false) {
            $rootPrefix = substr($name, 0, strpos($name, '/') + 1);
            break;
        }
    }

    $preserve = ['public/media', 'site/store/cache', 'site/store/safe', '.env', 'project.json', 'deploy.php'];
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $entryName = $zip->getNameIndex($i);
        $relPath = !empty($rootPrefix) && str_starts_with($entryName, $rootPrefix) ? substr($entryName, strlen($rootPrefix)) : $entryName;
        if (empty($relPath) || str_ends_with($relPath, '/')) continue;

        $skip = false;
        foreach ($preserve as $p) {
            if (str_starts_with($relPath, $p)) { $skip = true; break; }
        }
        if ($skip) continue;

        $destFile = $repoDir . '/' . $relPath;
        $destDir = dirname($destFile);
        if (!is_dir($destDir)) @mkdir($destDir, 0775, true);

        $stream = $zip->getStream($entryName);
        if ($stream) {
            $out = fopen($destFile, 'wb');
            if ($out) {
                stream_copy_to_stream($stream, $out);
                fclose($out);
            }
            fclose($stream);
        }
    }
    $zip->close();
    @unlink($tempZip);

    file_put_contents($repoDir . '/.current-branch', $target);
    return ['status' => 'success', 'message' => 'Větev úspěšně přepnuta.', 'current' => $target];
}

