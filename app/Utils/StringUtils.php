<?php

namespace App\Utils;

/*
 * Strings utils
 *
 * Use method: StringUtils::removeCharacters;
 */

class StringUtils
{
    /**
     * Remove sended some characters from string
     * @param array $characters
     * @param String $string
     */
    public static function removeCharacters(array $characters, String $string)
    {
        if ($characters && $string) {
            $result = $string;

            foreach ($characters as &$character) $result = str_replace($characters, "", $string);

            if ($result)
                return $result;
            else
                return null;
        }
    }
}
