<?php

namespace Website;

final class Languages {

    /**
     * @return array<int,\stdClass>
     */
    public static function getLanguages(): array
    {
        return [
            (object) ['code' => 'en', 'name' => 'English', 'displayed' => true, 'default' => true],
        ];
    }

    /**
     * @return array<int,string>
     */
    public static function getLanguageCodes(): array
    {
        return [
            'en',
        ];
    }

    /**
     * @return string
     */
    public static function getDefaultLanguageCode(): string
    {
        return 'en';
    }
}
