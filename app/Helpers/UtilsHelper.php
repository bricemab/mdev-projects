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
}
