<?php

namespace Website\Twig;

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
        } elseif ($request->headers->has('x-use-html-short-paths')) {
            $path = $path === '/' ? 'index' : $path;
            return $path . '.html';
        } else {
            return 'index.php?route=' . $path;
        }
    }
}
