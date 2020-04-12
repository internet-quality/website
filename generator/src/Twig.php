<?php

namespace Website;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Cache\FilesystemCache;
use Website\Twig\RouteExtension;
use Wdes\phpI18nL10n\plugins\MoReader;
use Wdes\phpI18nL10n\Launcher;
use Wdes\phpI18nL10n\Twig\Extension\I18n as ExtensionI18n;
use Website\Twig\LanguageExtension;

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

    public static function getTwig(string $languageCode): Environment
    {
        return static::makeTwig($languageCode, false);
    }

    public static function makeTwig(string $languageCode, bool $debugMode): Environment
    {
        if (static::$twig !== null) {
            return static::$twig;
        }
        $rootDir = realpath(__DIR__ . '/../') . '/';

        $dataDir  = $rootDir . 'locale/';
        $moReader = new MoReader(
            ['localeDir' => $dataDir]
        );
        $moReader->readFile($dataDir . $languageCode . '/LC_MESSAGES/internet-quality.mo');
        Launcher::$plugin = $moReader;

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
        static::$twig->addExtension(new LanguageExtension());
        static::$twig->addExtension(new ExtensionI18n());
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
