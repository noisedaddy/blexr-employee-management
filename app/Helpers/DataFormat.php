<?php


namespace App\Helpers;


class DataFormat
{

    /**
     * Format date range
     * @param string $start_date
     * @param string $end_date
     * @return string
     */
    public static function jb_verbose_date_range($start_date = '', $end_date = '') {

//            $dateStart = explode('-', $start_date);
//            $dateEnd = explode('-', $end_date);
//
//            if (strlen($dateStart[2]) == 2){
//                $dateStart[2] = '20'.$dateStart[2];
//                $dateStart = $dateStart[0].'-'.$dateStart[1].'-'.$dateStart[2];
//            } else {
//                $dateStart = $start_date;
//            }
//
//            if (strlen($dateEnd[2]) == 2) {
//                $dateEnd[2] = '20' . $dateEnd[2];
//                $dateEnd = $dateEnd[0] . '-' . $dateEnd[1] . '-' . $dateEnd[2];
//            } else {
//                $dateEnd = $end_date;
//            }


        $start_date = strtotime($start_date);
        $end_date = strtotime($end_date);

        $date_range = '';

        // If only one date, or dates are the same set to FULL verbose date
        if (empty($start_date) || empty($end_date) || ( date('FjY', $start_date) == date('FjY', $end_date) )) { // FjY == accounts for same day, different time
            $start_date_pretty = date('F jS, Y', $start_date);
            $end_date_pretty = date('F jS, Y', $end_date);
        } else {
            // Setup basic dates
            $start_date_pretty = date('F j', $start_date);
            $end_date_pretty = date('jS, Y', $end_date);
            // If years differ add suffix and year to start_date
            if (date('Y', $start_date) != date('Y', $end_date)) {
                $start_date_pretty .= date('S, Y', $start_date);
            }

            // If months differ add suffix and year to end_date
            if (date('F', $start_date) != date('F', $end_date)) {
                $end_date_pretty = date('F ', $end_date) . $end_date_pretty;
            }
        }

        // build date_range return string
        if (!empty($start_date)) {
            $date_range .= $start_date_pretty;
        }

        // check if there is an end date and append if not identical
        if (!empty($end_date)) {
            if ($end_date_pretty != $start_date_pretty) {
                $date_range .= ' - ' . $end_date_pretty;
            }
        }
        return $date_range;
    }

}