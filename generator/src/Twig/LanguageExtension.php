<?php

namespace Website\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Website\Languages;

class LanguageExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('default_language_code', function () {
                return Languages::getDefaultLanguageCode();
            }),
            new TwigFunction('language_codes', function () {
                return Languages::getLanguageCodes();
            }),
        ];
    }

}
