<?php

namespace Website;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Website\Controllers\HomeController;
use function FastRoute\simpleDispatcher;

final class Routing
{

    public static function manageRouting(): void
    {

        $dispatcher = simpleDispatcher(function (RouteCollector $routes) {
            $routes->addGroup('', function (RouteCollector $routes) {
                $routes->addRoute(['GET', 'POST'], '[/]', [HomeController::class, 'index']);
            });
            $routes->get('/websites', [HomeController::class, 'index']);
        });

        /** @var string $route */
        $route = $_GET['route'] ?? $_POST['route'] ?? '/';

        $routeInfo = $dispatcher->dispatch(
            $_SERVER['REQUEST_METHOD'],
            rawurldecode($route)
        );

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                (new HomeController())->notFound($route);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                (new HomeController())->notAllowed($route, $allowedMethods);
                break;
            case Dispatcher::FOUND:
                [$controllerName, $action] = $routeInfo[1];
                $controller = new $controllerName();
                $controller->$action($routeInfo[2]);
                break;
        }
    }
}
