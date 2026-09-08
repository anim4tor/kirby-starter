<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');
ignore_user_abort(true);

$projectConfig = file_exists(__DIR__ . '/project.json') ? json_decode(file_get_contents(__DIR__ . '/project.json'), true) : [];
$secret       = $projectConfig['github']['secret'] ?? 'starter_secret_change_me';
$repo         = $projectConfig['github']['repo'] ?? '';
$githubToken  = $projectConfig['github']['token'] ?? '';
$targetBranch = $_REQUEST['branch'] ?? 'design';
$projectDir   = __DIR__;
$logFile      = __DIR__ . '/deploy-log.json';

if (isset($_GET['log']) && isset($_GET['secret']) && hash_equals($secret, $_GET['secret'])) {
    if (file_exists($logFile)) echo file_get_contents($logFile);
    else echo json_encode(['status' => 'no_log_yet']);
    exit;
}

$providedSecret = $_REQUEST['secret'] ?? '';
if (empty($providedSecret) || !hash_equals($secret, $providedSecret)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized: invalid secret.']);
    exit;
}

$zipUrl = "https://api.github.com/repos/{$repo}/zipball/{$targetBranch}";
$tempZip = sys_get_temp_dir() . '/deploy_' . uniqid() . '.zip';

$fp = fopen($tempZip, 'w+');
$ch = curl_init($zipUrl);
curl_setopt_array($ch, [
    CURLOPT_TIMEOUT        => 120,
    CURLOPT_FILE           => $fp,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 5,
    CURLOPT_HTTPHEADER     => [
        'User-Agent: PHP-AutoDeploy',
        'Authorization: Bearer ' . $githubToken,
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
    echo json_encode(['status' => 'error', 'message' => "Failed to download zip (HTTP {$httpCode}). " . $error]);
    exit;
}

$zip = new ZipArchive();
if ($zip->open($tempZip) !== true) {
    @unlink($tempZip);
    echo json_encode(['status' => 'error', 'message' => 'Cannot open zip.']);
    exit;
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
$extracted = 0;
for ($i = 0; $i < $zip->numFiles; $i++) {
    $entry = $zip->getNameIndex($i);
    $rel = !empty($rootPrefix) && str_starts_with($entry, $rootPrefix) ? substr($entry, strlen($rootPrefix)) : $entry;
    if (empty($rel) || str_ends_with($rel, '/')) continue;

    $skip = false;
    foreach ($preserve as $p) {
        if (str_starts_with($rel, $p)) { $skip = true; break; }
    }
    if ($skip) continue;

    $dest = $projectDir . '/' . $rel;
    $d = dirname($dest);
    if (!is_dir($d)) @mkdir($d, 0775, true);

    $stream = $zip->getStream($entry);
    if ($stream) {
        $out = fopen($dest, 'wb');
        if ($out) {
            stream_copy_to_stream($stream, $out);
            fclose($out);
            $extracted++;
        }
        fclose($stream);
    }
}
$zip->close();
@unlink($tempZip);

file_put_contents($projectDir . '/.current-branch', $targetBranch);
file_put_contents($logFile, json_encode([
    'timestamp' => date('Y-m-d H:i:s'),
    'branch'    => $targetBranch,
    'status'    => 'success',
    'files_extracted' => $extracted
], JSON_PRETTY_PRINT));

echo json_encode(['status' => 'success', 'message' => 'Deployment successful.', 'branch' => $targetBranch, 'files' => $extracted]);
