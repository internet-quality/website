<?php

namespace Website\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Website\Controllers\AbstractController;
use Website\Languages;

class RouteExtension extends AbstractExtension
{
    /**
     * @var string
     */
    private $languageCode;

    public function __construct(string $languageCode)
    {
        $this->languageCode = $languageCode;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('route', [$this, 'buildNormalRoute']),
            new TwigFunction('raw_route', [$this, 'buildRawRoute']),
            new TwigFunction('asset', [$this, 'buildAssetRoute']),
        ];
    }

    public function buildAssetRoute(string $path): string
    {
        $request = AbstractController::getStaticRequest();
        if ($request->headers->has('x-use-html-short-paths')) {
            return '/' . $path;
        }
        return $path;
    }

    public function buildRawRoute(string $path): string
    {
        return $this->buildRoute($path, true);
    }

    public function buildNormalRoute(string $path): string
    {
        return $this->buildRoute($path, false);
    }

    public function buildRoute(string $path, bool $desactivateLanguageCode): string
    {
        $routePrefix = $desactivateLanguageCode ? '' : '/' . $this->languageCode;
        $request = AbstractController::getStaticRequest();
        if ($request->headers->has('x-use-short-paths')) {
            return $routePrefix . $path;
        } elseif ($request->headers->has('x-use-html-short-paths')) {
            foreach (Languages::getLanguageCodes() as $languageCode) {
                $match = $path === '/' . $languageCode;
                if ($match) {
                    return $path = '/' . $languageCode . '/index.html';
                }
            }
            $path = $path === '/' ? '/index' : $path;
            return $routePrefix . $path . '.html';
        } else {
            return 'index.php?route=' . $routePrefix . $path;
        }
    }
}
