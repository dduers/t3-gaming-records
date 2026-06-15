<?php

declare(strict_types=1);

namespace Dduers\T3GamingRecords\Utility;

class AdvancedDateTime
{
    /**
     * convert milli seconds timestamp to hours, minutes and second plus milliseconds
     * 
     * @param ?int $milliSeconds
     * @return ?string
     */
    public function uTimestampToDateTime(?int $milliSeconds): ?string
    {
        if ($milliSeconds === null) {
            return null;
        }

        $hours = (int)floor($milliSeconds / 3600000);
        $minutes = (int)floor(($milliSeconds % 3600000) / 60000);
        $seconds = (int)floor(($milliSeconds % 60000) / 1000);
        $millis = (int)($milliSeconds % 1000);

        if ($hours) {
            $result = sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
        } elseif ($minutes) {
            $result = sprintf("%d:%02d", $minutes, $seconds);
        } else {
            $result = sprintf("0:%02d", $seconds);
        }
        if ($millis) {
            $result .= '.' . sprintf("%03d", $millis);
        }

        return $result;
    }

    /**
     * convert date time to a milli second timestamp
     * 
     * @param ?string $dateTimeString
     * @return ?int
     */
    public function dateTimeToUTimestamp(?string $dateTimeString): ?int
    {
        if ($dateTimeString === null) {
            return null;
        }

        $dateTimeString = trim($dateTimeString);
        if ($dateTimeString === '') {
            return 0;
        }

        $dataTimeParts = explode('.', $dateTimeString, 2);
        $hoursMinutesSeconds = ($dataTimeParts[0] ?? 0);
        $millis = (int)($dataTimeParts[1] ?? 0);
        if ($millis < 100) {
            $millis = (int)str_pad((string)$millis, 3, '0', STR_PAD_RIGHT);
        }

        $timeParts = explode(':', $hoursMinutesSeconds, 3);
        $result = (int)match (count($timeParts)) {
            1 => $timeParts[0] * 1000 + $millis,
            2 => $timeParts[0] * 60000 + $timeParts[1] * 1000 + $millis,
            3 => $timeParts[0] * 3600000 + $timeParts[1] * 60000 + $timeParts[2] * 1000 + $millis
        };

        return $result;
    }
}
