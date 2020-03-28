<?php

namespace Website;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Cache\FilesystemCache;
use Website\RouteExtension;

final class Twig {

    /**
     * Twig Environment
     *
     * @var Environment
     */
    private static $twig;

    /**
     * Twig FilesystemCache
     *
     * @var FilesystemCache
     */
    public static $cacheFS;

    public static function getTwig(): Environment
    {
        return static::makeTwig(false);
    }

    public static function makeTwig(bool $debugMode): Environment
    {
        if (static::$twig !== null) {
            return static::$twig;
        }
        $rootDir = realpath(__DIR__ . '/../') . '/';
        $loader = new FilesystemLoader($rootDir . 'templates');
        if ($debugMode) {
            static::$cacheFS = new FilesystemCache($rootDir . 'tmp');
            static::$twig = new Environment($loader, [
                'cache' => static::$cacheFS,
                'debug' => true,
            ]);
        } else {
            static::$twig = new Environment($loader, [
                'cache' => false,
            ]);
        }
        static::$twig->addExtension(new RouteExtension());
        return static::$twig;
    }

    /**
     * Get static twig cache
     *
     * @return FilesystemCache
     */
    public static function getTwigCacheFS(): FilesystemCache
    {
        return static::$cacheFS;
    }
}
