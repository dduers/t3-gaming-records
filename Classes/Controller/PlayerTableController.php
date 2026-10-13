<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\PlayerDemand;
use Dduers\T3GamingRecords\Domain\Repository\PlayerRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PlayerTableController extends BaseController
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
    ) {}

    public function showAction(): ResponseInterface
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
}
