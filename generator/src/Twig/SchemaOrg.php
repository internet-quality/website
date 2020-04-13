<?php

namespace Website\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SchemaOrg extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('schema', function (array $object) {
                $object['@context'] = 'http://schema.org/';
                return '<script type="application/ld+json">' .
                json_encode($object, JSON_UNESCAPED_SLASHES) . '</script>';
            }, ['is_safe' => ['html']]),
        ];
    }

}
