<?php

namespace Website\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Website\Languages;

class LanguageExtension extends AbstractExtension
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
            new TwigFunction('default_language_code', function () {
                return Languages::getDefaultLanguageCode();
            }),
            new TwigFunction('language_codes', function () {
                return Languages::getLanguageCodes();
            }),
            new TwigFunction('current_language', function () {
                return $this->languageCode;
            }),
        ];
    }

}
