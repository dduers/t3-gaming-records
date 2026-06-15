<?php

declare(strict_types=1);

namespace Dduers\T3GamingRecords\Domain\Finishers;

use Dduers\T3GamingRecords\Utility\AdvancedDateTime;
use Override;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Form\Domain\Finishers\FinisherInterface;

class ProcessFormNewRecordData extends AbstractFinisher implements FinisherInterface
{
    #[Override]
    public function executeInternal()
    {
        $formValues = $this->finisherContext->getFormValues();
        $formState = $this->finisherContext->getFormRuntime()->getFormState();

        $formEvalRecordTime = GeneralUtility::makeInstance(AdvancedDateTime::class);

        if ($formValues['text-time'] === "") {
            $formState->setFormValue('text-time', null);
        } else {
            $scoreTimeEvaluated = $formEvalRecordTime->dateTimeToUTimestamp($formValues['text-time']);
            $formState->setFormValue('text-time', $scoreTimeEvaluated);
        }

        if ($formValues['text-score'] === "") {
            $formState->setFormValue('text-score', null);
        }
    }
}
