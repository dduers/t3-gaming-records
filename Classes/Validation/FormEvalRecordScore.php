<?php

declare(strict_types=1);

namespace Dduers\T3GamingRecords\Validation;

use Dduers\T3GamingRecords\Utility\AdvancedNumber;

/**
 * for flex form "record": 
 * evaluate score field back and forward
 */
class FormEvalRecordScore
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
        $formattedNumber = $value;
        $result = new AdvancedNumber();
        return $result->formattedToNumber($formattedNumber);
    }

    /**
     * on load a record
     * 
     * @param array $parameters
     * @return ?string
     */
    public function deevaluateFieldValue(array $parameters): ?string
    {
        $number = $parameters['value'];
        $result = new AdvancedNumber();
        return $result->numberToFormatted($number);
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
