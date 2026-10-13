<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\GameDemand;
use Dduers\T3GamingRecords\Domain\Repository\GameRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GameTableController extends BaseController
{
    public function __construct(
        private readonly GameRepository $gameRepository
    ) {}

    /**
     * LIST ACTION
     */
    public function showAction(): ResponseInterface
    {
        $demandDto = GeneralUtility::makeInstance(GameDemand::class);
        $demand = $demandDto->createDemand($this->settings, $this->request);
        $records = $this->gameRepository->findByDemand($demand);

        $this->view->assign('data', [
            'game' => $records
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
}
