<?php

Kirby::plugin('u1/branch-switcher', [
    'snippets' => [
        'organisms/BranchSwitcher' => __DIR__ . '/snippet.php'
    ],
    'routes' => [
        [
            'pattern' => ['api-git-branches', 'git-branches.json', 'git-branches'],
            'method'  => 'GET',
            'action'  => function () {
                if (!u1IsAllowedEnv()) {
                    return \Kirby\Http\Response::json(['status' => 'error', 'message' => 'Forbidden'], 403);
                }

                $data = u1GetBranchData();
                return \Kirby\Http\Response::json($data);
            }
        ],
        [
            'pattern' => ['api-git-switch', 'git-switch.json', 'git-switch'],
            'method'  => 'POST',
            'action'  => function () {
                if (!u1IsAllowedEnv()) {
                    return \Kirby\Http\Response::json(['status' => 'error', 'message' => 'Forbidden'], 403);
                }

                $data   = kirby()->request()->data();
                $target = trim($data['branch'] ?? '');

                if (empty($target) || !preg_match('/^[a-zA-Z0-9._\-\/]+$/', $target)) {
                    return \Kirby\Http\Response::json([
                        'status'  => 'error',
                        'message' => 'Neplatný název větve.'
                    ], 400);
                }

                // Verify branch exists in list
                $branchInfo = u1GetBranchData();
                $validNames = array_column($branchInfo['branches'] ?? [], 'name');

                if (!in_array($target, $validNames, true)) {
                    return \Kirby\Http\Response::json([
                        'status'  => 'error',
                        'message' => 'Větev "' . $target . '" nebyla nalezena.'
                    ], 404);
                }

                if (u1HasGit()) {
                    // Local Git execution
                    u1GitExec('checkout HEAD -- site/store/cache/');
                    $checkoutRes = u1GitExec('checkout ' . escapeshellarg($target));
                    if ($checkoutRes['code'] !== 0) {
                        $msg = implode("\n", $checkoutRes['output']);
                        return \Kirby\Http\Response::json([
                            'status'  => 'error',
                            'message' => 'Chyba při přepínání: ' . $msg
                        ], 500);
                    }
                } else {
                    // Server execution via GitHub API zipball
                    $deployRes = u1DeployServerBranch($target);
                    if ($deployRes['status'] !== 'success') {
                        return \Kirby\Http\Response::json($deployRes, 500);
                    }
                }

                // Clear caches
                try {
                    if ($pagesCache = kirby()->cache('pages')) {
                        $pagesCache->flush();
                    }
                    if ($socialCache = kirby()->cache('social')) {
                        $socialCache->flush();
                    }
                } catch (\Throwable $e) {}

                return \Kirby\Http\Response::json([
                    'status'  => 'success',
                    'message' => 'Větev úspěšně přepnuta.',
                    'current' => $target
                ]);
            }
        ]
    ],
    'hooks' => [
        'page.render:after' => function (string $html, string $contentType): string {
            if (!u1IsAllowedEnv()) {
                return $html;
            }

            if ($contentType !== 'html' || kirby()->request()->is('panel*') || kirby()->request()->is('api*')) {
                return $html;
            }

            ob_start();
            include __DIR__ . '/snippet.php';
            $widgetHtml = ob_get_clean();

            if (str_contains($html, '</body>')) {
                return str_replace('</body>', $widgetHtml . "\n</body>", $html);
            }
            return $html . "\n" . $widgetHtml;
        }
    ]
]);

function u1IsAllowedEnv(): bool {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    // Disabled on production domain
    if (in_array($host, ['u1.cz', 'www.u1.cz'], true)) {
        return false;
    }
    return true;
}

function u1HasGit(): bool {
    $repoDir = kirby()->root('index');
    if (!is_dir($repoDir . '/.git')) {
        return false;
    }
    $res = u1GitExec('status --short');
    return $res['code'] === 0;
}

function u1GitExec(string $args): array {
    $gitPath = 'git';
    if (PHP_OS_FAMILY === 'Windows') {
        $commonPaths = [
            'C:\\Program Files\\Git\\cmd\\git.exe',
            'C:\\Program Files\\Git\\bin\\git.exe',
            'C:\\Program Files (x86)\\Git\\cmd\\git.exe'
        ];
        foreach ($commonPaths as $p) {
            if (file_exists($p)) {
                $gitPath = '"' . $p . '"';
                break;
            }
        }
    }
    $repoDir = kirby()->root('index');
    $cmd = $gitPath . ' -C "' . $repoDir . '" ' . $args . ' 2>&1';
    @exec($cmd, $output, $code);
    return [
        'output' => $output ?? [],
        'code'   => $code ?? 1
    ];
}

function u1GetBranchData(): array {
    $hidden = ['main', 'master', 'head', 'staging', 'content', 'engine'];

    if (u1HasGit()) {
        $res = u1GitExec('branch --list');
        $current = '';
        $branches = [];

        if ($res['code'] === 0) {
            foreach ($res['output'] as $line) {
                $trimmed = trim($line);
                if (empty($trimmed)) continue;
                $isActive = str_starts_with($trimmed, '* ');
                $bName = trim(preg_replace('/^[\*\+\s]+/', '', $trimmed));
                if ($isActive) {
                    $current = $bName;
                }
                if (in_array(strtolower($bName), $hidden, true)) continue;
                $branches[] = [
                    'name'   => $bName,
                    'active' => $isActive
                ];
            }
        }

        if (in_array(strtolower($current), $hidden, true)) {
            $current = 'v2';
        }

        return [
            'status'   => $res['code'] === 0 ? 'success' : 'error',
            'current'  => $current,
            'branches' => $branches
        ];
    }

    return u1GetServerBranches();
}

function u1GetGitHubToken(): string {
    $token = kirby()->option('u1.git-content.token');
    if (!empty($token)) return $token;
    return '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';
}

function u1GetServerBranches(): array {
    $hidden = ['main', 'master', 'head', 'staging', 'content', 'engine'];
    $repoDir = kirby()->root('index');
    $currentFile = $repoDir . '/.current-branch';
    $logFile = $repoDir . '/deploy-log.json';
    $current = 'v2';

    if (file_exists($currentFile)) {
        $c = trim((string)@file_get_contents($currentFile));
        if (!empty($c)) $current = $c;
    } elseif (file_exists($logFile)) {
        $log = json_decode((string)@file_get_contents($logFile), true);
        if (!empty($log['branch'])) $current = $log['branch'];
    }

    if (in_array(strtolower($current), $hidden, true)) {
        $current = 'v2';
    }

    // Cache branches for 30s in temp file
    $cacheFile = sys_get_temp_dir() . '/u1_gh_branches.json';
    $branchesRaw = null;
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 30)) {
        $branchesRaw = json_decode((string)@file_get_contents($cacheFile), true);
    }

    if (!is_array($branchesRaw)) {
        $token = u1GetGitHubToken();
        $ch = curl_init('https://api.github.com/repos/anim4tor/U1/branches');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 6,
            CURLOPT_HTTPHEADER     => [
                'User-Agent: PHP-BranchSwitcher-Client',
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

    // Fallback if GitHub API is unreachable
    if (empty($branches)) {
        foreach (['v1', 'v2', 'v3', 'design'] as $name) {
            if (in_array(strtolower($name), $hidden, true)) continue;
            $branches[] = [
                'name'   => $name,
                'active' => ($name === $current)
            ];
        }
    }

    return [
        'status'   => 'success',
        'current'  => $current,
        'branches' => $branches
    ];
}

function u1DeployServerBranch(string $target): array {
    @ini_set('max_execution_time', 300);
    @ini_set('memory_limit', '512M');
    if (function_exists('set_time_limit')) {
        @set_time_limit(300);
    }

    $repoDir = kirby()->root('index');
    $token   = u1GetGitHubToken();
    $zipUrl  = "https://api.github.com/repos/anim4tor/U1/zipball/{$target}";
    $tempZip = sys_get_temp_dir() . '/deploy_switch_' . uniqid() . '.zip';

    $fp = fopen($tempZip, 'w+');
    $ch = curl_init($zipUrl);
    curl_setopt_array($ch, [
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_FILE           => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_HTTPHEADER     => [
            'User-Agent: PHP-BranchSwitcher-Client',
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

    if (!class_exists('ZipArchive')) {
        @unlink($tempZip);
        return [
            'status'  => 'error',
            'message' => 'PHP rozšíření ZipArchive není na serveru k dispozici.'
        ];
    }

    $zip = new ZipArchive();
    if ($zip->open($tempZip) !== true) {
        @unlink($tempZip);
        return [
            'status'  => 'error',
            'message' => 'Nepodařilo se otevřít stažený zip archív.'
        ];
    }

    $preservePaths = [
        'public/content',
        'public/media',
        'site/cache',
        'site/store/cache',
        'site/store/logs',
        'site/store/safe',
        'site/store/safe/sessions',
        'site/store/safe/accounts',
        'site/sessions',
        'site/accounts',
        '.env',
        'deploy.php',
        'deploy-log.json',
        'sync-content.php',
        'sync-content-log.json',
        '.current-branch'
    ];

    $ignorePatterns = [
        'node_modules',
        'scripts',
        '.github',
        '.git',
        '.gitignore',
        '.gitattributes',
        '.vscode',
        '.idea',
        'bs-config.js',
        'package.json',
        'package-lock.json',
        'prepros.config',
        '*.sublime-*',
        '*.code-workspace'
    ];

    $firstEntry = $zip->getNameIndex(0);
    $rootFolder = explode('/', $firstEntry)[0] . '/';

    for ($i = 0; $i < $zip->numFiles; $i++) {
        $stat = $zip->statIndex($i);
        $entryName = $stat['name'];

        if (str_starts_with($entryName, $rootFolder)) {
            $relativePath = substr($entryName, strlen($rootFolder));
        } else {
            $relativePath = $entryName;
        }

        if (empty($relativePath)) continue;

        $isIgnored = false;
        foreach ($ignorePatterns as $pattern) {
            if ($relativePath === $pattern || str_starts_with($relativePath, $pattern . '/')) {
                $isIgnored = true;
                break;
            }
            if (fnmatch($pattern, $relativePath)) {
                $isIgnored = true;
                break;
            }
        }
        if ($isIgnored) continue;

        $isPreserved = false;
        foreach ($preservePaths as $preserve) {
            if ($relativePath === $preserve || str_starts_with($relativePath, $preserve . '/')) {
                $isPreserved = true;
                break;
            }
        }
        if ($isPreserved) continue;

        $destPath = $repoDir . '/' . $relativePath;

        if (str_ends_with($entryName, '/')) {
            if (!is_dir($destPath)) {
                @mkdir($destPath, 0755, true);
            }
            continue;
        }

        $parentDir = dirname($destPath);
        if (!is_dir($parentDir)) {
            @mkdir($parentDir, 0755, true);
        }

        $fileContent = $zip->getFromIndex($i);
        if ($fileContent !== false) {
            @file_put_contents($destPath, $fileContent);
        }
    }

    $zip->close();
    @unlink($tempZip);

    // Save state
    @file_put_contents($repoDir . '/.current-branch', $target);
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'branch'    => $target,
        'status'    => 'success',
        'source'    => 'branch-switcher-widget'
    ];
    @file_put_contents($repoDir . '/deploy-log.json', json_encode($logData, JSON_PRETTY_PRINT));

    // Invalidate cached branches list
    $cacheFile = sys_get_temp_dir() . '/u1_gh_branches.json';
    @unlink($cacheFile);

    return [
        'status'  => 'success',
        'message' => 'Větev úspěšně přepnuta na serveru.',
        'current' => $target
    ];
}
