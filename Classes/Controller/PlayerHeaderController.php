<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\PlayerDemand;
use Dduers\T3GamingRecords\Domain\Repository\PlayerRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PlayerHeaderController extends BaseController
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
    ) {}

    /**
     * action list games
     *
     * @return ResponseInterface
     */
    public function showAction(): ResponseInterface
    {
        $playerId = (int)($this->request->getQueryParams()['tx_t3gamingrecords_player']['playerId'] ?? 0);

        if ($playerId) {
            $demandDto = GeneralUtility::makeInstance(PlayerDemand::class);
            $demand = $demandDto->createDemand($this->settings, $this->request);
            $records = $this->playerRepository->findPlayersByDemand($demand);

            $this->view->assign('data', [
                'player' => $records,
            ]);
        }

        return $this->htmlResponse();
    }
}
