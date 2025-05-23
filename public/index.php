<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($className) {
    $directories = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../config/',
    ];

    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

function loadEnv($path)
{
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'"); 
        $_ENV[$key] = $value;
    }
}

loadEnv(__DIR__ . '/../.env');

$path = $_SERVER['PATH_INFO'] ?? '/';
$segments = explode('/', trim($path, '/'));

if (empty($segments[0])) {
    $controllerName = 'main';
    $action = 'index';
    $params = [];
} else {
    $controllerName = $segments[0];
    $action = $segments[1] ?? 'index';
    $params = array_slice($segments, 2);
}

$controllerMap = [
    'main'    => 'MainController',
    'members' => 'MemberController',
    'books'   => 'BookController',
    'loans'   => 'LoanController',
];

$controllerClass = $controllerMap[strtolower($controllerName)] ?? null;

if (!$controllerClass || !class_exists($controllerClass)) {
    http_response_code(404);
    echo "Controller '$controllerName' not found.";
    exit;
}

$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo "Method '$action' not found in controller '$controllerClass'.";
    exit;
}

call_user_func_array([$controller, $action], $params);
