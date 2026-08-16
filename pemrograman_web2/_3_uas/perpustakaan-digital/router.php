<?php
$parsed  = parse_url($_SERVER['REQUEST_URI']);
$uri     = urldecode($parsed['path']);
$query   = isset($parsed['query']) ? $parsed['query'] : '';

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false; // serve static files (css/js/images) directly
}

// Preserve the query string so $_GET works in CodeIgniter
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
$_SERVER['REQUEST_URI']     = $uri.($query !== '' ? '?'.$query : '');
$_SERVER['QUERY_STRING']    = $query;

if ($query !== '')
{
    parse_str($query, $_GET);
}

require __DIR__ . '/index.php';
