<?php

namespace Dduers\T3GamingRecords\Domain\Repository;

use Dduers\T3GamingRecords\Domain\Model\Dto\GameDemand;
use Dduers\T3GamingRecords\Domain\Model\Game;
use Dduers\T3GamingRecords\Utility\DatabaseUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

class GameRepository extends Repository
{
    /**
     * constructor
     */
    public function __construct(
        private readonly PublisherRepository $publisherRepository,
        private readonly PlatformRepository $platformRepository,
        private readonly ConnectionPool $connectionPool,
    ) {
        return parent::__construct();
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
        $tableName = GeneralUtility::makeInstance(DatabaseUtility::class)->getTableNameFromClass(Game::class);
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($tableName);
        $gameId = $demand->getUid();
        $selectFields = $demand->getSelectFields();

        // for GameDescription and GameHeaderControllers, dont query with the pids, they are using the game uid only
        $dataPids = $demand->getDataPids();

        $whereConditions = array_filter([
            $dataPids ? $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter($dataPids, Connection::PARAM_STR)) : null,
            $gameId ? $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($gameId, Connection::PARAM_INT)) : null
        ]);

        $records = $queryBuilder
            ->select(...$selectFields)
            ->from($tableName)
            ->where(...$whereConditions)
            ->addOrderBy($demand->getOrderBy(), $demand->getOrderDirection())
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->recordArrayToObject($records);
    }

    /**
     * create array of record objects and add
     * additional foreign object information
     * 
     * @param array $records
     * @return Game[]
     */
    private function recordArrayToObject(array $records): array
    {
        $result = [];
        foreach ($records as $record) {
            $object = GeneralUtility::makeInstance(Game::class);
            // default properties
            $object->setUid($record['uid']);
            $object->setTitle($record['title']);
            $object->setDescription($record['description']);
            $object->setPublisherId($record['publisher_id']);
            $object->setPlatformId($record['platform_id']);
            $object->setDateRelease($record['date_release']);
            $object->setFalMedia($record['fal_media']);
            // custom properties
            $publisher = $this->publisherRepository->findByUid($record['publisher_id']);
            $object->setPublisherTitle($publisher ? $publisher->getTitle() : '');
            $platform = $this->platformRepository->findByUid($record['platform_id']);
            $object->setPlatformTitle($platform ? $platform->getTitle() : '');
            $result[] = $object;
        }
        return $result;
    }
}
