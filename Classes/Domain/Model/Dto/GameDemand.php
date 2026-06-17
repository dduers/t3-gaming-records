<?php

namespace Dduers\T3GamingRecords\Domain\Model\Dto;

use Dduers\T3GamingRecords\Domain\Model\DataDemand;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;

class GameDemand extends DataDemand
{
    /**
     * Create the demand object which define which records will get shown
     * 
     * @param array $settings
     * @param RequestInterface $request
     * @return GameDemand
     */
    public function createDemand(array $settings, RequestInterface $request): GameDemand
    {
        $gameId = (int)($request->getQueryParams()['tx_t3gamingrecords_game']['gameId'] ?? 0);
        $demand = GeneralUtility::makeInstance(GameDemand::class);
        $pageRepository = GeneralUtility::makeInstance(PageRepository::class);

        $demand->setUid($gameId);
        $demand->setOrderBy($settings['orderBy'] ?? $demand->getOrderBy());
        $demand->setOrderDirection($settings['orderDirection'] ?? $demand->getOrderDirection());
        $demand->setDataPids(
            $pageRepository->getPageIdsRecursive(
                GeneralUtility::intExplode(',', (string)($settings['gameDataPids'] ?? '')),
                (int)($settings['recursive'] ?? 0)
            )
        );

        // TODO::why lover, why?
        $demand->setOrderByAllowed((string)($this->settings['orderByAllowed'] ?? ''));
        $demand->setAction($request->getControllerActionName());
        $demand->setClass($request->getControllerName());

        return $demand;
    }
}
