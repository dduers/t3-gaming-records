<?php

declare(strict_types=1);

namespace Dduers\T3GamingRecords\Domain\Finishers;

use Dduers\T3GamingRecords\Utility\AdvancedDateTime;
use Override;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Form\Domain\Finishers\FinisherInterface;

/**
 * before saving the frontend form to the database
 */
class ProcessFormNewRecordData extends AbstractFinisher implements FinisherInterface
{
    #[Override]
    public function executeInternal()
    {
        $formValues = $this->finisherContext->getFormValues();
        $formState = $this->finisherContext->getFormRuntime()->getFormState();

        DebuggerUtility::var_dump($formValues, 'Form Values');

        $formEvalRecordTime = GeneralUtility::makeInstance(AdvancedDateTime::class);
        $scoreTimeEvaluated = $formEvalRecordTime->dateTimeToUTimestamp($formValues['text-time']);
        $formState->setFormValue('text-time', $scoreTimeEvaluated);
    }
}
