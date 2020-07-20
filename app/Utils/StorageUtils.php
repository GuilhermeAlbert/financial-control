<?php

namespace App\Utils;

/*
 * Stub utils
 *
 * Use method: StorageUtils::defineFileName;
 */

class StorageUtils
{
    /**
     * Defines the file name
     * @return String
     */
    public static function defineFileName()
    {
        return DateUtils::getUnderscoredCurrentDate() . uniqid();
    }
}
