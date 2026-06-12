<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\GameDemand;
use Dduers\T3GamingRecords\Domain\Model\Dto\RecordDemand;
use Dduers\T3GamingRecords\Domain\Repository\GameRepository;
use Dduers\T3GamingRecords\Domain\Repository\RecordRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class GameController extends BaseController
{
    public function __construct(
        private readonly GameRepository $gameRepository,
        private readonly RecordRepository $recordRepository,
    ) {}

    public function listAction(): ResponseInterface
    {
        $demandDto = GeneralUtility::makeInstance(GameDemand::class);
        $demand = $demandDto->createDemand($this->settings, $this->request);
        $records = $this->gameRepository->findByDemand($demand);

        $this->view->assign('data', [
            'game' => $records,
        ]);
        $this->view->assign('view', [
            'game' => [
                'table' => [
                    'classes' => 'table table-striped table-bordered',
                    'object' => 'game',
                ]
            ],
        ]);

        return $this->htmlResponse();
    }

    public function detailAction(): ResponseInterface
    {
        $demandDto = GeneralUtility::makeInstance(GameDemand::class);
        $demand = $demandDto->createDemand($this->settings, $this->request);
        $records = $this->gameRepository->findByDemand($demand);

        $gameId = $this->request->getQueryParams()['tx_t3gamingrecords_game']['gameId'] ?? 0;
        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
        $fileReferences = $fileRepository->findByRelation('tx_t3gamingrecords_domain_model_game', 'fal_media', $gameId);

        $viewData = [
            'game' => $records,
            'gameheader' => [$records[0]],
            'gamepicture' => $fileReferences,
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
            'game' => [
                'table' => [
                    'classes' => 'table table-striped table-bordered',
                    'object' => 'game',
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
