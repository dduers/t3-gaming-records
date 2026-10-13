<?php

namespace Dduers\T3GamingRecords\Domain\Repository;

use Dduers\T3GamingRecords\Domain\Model\Dto\PlayerDemand;
use Dduers\T3GamingRecords\Domain\Model\Player;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PlayerRepository extends Repository
{
    /**
     * constructor
     */
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {
        return parent::__construct();
    }

    /**
     * find player records by demand
     * 
     * @param PlayerDemand $demand
     * @return Player[]
     */
    public function findPlayersByDemand(PlayerDemand $demand): array
    {
        $records = [];
        $tableName = 'fe_users';

        $uid = $demand->getUid();
        $dataPids = $demand->getDataPids();

        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($tableName);
        $selectFields = $demand->getSelectFields();
        $whereConditions = array_filter([
            $dataPids ? $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter(implode(',', $dataPids), Connection::PARAM_STR)) : null,
            $uid ? $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)) : null,
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
     * @return Player[]
     */
    private function recordArrayToObject(array $records): array
    {
        $result = [];
        foreach ($records as $record) {
            $object = GeneralUtility::makeInstance(Player::class);
            $object->setUsername($record['username']);
            $object->setName($record['name']);
            $object->setCrdate($record['crdate']);
            $object->setUid($record['uid']);
            $object->setFirstName($record['first_name']);
            $object->setLastName($record['last_name']);
            $object->setEmail($record['email']);
            $object->setWww($record['www']);
            $result[] = $object;
        }
        return $result;
    }

    /**
     * find frontend user by uid
     * @param int $uid
     * @return ?array
     */
    public function findByUidRaw($uid): ?array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('fe_users');

        $frontendUsers = $queryBuilder
            ->select('username', 'name', 'crdate', 'uid', 'first_name', 'last_name', 'email', 'www')
            ->from('fe_users')
            ->where(
                $queryBuilder->expr()->eq('disable', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)),
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)),
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)),
            )
            ->executeQuery()
            ->fetchAllAssociative();

        $players = $this->recordArrayToObject($frontendUsers);
        if (count($players) === 0) {
            return null;
        }

        return $players;
    }
}
