<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\RecordDemand;
use Dduers\T3GamingRecords\Domain\Repository\RecordRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RecordHeaderController extends BaseController
{
    public function __construct(
        private readonly RecordRepository $recordRepository
    ) {}

    public function showAction(): ResponseInterface
    {
        $recordId = (int)($this->request->getQueryParams()['tx_t3gamingrecords_record']['recordId'] ?? 0);

        if ($recordId) {
            $this->settings['recordMode'] = 'speedrun';
            $demandDto = GeneralUtility::makeInstance(RecordDemand::class);
            $demand = $demandDto->createDemand($this->settings, $this->request);
            $records = $this->recordRepository->findRecordsByDemand($demand);

            $this->view->assign('data', [
                'record' => $records
            ]);
        }

        return $this->htmlResponse();
    }
}
