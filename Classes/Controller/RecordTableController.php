<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\RecordDemand;
use Dduers\T3GamingRecords\Domain\Repository\RecordRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class RecordTableController extends BaseController
{
    public function __construct(
        private readonly RecordRepository $recordRepository
    ) {}

    public function showAction(): ResponseInterface
    {
        $recordId = (int)($this->request->getQueryParams()['tx_t3gamingrecords_record']['recordId'] ?? 0);

        if ($recordId) {
            
            $demandDto = GeneralUtility::makeInstance(RecordDemand::class);
            $demand = $demandDto->createDemand($this->settings, $this->request);
            $records = $this->recordRepository->findRecordsByDemand($demand);

            //$this->var_dump($records, 'records');

            $this->view->assign('data', [
                'record' => $records
            ]);
            $this->view->assign('view', [
                'record' => [
                    'table' => [
                        'classes' => 'table table-striped table-bordered',
                        'object' => 'record',
                    ],
                ],
            ]);
        }

        return $this->htmlResponse();
    }
}
