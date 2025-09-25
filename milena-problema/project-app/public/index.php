<?php
/**
 * Ponto de entrada da aplicação - Versão com Autoloader
 */

declare(strict_types=1);

// Incluir o autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\UserController;

// Obter a URI completa
$fullUri = $_SERVER['REQUEST_URI'];

// Definir o path base da sua aplicação
$basePath = '/aulas/repo-pw3/milena-problema/project-app/public';

// Remover o path base da URI
$uri = $fullUri;
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Se ficar vazio, redirecionar para home
if ($uri === '' || $uri === '/') {
    $uri = '/';
}

// Remover parâmetros da query string
if (strpos($uri, '?') !== false) {
    $uri = substr($uri, 0, strpos($uri, '?'));
}

// Definir rotas
switch ($uri) {
    case '/':
    case '':
        $controller = new HomeController();
        $controller->index();
        break;
        
    case '/login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
        
    case '/auth/login':
        $controller = new AuthController();
        $controller->login();
        break;
        
    case '/auth/logout':
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case '/users':
        $controller = new UserController();
        $controller->index();
        break;
        
    case '/users/create':
        $controller = new UserController();
        $controller->create();
        break;
        
    case (preg_match('/\/users\/edit\/(\d+)/', $uri, $matches) ? true : false):
        $controller = new UserController();
        $controller->edit((int)$matches[1]);
        break;
        
    case '/users/save':
        $controller = new UserController();
        $controller->save();
        break;
        
    case (preg_match('/\/users\/delete\/(\d+)/', $uri, $matches) ? true : false):
        $controller = new UserController();
        $controller->delete((int)$matches[1]);
        break;
        
    default:
        http_response_code(404);
        echo "<div class='container mt-4'><h1>404 - Página não encontrada</h1>";
        echo "<p>A página solicitada não existe.</p>";
        echo "<a href='{$basePath}/' class='btn btn-primary'>Voltar para Home</a></div>";
        break;
}
?>