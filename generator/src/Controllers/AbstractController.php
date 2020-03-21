<?php

namespace Website\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Website\RouteExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    protected static $request = null;

    /**
     * The Response object
     *
     * @var Response
     */
    protected static $response = null;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);
        $this->twig->addExtension(new RouteExtension());
        $this->response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
    }

    public static function getStaticRequest(): Request
    {
        if (self::$request === null) {
            self::$request = Request::createFromGlobals();
        }
        return self::$request;
    }

    public function getRequest(): Request
    {
        return self::getStaticRequest();
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function setContent(?string $content): void
    {
        $this->response->setContent($content);
    }

    public function sendResponse(): void
    {
        $this->response->prepare($this->getRequest());
        $this->response->send();
    }
}
