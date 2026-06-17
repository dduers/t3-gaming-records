<?php

namespace Dduers\T3GamingRecords\Domain\Repository;

use Dduers\T3GamingRecords\Domain\Model\Dto\GameDemand;
use Dduers\T3GamingRecords\Domain\Model\Game;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class GameRepository extends Repository
{
    /**
     * constructor
     */
    public function __construct(
        private readonly PublisherRepository $publisherRepository,
        private readonly PlatformRepository $platformRepository
    ) {
        return parent::__construct();
    }

    /**
     * mainly set default query settings
     * 
     * @return void
     */
    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(true);
        $querySettings->setRespectSysLanguage(true);
        $this->setDefaultQuerySettings($querySettings);
    }


    /**
     * find all time highscores by demand
     * 
     * @param GameDemand $demand
     * @return array
     */
    public function findByDemand(GameDemand $demand): array
    {
        $records = [];

        $storagePids = $demand->getDataPids();
        $uid = $demand->getUid();

        $querySettings = $this->createQuery()->getQuerySettings();

        if ($uid) {
            $querySettings->setRespectSysLanguage(false);
        }
        
        if ($storagePids) {
            $querySettings->setStoragePageIds($storagePids);
        }

        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();
        $query->setOrderings([$demand->getOrderBy() => $demand->getOrderDirection()]);

        if ($uid) {
            $query->matching($query->equals('uid', $uid));
        }

        $records = $query->execute();

        return $this->recordArrayToObject($records);
    }

    /**
     * add additional information to domain model
     * 
     * @param QueryResultInterface $records
     * @return Game[]
     */
    private function recordArrayToObject(QueryResultInterface $records): array
    {
        $result = [];
        foreach ($records as $record) {
            $publisher = $this->publisherRepository->findByUid($record->getPublisherId());
            $record->setPublisherTitle($publisher ? $publisher->getTitle() : '');

            $platform = $this->platformRepository->findByUid($record->getPlatformId());
            $record->setPlatformTitle($platform ? $platform->getTitle() : '');

            $result[] = $record;
        }
        return $result;
    }
}
