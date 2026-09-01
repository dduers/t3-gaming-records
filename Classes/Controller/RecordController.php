<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\RecordDemand;
use Dduers\T3GamingRecords\Domain\Repository\RecordRepository;
use Exception;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Localization\Locale;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class RecordController extends BaseController
{
    public function __construct(
        private readonly RecordRepository $recordRepository
    ) {}

    /**
     * action list games
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $demandDto = GeneralUtility::makeInstance(RecordDemand::class);
        $demand = $demandDto->createDemand($this->settings, $this->request);
        $records = $this->recordRepository->findRecordsByDemand($demand);

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

        return $this->htmlResponse();
    }

    /**
     * action show
     * 
     * @return ResponseInterface
     */
    public function detailAction(): ResponseInterface
    {
        $recordId = (int)($this->request->getArgument('recordId') ?? 0);

        $demandDto = GeneralUtility::makeInstance(RecordDemand::class);
        $demand = $demandDto->createDemand($this->settings, $this->request);
        $records = $this->recordRepository->findRecordsByDemand($demand);

        try {
            $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
            $fileReferences = $fileRepository->findByRelation('tx_t3gamingrecords_domain_model_record', 'fal_media', $recordId);
        } catch (Exception $e) {
            $fileReferences = [];
        }

        $this->view->assign('data', [
            'record' => $records,
            'recordpicture' => $fileReferences,
        ]);
        $this->view->assign('view', [
            'record' => [
                'table' => [
                    'classes' => 'table table-striped table-bordered',
                    'object' => 'record',
                ],
            ],
        ]);

        return $this->htmlResponse();
    }

    /**
     * action delete
     * 
     * @return ResponseInterface
     */
    public function deleteAction(): ResponseInterface
    {
        $recordId = (int)($this->request->getQueryParams()['tx_t3gamingrecords_record']['recordId'] ?? 0);
        $record = $this->recordRepository->findByUid($recordId);

        //DebuggerUtility::var_dump($record);

        if ($record) {
            $this->recordRepository->remove($record);
        }

        return $this->htmlResponse();
    }
}
