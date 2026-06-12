<?php

namespace Dduers\T3GamingRecords\Validation;

use Dduers\T3GamingRecords\Utility\AdvancedDateTime;

class FormEvalRecordTime
{
    // before save a record
    public function evaluateFieldValue(string $value, $is_in, &$set): string
    {
        $dateTimeString = $value;
        $result = new AdvancedDateTime();
        return $result->dateTimeToUTimestamp($dateTimeString);
    }

    // on load a record
    public function deevaluateFieldValue(array $parameters): string
    {
        $uTimestampString = $parameters['value'];
        $result = new AdvancedDateTime();
        return $result->uTimestampToDateTime($uTimestampString);
    }

    public function returnFieldJS(): string
    {
        return 'return value;';
    }
}
