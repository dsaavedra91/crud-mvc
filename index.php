<?php
require_once 'config/database.php';
require_once 'controllers/UserController.php';

session_start();

$requestUri = $_SERVER['REQUEST_URI'];

$afterIndex = strstr($requestUri, 'index.php');

if ($afterIndex !== false) {
    $requestUri = substr($afterIndex, strlen('index.php'));
} else {
    header("Location: index.php/");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$controller = new UserController($db);

$routes = array(
    '/' => 'defaultRoute',
    '/users' => 'indexPage',
    '/login' => 'loginPage',
    '/register' => 'registerPage',
    '/adduser' => 'addUserPage',
    '/insertuser' => 'insertUser',
    '/signin' => 'loginUser',
    '/logout' => 'logoutUser',
    '/deleteuser' => 'deleteUser',
    '/updateuser' => 'updateUser',
);
 $postRoutes = array(
    'insertUser',
    'loginUser',
    'deleteUser',
    'updateUser',
);
    
$routeHandler = $routes[$requestUri] ?? null;

if (preg_match('/^\/users\/edit\/(\d+)$/', $requestUri, $matches)) {
    $routeHandler = 'editUserPage';
    $id = $matches[1];
}

if (!$routeHandler) {
    $routeHandler = 'errorPage';
}

if (in_array($routeHandler, $postRoutes)) {
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $controller->$routeHandler();
    }else {
        $controller->errorPage("Acceso no autorizado");
    }
}else {
    if ($routeHandler === 'editUserPage') {
        $urlParts = explode('/', $requestUri);
        $id = end($urlParts);
        $controller->editUserPage($id ?? null);
    } else {
        $controller->$routeHandler();
    }
}

?>
