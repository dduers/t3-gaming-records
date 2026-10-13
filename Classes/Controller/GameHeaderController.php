<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Model\Dto\GameDemand;
use Dduers\T3GamingRecords\Domain\Repository\GameRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GameHeaderController extends BaseController
{
    public function __construct(
        private readonly GameRepository $gameRepository
    ) {}

    /**
     * LIST ACTION
     */
    public function showAction(): ResponseInterface
    {
        $gameId = (int)($this->request->getQueryParams()['tx_t3gamingrecords_game']['gameId'] ?? 0);

        if ($gameId) {
            $demandDto = GeneralUtility::makeInstance(GameDemand::class);
            $demand = $demandDto->createDemand($this->settings, $this->request);
            $record = $this->gameRepository->findByDemand($demand);

            $this->view->assign('data', [
                'game' => $record,
            ]);
        }

        return $this->htmlResponse();
    }
}
