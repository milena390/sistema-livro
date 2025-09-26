<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\UserController;

$basePath = '/sistema-livro/milena-problema/project-app/public';

// Obtém a URI da requisição, limpa query strings e o path base
$fullUri = $_SERVER['REQUEST_URI'] ?? '/';
$uri = $fullUri;

// Remove a query string
if (($pos = strpos($uri, '?')) !== false) {
    $uri = substr($uri, 0, $pos);
}

// Remove o basePath do começo da URI, se existir
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Normaliza barra inicial e espaços
$uri = '/' . ltrim(trim($uri), '/');

// Rotas
switch (true) {
    case $uri === '/' || $uri === '':
        (new HomeController())->index();
        break;

    case $uri === '/login':
        (new AuthController())->showLogin();
        break;

    case $uri === '/auth/login':
        (new AuthController())->login();
        break;

    case $uri === '/auth/logout':
        (new AuthController())->logout();
        break;

    case $uri === '/users':
        (new UserController())->index();
        break;

    case $uri === '/users/create':
        (new UserController())->create();
        break;

    case preg_match('#^/users/edit/(\d+)$#', $uri, $matches):
        (new UserController())->edit((int)$matches[1]);
        break;

    case $uri === '/users/save':
        (new UserController())->save();
        break;

    case preg_match('#^/users/delete/(\d+)$#', $uri, $matches):
        (new UserController())->delete((int)$matches[1]);
        break;

    default:
        http_response_code(404);
        echo "<div class='container mt-4'><h1>404 - Página não encontrada</h1>";
        echo "<p>A página solicitada não existe.</p>";
        echo "<a href='{$basePath}/' class='btn btn-primary'>Voltar para Home</a></div>";
        break;
}
