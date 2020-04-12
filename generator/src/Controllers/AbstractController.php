<?php

namespace Website\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Website\Languages;
use Website\Twig;

abstract class AbstractController {

    /**
     * Twig Environment
     *
     * @var \Twig\Environment
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

    /**
     * @var string[]
     */
    private static $routeParameters = [];

    /**
     * @example en
     * @var string
     */
    private static $language = null;

    public function __construct()
    {
        $this->twig = Twig::getTwig($this->getLanguage());
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

    /**
     * @param string[] $parameters The route parameters
     */
    public function setParameters(?array $parameters): void
    {
        if (is_array($parameters)) {
            static::$routeParameters = $parameters;
        }
    }

    /**
     * @return string[] The route parameters
     */
    public function getParameters(): array
    {
        return static::$routeParameters;
    }

    public function getLanguage(): string
    {
        if (static::$language === null) {
            static::$language = strtolower($this->getParameters()['lang'] ?? '');
            if (! in_array(static::$language, Languages::getLanguageCodes())) {
                static::$language = Languages::getDefaultLanguageCode();
            }
        }
        return static::$language;
    }

}
