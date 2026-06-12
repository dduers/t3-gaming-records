<?php

namespace Dduers\T3GamingRecords\Domain\Model\Dto;

use Dduers\T3GamingRecords\Domain\Model\DataDemand;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;

class RecordDemand extends DataDemand
{
    protected int $gameId = 0;
    protected int $playerId = 0;
    protected string $recordMode = '';

    public function getRecordMode(): string
    {
        return $this->recordMode;
    }

    public function setRecordMode(string $recordMode): RecordDemand
    {
        $this->recordMode = $recordMode;
        return $this;
    }

    public function setGameId(int $gameId): RecordDemand
    {
        $this->gameId = $gameId;
        return $this;
    }

    public function getGameId(): int
    {
        return $this->gameId;
    }

    public function setPlayerId(int $playerId): RecordDemand
    {
        $this->playerId = $playerId;
        return $this;
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    /**
     * create a demand dto from request and settings data
     * 
     * @param array $settings
     * @param RequestInterface $request
     * @return RecordDemand
     */
    public function createDemand(array $settings, RequestInterface $request): RecordDemand
    {
        $demand = GeneralUtility::makeInstance(RecordDemand::class);
        $pageRepository = GeneralUtility::makeInstance(PageRepository::class);

        $gameId = (int)($request->getQueryParams()['tx_t3gamingrecords_game']['gameId'] ?? 0);
        $playerId = (int)($request->getQueryParams()['tx_t3gamingrecords_player']['playerId'] ?? 0);
        $uid = (int)($request->getQueryParams()['tx_t3gamingrecords_record']['recordId'] ?? 0);

        // TODO::move to flex form
        $demand->setRecordMode($settings['recordMode']);

        $demand->setGameId($gameId);
        $demand->setPlayerId($playerId);
        $demand->setUid($uid);
        $demand->setSelectFields('*');
        $demand->setOrderBy($settings['orderBy'] ?? '');
        $demand->setOrderDirection($settings['orderDirection'] ?? '');
        $demand->setDataPids(implode(
            ',',
            $pageRepository->getPageIdsRecursive(
                GeneralUtility::intExplode(',', (string)($settings['recordDataPids'] ?? '')),
                (int)($settings['recursive'] ?? 0)
            )
        ));

        //TODO::why lover, why?
        $demand->setOrderByAllowed($settings['orderByAllowed'] ?? '');
        $demand->setAction($request->getControllerActionName());
        $demand->setClass($request->getControllerName());

        return $demand;
    }
}
