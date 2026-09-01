<?php

namespace Dduers\T3GamingRecords\Controller;

use Dduers\T3GamingRecords\Domain\Repository\GameRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class NewRecordFormController extends ActionController
{
    private readonly GameRepository $gameRepository;
    //private readonly ConnectionPool $connectionPool;

    public function __construct(
        GameRepository $gameRepository
    ) {
        $this->gameRepository = $gameRepository;
        //$this->connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
    }

    public function showAction(): ResponseInterface
    {
        //$games = $this->gameRepository->findAll();
        //$this->view->assign('games', $games);
        return $this->htmlResponse();
    }

    public function performAction(): ResponseInterface
    {
        //DebuggerUtility::var_dump('performAction', 'called');
        return $this->htmlResponse();
    }
}
