<?php

$requestUri = $_SERVER["REQUEST_URI"];

spl_autoload_register(function ($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    $appRoot = dirname(__DIR__);
    $path = preg_replace('#^app#', $appRoot, $path);

    if (file_exists($path)) {
        require_once $path;
        return true;
    }

    return false;
});

$routes = require_once './../config/routes.php';

if (isset($routes[$requestUri])) {
    list($class, $method) = $routes[$requestUri];

    $obj = new $class();
    $result = $obj->$method();

    $viewName = $result['view'];
    $data = $result['data'];

    extract($data);

    require_once "./../View/$viewName.phtml";
} else {
    require_once '../View/notFound.html';
};


//use App\Controller\BasketController;
//use App\Controller\MainController;
//use App\Controller\UserController;
//
//if ($requestUri === '/') {
//    $object = new MainController();
//    $object->main();
//} elseif ($requestUri === '/signup') {
//    $object = new UserController();
//    $object->signup();
//} elseif ($requestUri === '/login') {
//    $object = new UserController();
//    $object->login();
//} elseif ($requestUri === '/main') {
//    $object = new MainController();
//    $object->main();
//} elseif ($requestUri === '/basket') {
//    $object = new BasketController();
//    $object->basket();
//} elseif ($requestUri === '/addProduct') {
//    $object = new BasketController();
//    $object->addProducts();
//} elseif ($requestUri === '/logout') {
//    $object = new UserController();
//    $object->logout();
//} else {
//    require_once '../View/notFound.html';
//}

/*
if($requestUri === '/') {
        require_once './handlers/main.php';
    } elseif ($requestUri === '/signup') {
        require_once './handlers/signup.php';
    } elseif ($requestUri === '/login') {
        require_once './handlers/login.php';
    } elseif ($requestUri === '/main') {
        require_once './handlers/main.php';
    } elseif ($requestUri === '/basket') {
        require_once './handlers/basket.php';
    }elseif ($requestUri === '/addProduct') {
        require_once './handlers/addProduct.php';
    } elseif ($requestUri === '/logout') {
        require_once './handlers/logout.php';
    } else {
        require_once './views/notFound.html';
}
*/






