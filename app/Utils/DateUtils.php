<?php

namespace App\Utils;

use Carbon\Carbon;

/*
 * Date utils
 *
 * Use method: DateUtils::getUnderscoredCurrentDate;
 */

class DateUtils
{
    /**
     * Get underscored current date
     * @return Date $currentDate
     */
    public static function getUnderscoredCurrentDate()
    {
        return Carbon::now()->format('d_m_Y_H_i_s');
    }
}
