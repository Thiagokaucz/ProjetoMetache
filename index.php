<?php
// Carrega o arquivo de rotas
require_once('routes.php');

// Obtém a URL atual
$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

// Verifica se a rota existe
if (array_key_exists($url, $routes)) {
    // Separa o nome do controlador e o metodo
    $route = explode('@', $routes[$url]);
    $controllerName = $route[0];
    $methodName = $route[1];

    // Carrega o controlador
    require_once('app/controllers/' . $controllerName . '.php');

    // Instancia o controlador e chama o metodo
    $controller = new $controllerName();
    if ($url === '/forgot-password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->handleForm();
    } else {
        $controller->$methodName();
    }
} else {
    // Pagina nao encontrada
    http_response_code(404);
    require_once('app/views/header.php');
    require_once('app/views/error.php');
    require_once('app/views/footer.php');
}
?>
