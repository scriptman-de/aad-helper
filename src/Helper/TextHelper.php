<?php
/*
 * @author Martin Aulenbach, 2022
 * @package de.scriptman.aad-parser-php
 */

namespace App\Helper;

class TextHelper
{
    public static function TransliterateText(string $input): string
    {
        $translit = \Transliterator::create('any-NFD; [:Nonspacing Mark:] any-remove; any-NFC', \Transliterator::FORWARD);
        return $translit->transliterate($input);
    }
}
