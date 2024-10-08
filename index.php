<?php
// Carrega o arquivo de rotas
require_once('routes.php');

// Obtém a URL atual
$url = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/';

// Verifica se a rota existe
if (array_key_exists($url, $routes)) { 
    // Separa o nome do controlador e o método
    $route = explode('@', $routes[$url]);
    
    $controllerName = $route[0];
    $methodName = $route[1];

    // Carrega o controlador
    require_once('app/controllers/' . $controllerName . '.php');

    // Instancia o controlador e chama o método
    $controller = new $controllerName();
    $controller->$methodName();
} else {
    // Página não encontrada
    http_response_code(404);
    require_once('app/views/error.php');
}
