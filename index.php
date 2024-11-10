<?php



require_once('rotas.php');

$url = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/';

if (array_key_exists($url, $rotas)) { 

    $rota = explode('@', $rotas[$url]);
    
    $controllerName = $rota[0];
    $methodName = $rota[1];

    require_once('app/controllers/' . $controllerName . '.php');

    $controller = new $controllerName();
    $controller->$methodName();
} else {
    http_response_code(404);
    require_once 'app/views/header.php';
    require_once('app/views/error.php');
}