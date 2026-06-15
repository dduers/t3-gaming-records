<?php

declare(strict_types=1);

namespace Dduers\T3GamingRecords\Validation;

use Dduers\T3GamingRecords\Utility\AdvancedDateTime;

/**
 * for flex form "record": 
 * evaluate time field back and forward
 */
class FormEvalRecordTime
{
    /**
     * before save a record
     * 
     * @param string $value
     * @param $is_in
     * @param &$set
     * @return ?string
     */
    public function evaluateFieldValue(string $value, $is_in, &$set): ?int
    {
        $dateTimeString = $value;
        $result = new AdvancedDateTime();
        return $result->dateTimeToUTimestamp($dateTimeString);
    }

    /**
     * on load a record
     * 
     * @param array $parameters
     * @return ?string
     */
    public function deevaluateFieldValue(array $parameters): ?string
    {
        $milliSeconds = $parameters['value'];
        $result = new AdvancedDateTime();
        return $result->uTimestampToDateTime($milliSeconds);
    }

    /**
     * js code to return field value
     * 
     * @return string
     */
    public function returnFieldJS(): string
    {
        return 'return value;';
    }
}
