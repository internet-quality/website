<?php

namespace Website\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Website\RouteExtension;

abstract class AbstractController {

    /**
     * Twig Environment
     *
     * @var Environment
     */
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);
        $this->twig->addExtension(new RouteExtension());
    }

}
