<?php

namespace Dduers\T3GamingRecords\Domain\Model\Dto;

use Dduers\T3GamingRecords\Domain\Model\DataDemand;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;

class PlayerDemand extends DataDemand
{
    /**
     * Create the demand object which define which records will get shown
     * 
     * @param array $settings
     * @param RequestInterface $request
     * @return PlayerDemand
     */
    public function createDemand(array $settings, RequestInterface $request): PlayerDemand
    {
        $demand = GeneralUtility::makeInstance(PlayerDemand::class);
        $pageRepository = GeneralUtility::makeInstance(PageRepository::class);

        // for backend user functionality, ->request not accessible
        if ($settings['uid'] ?? null) {
            $playerId = $settings['uid'];
        } else {
            $playerId = (int)($request->getQueryParams()['tx_t3gamingrecords_player']['playerId'] ?? 0);
            $demand->setAction($request->getControllerActionName());
            $demand->setClass($request->getControllerName());
        }

        if ($settings['orderBy'] ?? '') {
            $demand->setOrderBy($settings['orderBy']);
        }

        if ($settings['orderDirection'] ?? '') {
            $demand->setOrderDirection($settings['orderDirection']);
        }

        $demand->setOrderByAllowed((string)($this->settings['orderByAllowed'] ?? ''));
        $demand->setSelectFields('username', 'name', 'crdate', 'uid', 'first_name', 'last_name', 'email', 'www');
        $demand->setUid($playerId);
        $demand->setDataPids(implode(
            ',',
            $pageRepository->getPageIdsRecursive(
                GeneralUtility::intExplode(
                    ',',
                    (string)($settings['playerDataPids'] ?? '')
                ),
                (int)($settings['recursive'] ?? 0)
            )
        ));

        return $demand;
    }
}
