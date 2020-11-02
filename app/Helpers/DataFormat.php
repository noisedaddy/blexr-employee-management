<?php


namespace App\Helpers;


class DataFormat
{

    /**
     * Calculate time difference between two time selectors
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function differenceInHours($start,$end){
        $datetime1 = new \DateTime($start);
        $datetime2 = new \DateTime($end);
        $interval = $datetime1->diff($datetime2);
        if (($interval->format('%h') == 0) || in_array(null, [$start, $end])) return false;
        return $interval->format('%hh %im');
    }

    /**
     * Format request output for given date/time input
     * @param $request
     * @return false|string
     */
    public static function formatOutput($request){

        $hours_difference = self::differenceInHours($request->start_time, $request->end_time);

        if ($hours_difference)
            return date('F jS, Y', strtotime($request->start_date)).", Hours: ".$hours_difference;
        else
            return date('F jS, Y', strtotime($request->start_date));

    }


}