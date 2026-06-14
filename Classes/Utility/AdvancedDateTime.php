<?php

namespace Dduers\T3GamingRecords\Utility;

use DateTime;
use DateTimeZone;

class AdvancedDateTime
{
    private DateTimeZone $timeZone;

    public function __construct()
    {
        $defaultTimeZone = date_default_timezone_get();
        $this->timeZone = new DateTimeZone($defaultTimeZone);
    }

    /**
     * convert milli seconds timestamp to hours, minutes and second plus milliseconds
     * 
     * @param string $uTimestamp
     * @return string
     */
    public function uTimestampToDateTime(?string $uTimestamp): string
    {
        if ($uTimestamp === null) {
            return '';
        }

        // clean the input string a bit
        $uTimestamp = trim($uTimestamp);
        // break if not numeric
        if (!is_numeric($uTimestamp)) {
            return '';
        }

        // create datetime object from timestamp, but strip milliseconds
        $timestamp = $uTimestamp / 1000;
        $dateTime = new DateTime('@' . $timestamp);

        // set timezone
        $dateTime->setTimezone($this->timeZone);

        // Format with milliseconds (3 digits)
        $result = $dateTime->format('H:i:s.v');
        // remove empty hours and eventually minutes
        while (str_starts_with($result, '00:')) {
            $result = str_replace('00:', '', $result);
        }
        // if minutes are empty, add 0: minute segment before the seconds segment, otherwise remove left leading zeros
        $result = !strpos($result, ':') ? '0:' . $result : ltrim($result, '0');
        // strip empty milliseconds 
        $result = str_replace('.000', '', $result);

        return $result;
    }

    /**
     * convert date time to a milli second timestamp
     * 
     * @param string $dateTimeString
     * @return string
     */
    public function dateTimeToUTimestamp(string $dateTimeString): string
    {
        if ($dateTimeString === null) {
            return '';
        }

        // clean the input string a bit
        $dateTimeString = trim($dateTimeString);

        // split hours, minutes and seconds from the milliseconds part
        $dataTimeParts = explode('.', $dateTimeString, 2);
        $time = $dataTimeParts[0];
        $mSeconds = $dataTimeParts[1] ?? '0';

        // split hours, minutes and seconds
        $dateTimeParts = explode(':', $time, 3);

        // for every segment of hours, minutes and seconds
        foreach ($dateTimeParts as $key => $part) {
            // if segment is longer then 2 characters long
            if (strlen($part) > 2) {
                // only keep last 2 characters before the ':'
                $part = substr($part, -2);
            }
            // fill to 2 characters, if only 1 characters long
            $dateTimeParts[$key] = str_pad($part, 2, '0', STR_PAD_LEFT);
        }

        // recombine segments hours, minutes, seconds
        $time = implode(':', $dateTimeParts);
        // get format for timestamp creation, depending on segment count
        $format = match (count($dateTimeParts)) {
            1 => 's',
            2 => 'i:s',
            3 => 'H:i:s',
        };
        // use only 3 digits after comma for milliseconds
        $mSeconds = substr($mSeconds, 0, 3);
        // fill milliseconds with zeroes, if less then three digits after comma
        $mSeconds = str_pad($mSeconds, 3, '0', STR_PAD_RIGHT);

        // create the datetime object from the time part and with detected format
        $dateTime = DateTime::createFromFormat($format, $time);
        // set the timezone
        $dateTime->setTimezone($this->timeZone);
        // set date
        $dateTime->setDate(1970, 1, 1);

        // get the timestamp
        $timestamp = $dateTime->getTimestamp();
        // create millisecond timestamp
        $uTimestamp = ($timestamp * 1000) + $mSeconds;
        return $uTimestamp;
    }
}
