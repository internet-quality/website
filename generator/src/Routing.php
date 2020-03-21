<?php

namespace Website;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Website\Controllers\AbstractController;
use Website\Controllers\HomeController;
use function FastRoute\simpleDispatcher;

final class Routing
{

    public static function manageRouting(): void
    {
        $request = AbstractController::getStaticRequest();
        $dispatcher = simpleDispatcher(function (RouteCollector $routes) {
            $routes->addGroup('', function (RouteCollector $routes) {
                $routes->addRoute(['GET', 'POST'], '[/]', [HomeController::class, 'index']);
            });
            $routes->get('/websites', [HomeController::class, 'index']);
        });

        /** @var string $route */
        $route = $request->query->get('route') ?? $request->request->get('route') ?? '/';

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            rawurldecode($route)
        );

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $controller = new HomeController();
                $controller->notFound($route);
                $controller->sendResponse();
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $controller = new HomeController();
                $controller->notAllowed($route, $allowedMethods);
                $controller->sendResponse();
                break;
            case Dispatcher::FOUND:
                [$controllerName, $action] = $routeInfo[1];
                /** @var AbstractController $controller */
                $controller = new $controllerName();
                $controller->$action($routeInfo[2]);
                $controller->sendResponse();
                break;
        }
    }
}