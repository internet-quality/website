<?php

namespace Website;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Website\Controllers\AbstractController;
use Website\Controllers\MiscController;
use Website\Controllers\HomeController;
use Website\Controllers\WebsitesController;

use function FastRoute\simpleDispatcher;

final class Routing
{

    public static function manageRouting(): void
    {
        $request = AbstractController::getStaticRequest();

        /** @var string $route */
        $route = $request->query->get('route') ?? $request->request->get('route') ?? '/';

        $routeInfo = self::getDispatcher()->dispatch(
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
                $controller->setParameters($routeInfo[2]);
                $controller->$action();
                $controller->sendResponse();
                break;
        }
    }

    public static function getDispatcher(): Dispatcher
    {
        return simpleDispatcher(function (RouteCollector $routes) {
            $routes->addGroup('', function (RouteCollector $routes) {
                $routes->get('[/]', [HomeController::class, 'index']);
            });
            $routes->addGroup('/{lang}', function (RouteCollector $routes) {
                $routes->get('[/]', [HomeController::class, 'index']);
                $routes->get('/index', [HomeController::class, 'index']);
                $routes->get('/contact', [MiscController::class, 'contact']);
                $routes->get('/legal', [MiscController::class, 'legal']);
                $routes->get('/websites', [WebsitesController::class, 'index']);
            });
        });
    }
}
