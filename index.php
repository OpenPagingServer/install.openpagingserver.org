<?php
$command = isset($_SERVER['HTTP_X_OPS_COMMAND']) ? $_SERVER['HTTP_X_OPS_COMMAND'] : '';
$repoOwner = 'OpenPagingServer';
$repoName = 'OpenPagingServer';

function ops_run_curl($url)
{
    $cmd = 'curl -fsSL -A ' . escapeshellarg('OpenPagingServer-Installer') . ' ' . escapeshellarg($url) . ' 2>&1';
    $body = shell_exec($cmd);

    if ($body === null || $body === false || trim($body) === '') {
        return array(
            'ok' => false,
            'body' => '',
            'error' => 'curl returned empty output'
        );
    }

    return array(
        'ok' => true,
        'body' => $body,
        'error' => ''
    );
}

function ops_release_list($repoOwner, $repoName)
{
    $url = "https://api.github.com/repos/$repoOwner/$repoName/tags?per_page=100";
    $result = ops_run_curl($url);

    if (!$result['ok']) {
        http_response_code(502);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Could not load tags from GitHub',
            'error' => $result['error']
        ));
        exit;
    }

    $tags = json_decode($result['body'], true);

    if (!is_array($tags)) {
        http_response_code(502);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Invalid GitHub tag response',
            'raw' => substr($result['body'], 0, 500)
        ));
        exit;
    }

    $items = array();

    foreach ($tags as $tag) {
        if (!isset($tag['name'])) {
            continue;
        }

        $items[] = array(
            'name' => $tag['name'],
            'ref' => $tag['name']
        );
    }

    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array(
        'status' => 'ok',
        'repo' => "$repoOwner/$repoName",
        'count' => count($items),
        'items' => $items
    ));
    exit;
}

function ops_ref_allowed($repoOwner, $repoName, $ref)
{
    if ($ref === 'main') {
        return true;
    }

    $url = "https://api.github.com/repos/$repoOwner/$repoName/git/ref/tags/" . rawurlencode($ref);
    $result = ops_run_curl($url);

    if (!$result['ok']) {
        return false;
    }

    $data = json_decode($result['body'], true);

    return is_array($data) && isset($data['ref']);
}

function ops_download_archive($repoOwner, $repoName)
{
    $ref = isset($_GET['ref']) ? trim((string)$_GET['ref']) : '';

    if ($ref === '') {
        http_response_code(400);
        header('Content-Type: text/plain; charset=UTF-8');
        echo 'Missing ref';
        exit;
    }

    if (!preg_match('/^[A-Za-z0-9._\/-]+$/', $ref)) {
        http_response_code(400);
        header('Content-Type: text/plain; charset=UTF-8');
        echo 'Invalid ref';
        exit;
    }

    if (!ops_ref_allowed($repoOwner, $repoName, $ref)) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=UTF-8');
        echo 'Ref not found';
        exit;
    }

    $url = "https://codeload.github.com/$repoOwner/$repoName/tar.gz/" . rawurlencode($ref);

    header('Content-Type: application/gzip');
    header('Content-Disposition: attachment; filename="OpenPagingServer-' . basename($ref) . '.tar.gz"');

    passthru('curl -fsSL -A ' . escapeshellarg('OpenPagingServer-Installer') . ' ' . escapeshellarg($url), $exitCode);

    if ($exitCode !== 0) {
        exit;
    }

    exit;
}

if ($command === 'releases') {
    ops_release_list($repoOwner, $repoName);
}

if ($command === 'download') {
    ops_download_archive($repoOwner, $repoName);
}

$accept = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
$browser = strpos($accept, 'text/html') !== false;

if ($browser) {
    $webFile = __DIR__ . '/web.html';

    if (is_file($webFile) && is_readable($webFile)) {
        header('Content-Type: text/html; charset=UTF-8');
        readfile($webFile);
        exit;
    }

    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'web.html not found';
    exit;
}

$url = 'https://raw.githubusercontent.com/OpenPagingServer/Installer/main/openpagingserverinstall.sh';

header('Content-Type: text/x-shellscript; charset=UTF-8');
header('Content-Disposition: inline; filename="openpagingserverinstall.sh"');

readfile($url);
