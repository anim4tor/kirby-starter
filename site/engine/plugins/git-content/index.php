<?php

Kirby::plugin('starter/git-content', [
    'hooks' => [
        'page.create:after' => function ($page) { starterSyncPage($page); },
        'page.update:after' => function ($newPage, $oldPage) { starterSyncPage($newPage); },
        'page.delete:after' => function ($status, $page) { starterSyncPage($page); },
        'file.create:after' => function ($file) { starterSyncFile($file); },
        'file.update:after' => function ($newFile, $oldFile) { starterSyncFile($newFile); },
        'file.delete:after' => function ($status, $file) { starterSyncFile($file); },
        'site.update:after' => function ($newSite, $oldSite) { starterSyncSite($newSite); }
    ]
]);

function starterSyncPage($page) {
    if (!$page) return;
    $root = kirby()->root('content');
    $dir = $page->root();
    if (!is_dir($dir)) return;
    
    foreach (glob($dir . '/*.txt') as $file) {
        starterPushContentFile($file);
    }
}

function starterSyncFile($file) {
    if (!$file) return;
    $txt = $file->root() . '.txt';
    if (file_exists($txt)) starterPushContentFile($txt);
}

function starterSyncSite($site) {
    $root = kirby()->root('content');
    foreach (glob($root . '/*.txt') as $file) {
        starterPushContentFile($file);
    }
}

function starterPushContentFile(string $filePath) {
    $config = starterGetProjectConfig();
    $repo = $config['github']['repo'] ?? '';
    $token = $config['github']['token'] ?? '';
    if (empty($repo) || empty($token) || !file_exists($filePath)) return;

    $contentRoot = kirby()->root('content');
    $relPath = 'public/content/' . ltrim(str_replace(['\\', $contentRoot], ['/', ''], $filePath), '/');
    $content = file_get_contents($filePath);

    // Target content and all design branches
    $branches = ['content', 'design'];
    foreach ($branches as $branch) {
        $url = "https://api.github.com/repos/{$repo}/contents/{$relPath}?ref={$branch}";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'User-Agent: PHP-GitContent',
                'Authorization: Bearer ' . $token,
                'Accept: application/vnd.github.v3+json'
            ]
        ]);
        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $sha = null;
        if ($code === 200) {
            $data = json_decode($res, true);
            $sha = $data['sha'] ?? null;
        }

        $putPayload = [
            'message'   => "content(sync): update {$relPath}",
            'content'   => base64_encode($content),
            'branch'    => $branch,
            'committer' => ['name' => 'Kirby Panel (Server)', 'email' => 'panel@example.com']
        ];
        if ($sha) $putPayload['sha'] = $sha;

        $putCh = curl_init("https://api.github.com/repos/{$repo}/contents/{$relPath}");
        curl_setopt_array($putCh, [
            CURLOPT_CUSTOMREQUEST  => 'PUT',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => json_encode($putPayload),
            CURLOPT_HTTPHEADER     => [
                'User-Agent: PHP-GitContent',
                'Authorization: Bearer ' . $token,
                'Accept: application/vnd.github.v3+json',
                'Content-Type: application/json'
            ]
        ]);
        curl_exec($putCh);
        curl_close($putCh);
    }
}
