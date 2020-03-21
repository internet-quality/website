<?php

namespace Website;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Website\Controllers\AbstractController;

class RouteExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('route', [$this, 'buildRoute']),
        ];
    }

    public function buildRoute(string $path): string
    {
        $request = AbstractController::getStaticRequest();
        if ($request->headers->has('x-use-short-paths')) {
            return $path;
        } else {
            return 'index.php?route=' . $path;
        }
    }
}
