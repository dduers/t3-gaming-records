<?php

declare(strict_types=1);

namespace Dduers\T3GamingRecords\Utility;

use NumberFormatter;

class AdvancedNumber
{
    /**
     * constructor
     * 
     * @property string $locale
     */
    public function __construct(
        private string $locale = 'en-US'
    ) {}

    /**
     * format a number
     * 
     * @param ?int $number
     * @return ?string
     */
    public function numberToFormatted(?int $number): ?string
    {
        if ($number === null) {
            return null;
        }

        $formatter = new NumberFormatter($this->locale, NumberFormatter::DECIMAL);
        $result = $formatter->format($number);
        return $result;
    }

    /**
     * remove format from a number
     * 
     * @param ?string $formattedNumber
     * @return ?int
     */
    public function formattedToNumber(?string $formattedNumber): ?int
    {
        if ($formattedNumber === null) {
            return null;
        }

        $formattedNumber = trim($formattedNumber);
        if ($formattedNumber === '') {
            return null;
        }

        $formatter = new NumberFormatter($this->locale, NumberFormatter::DECIMAL);
        $result = (int)$formatter->parse($formattedNumber);
        return $result;
    }
}
