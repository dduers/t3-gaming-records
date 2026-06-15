<?php

declare(strict_types=1);

namespace Dduers\T3GamingRecords\Utility;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class AdvancedNumber
{
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

        $result = number_format($number, 0, '.', '\'');
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

        $result = (int)str_replace(['.', '\''], '', $formattedNumber);
        return $result;
    }
}
