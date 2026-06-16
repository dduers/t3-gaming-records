<?php

declare(strict_types=1);

namespace Dduers\T3GamingRecords\Validation;

use Dduers\T3GamingRecords\Utility\AdvancedNumber;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

/**
 * for backend flex form "record": 
 * evaluate score field back and forward
 */
class FormEvalRecordScore
{
    /**
     * constructor
     * 
     * @param ?BackendUserAuthentication $backendUser
     * @param ?string $languageKey
     */
    public function __construct(
        private ?BackendUserAuthentication $backendUser = null,
        private ?string $languageKey = null
    ) {
        $this->backendUser = $GLOBALS['BE_USER'] ?? null;
        $this->languageKey = $this->backendUser?->getUserSettings()?->get('lang') ?: 'en';
    }
    /**
     * before save a record
     * 
     * @param string $value
     * @param $is_in
     * @param &$set
     * @return ?int
     */
    public function evaluateFieldValue(string $value, $is_in, &$set): ?int
    {
        $formattedNumber = $value;
        $result = new AdvancedNumber($this->languageKey);
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
        $result = new AdvancedNumber($this->languageKey);
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
