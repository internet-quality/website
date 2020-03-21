<?php

namespace Website;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

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
        return 'index.php?route=' . $path;
    }
}
