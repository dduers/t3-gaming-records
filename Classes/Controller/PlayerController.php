<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\PlayerDemand;
use Dduers\T3GamingRecords\Domain\Model\Dto\RecordDemand;
use Dduers\T3GamingRecords\Domain\Repository\PlayerRepository;
use Dduers\T3GamingRecords\Domain\Repository\RecordRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PlayerController extends BaseController
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly RecordRepository $recordRepository,
    ) {}

    public function listAction(): ResponseInterface
    {
        $demandDto = GeneralUtility::makeInstance(PlayerDemand::class);
        $demand = $demandDto->createDemand($this->settings, $this->request);
        $records = $this->playerRepository->findPlayersByDemand($demand);

        $this->view->assign('data', [
            'player' => $records,
        ]);
        $this->view->assign('view', [
            'player' => [
                'table' => [
                    'classes' => 'table table-striped table-bordered',
                    'object' => 'player',
                ]
            ],
        ]);

        return $this->htmlResponse();
    }

    public function detailAction(): ResponseInterface
    {
        $demandDto = GeneralUtility::makeInstance(PlayerDemand::class);
        $demand = $demandDto->createDemand($this->settings, $this->request);
        $records = $this->playerRepository->findPlayersByDemand($demand);

        $playerId = $this->request->getQueryParams()['tx_t3gamingrecords_player']['playerId'] ?? 0;
        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
        $fileReferences = $fileRepository->findByRelation('tx_t3gamingrecords_domain_model_player', 'fal_media', $playerId);

        $viewData = [
            'player' => $records,
            'playerheader' => [$records[0]],
            'playerpicture' => $fileReferences,
        ];

        $demandDto = GeneralUtility::makeInstance(RecordDemand::class);
        
        if ($this->settings['enableRecordSpeedruns']) {
            $this->settings['recordMode'] = 'speedrun';
            $demand = $demandDto->createDemand($this->settings, $this->request);
            $records = $this->recordRepository->findRecordsByDemand($demand);
            $this->view->assign('settings_speedrun', $this->settings);
            $viewData['recordSpeedrun'] = $records;
        }

        if ($this->settings['enableRecordHighscores']) {
            $this->settings['recordMode'] = 'highscore';
            $demand = $demandDto->createDemand($this->settings, $this->request);
            $records = $this->recordRepository->findRecordsByDemand($demand);
            $this->view->assign('settings_highscore', $this->settings);
            $viewData['recordHighscore'] = $records;
        }

        $this->view->assign('data', $viewData);
        $this->view->assign('view', [
            'player' => [
                'table' => [
                    'classes' => 'table table-striped table-bordered',
                    'object' => 'player',
                ]
            ],
            'record' => [
                'table' => [
                    'classes' => 'table table-striped table-bordered',
                    'object' => 'record',
                ],
            ],
        ]);

        return $this->htmlResponse();
    }
}
