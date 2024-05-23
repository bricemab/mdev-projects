<?php

class UtilsHelper {
    public static function sumTimeStrings(...$times) {
        $totalMinutes = 0;
        foreach ($times as $time) {
            [$hours, $minutes] = explode(':', $time);
            $totalMinutes += $hours * 60 + $minutes;
        }
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        return sprintf("%02d:%02d", $hours, $minutes);
    }
    public static function subtractTime($time1, $time2) {
        list($hours1, $minutes1) = explode(':', $time1);
        list($hours2, $minutes2) = explode(':', $time2);
        $totalMinutes1 = $hours1 * 60 + $minutes1;
        $totalMinutes2 = $hours2 * 60 + $minutes2;
        $differenceInMinutes = $totalMinutes1 - $totalMinutes2;
        if ($differenceInMinutes < 0) {
            $differenceInMinutes += 24 * 60;
        }
        $hoursDifference = floor($differenceInMinutes / 60);
        $minutesDifference = $differenceInMinutes % 60;
        return sprintf('%02d:%02d', $hoursDifference, $minutesDifference);
    }
    public static function convertDecimalToHoursMinutes($decimalHours) {
        $hours = floor($decimalHours);
        $decimalPart = $decimalHours - $hours;
        $minutes = round($decimalPart * 60);
        return sprintf('%d:%02d', $hours, $minutes);
    }
    public static function convertHoursMinutesToDecimal($hoursMinutes) {
        list($hours, $minutes) = explode(':', $hoursMinutes);
        $decimalMinutes = $minutes / 60;
        $decimalHours = $hours + $decimalMinutes;
        return $decimalHours;
    }

	public static function getCasesFromEnum(array $enum)
	{
		$array = [];
		foreach ($enum as $e) {
			$array[] = $e->value;
		}
		return $array;
	}

    public static $darkThemeColors = [
        '#1F1F1F',
        '#2C2C2C',
        '#383838',
        '#444444',
        '#555555',
        '#666666',
        '#777777',
        '#888888',
        '#999999',
        '#AAAAAA',
        '#BBBBBB',
        '#CCCCCC',
        '#DDDDDD',
        '#EEEEEE',
        '#FFFFFF',
    ];
}
