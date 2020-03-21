<?php

namespace Website\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Website\RouteExtension;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController {

    /**
     * Twig Environment
     *
     * @var Environment
     */
    protected $twig;

    /**
     * The Request object
     *
     * @var Request
     */
    public static $request = null;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);
        $this->twig->addExtension(new RouteExtension());
    }

    public static function getStaticRequest(): Request
    {
        if (static::$request === null) {
            static::$request = Request::createFromGlobals();
        }
        return static::$request;
    }

    public function getRequest(): Request
    {
        return static::getStaticRequest();
    }

}
