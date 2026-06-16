<?php

namespace Dduers\T3GamingRecords\Domain\Repository;

use Dduers\T3GamingRecords\Domain\Model\Dto\RecordDemand;
use Dduers\T3GamingRecords\Domain\Model\Record;
use Dduers\T3GamingRecords\Utility\AdvancedDateTime;
use Dduers\T3GamingRecords\Utility\AdvancedNumber;
use Dduers\T3GamingRecords\Utility\DatabaseUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class RecordRepository extends Repository
{
    public function __construct(
        private readonly GameRepository $gameRepository,
        private readonly LevelRepository $levelRepository,
        private readonly DifficultyRepository $difficultyRepository,
        private readonly PlayerRepository $playerRepository,
        private readonly ConnectionPool $connectionPool
    ) {
        return parent::__construct();
    }

    /**
     * find all time highscores by demand
     * 
     * @param RecordDemand $demand
     * @return array
     */
    public function findRecordsByDemand(RecordDemand $demand): array
    {
        $records = [];
        $tableName = GeneralUtility::makeInstance(DatabaseUtility::class)->getTableNameFromClass(Record::class);
        $gameId = $demand->getGameId();
        $playerId = $demand->getPlayerId();
        $uid = $demand->getUid();

        $recordMode = $demand->getRecordMode();
        $localeName = $demand->getLocaleName();

        // prevent context unaware output of all records
        if (!$gameId && !$playerId && !$uid) {
            return $this->recordArrayToObject($records, $localeName);
        }

        /**
         * single record entry
         */
        if ($uid) {
            $queryBuilder = $this->connectionPool->getQueryBuilderForTable($tableName);
            $selectFields = $demand->getSelectFields();
            $whereConditions = array_filter([
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)),
            ]);
            $records = $queryBuilder->select(...$selectFields)->from($tableName)->where(...$whereConditions)->executeQuery()->fetchAllAssociative();
            return $this->recordArrayToObject($records, $localeName);
        }

        /**
         * context aware (per player or game) all time hights *speedrun*
         */
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($tableName);
        $selectFields = array_filter([
            $playerId ? 'player_id' : null,
            $gameId ? 'game_id' : null,
            // 'player_id',
            // 'game_id',
            'level_id',
            'difficulty_id'
        ]);
        $groupByFields = $selectFields;
        $selectLiterals = [
            $recordMode === 'speedrun'
                ? $queryBuilder->expr()->min('time', 'best_time')
                : $queryBuilder->expr()->max('score', 'best_score')
        ];
        $subQuery = $queryBuilder
            ->select(...$selectFields)
            ->addSelectLiteral(...$selectLiterals)
            ->from($tableName)
            ->groupBy(...$groupByFields);

        // need to get new query builder, after subquery
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($tableName);
        $joinConditions = array_filter([
            $gameId ? $queryBuilder->expr()->eq('t.game_id', $queryBuilder->quoteIdentifier('s.game_id')) : null,
            $playerId ? $queryBuilder->expr()->eq('t.player_id', $queryBuilder->quoteIdentifier('s.player_id')) : null,
            $queryBuilder->expr()->eq('t.level_id', $queryBuilder->quoteIdentifier('s.level_id')),
            $queryBuilder->expr()->eq('t.difficulty_id', $queryBuilder->quoteIdentifier('s.difficulty_id')),
            $recordMode === 'speedrun'
                ? $queryBuilder->expr()->eq('t.time', $queryBuilder->quoteIdentifier('s.best_time'))
                : $queryBuilder->expr()->eq('t.score', $queryBuilder->quoteIdentifier('s.best_score'))
        ]);
        $whereConditions = array_filter([
            $queryBuilder->expr()->in('t.pid', $queryBuilder->createNamedParameter($demand->getDataPids(), Connection::PARAM_STR)),
            $gameId ? $queryBuilder->expr()->eq('t.game_id', $queryBuilder->createNamedParameter($gameId, Connection::PARAM_INT)) : null,
            $playerId ? $queryBuilder->expr()->eq('t.player_id', $queryBuilder->createNamedParameter($playerId, Connection::PARAM_INT)) : null,
            $uid ? $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)) : null,
            $queryBuilder->expr()->eq('t.level_id', $queryBuilder->quoteIdentifier('s.level_id')),
            $queryBuilder->expr()->eq('t.difficulty_id', $queryBuilder->quoteIdentifier('s.difficulty_id')),
            $recordMode === 'speedrun'
                ? $queryBuilder->expr()->eq('t.time', $queryBuilder->quoteIdentifier('s.best_time'))
                : $queryBuilder->expr()->eq('t.score', $queryBuilder->quoteIdentifier('s.best_score')),
            $recordMode === 'speedrun'
                ? $queryBuilder->expr()->isNotNull('t.time')
                : $queryBuilder->expr()->isNotNull('t.score'),
        ]);

        $records = $queryBuilder
            ->select('t.*')
            ->from($tableName, 't')
            ->getConcreteQueryBuilder()
            ->innerJoin(
                $queryBuilder->quoteIdentifier('t'),
                '(' . $subQuery->getSQL() . ')',
                $queryBuilder->quoteIdentifier('s'),
                $queryBuilder->expr()->and(...$joinConditions),
            )
            ->where(...$whereConditions)
            // TODO::implement
            ->OrderBy('t.game_id', 'ASC')
            ->addOrderBy('t.level_id', 'ASC')
            ->addOrderBy('t.difficulty_id', 'ASC')
            // TODO:: does not really work
            ->addOrderBy(
                $recordMode === 'speedrun' ? 't.time' : 't.score',
                $recordMode === 'speedrun' ? 'ASC' : 'DESC'
            )
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->recordArrayToObject($records, $localeName);
    }

    /**
     * create array of record objects and add
     * additional foreign object information
     * 
     * @param array $records
     * @param string $localeName
     * @return Record[]
     */
    private function recordArrayToObject(array $records, string $localeName = 'en_US'): array
    {
        $result = [];
        foreach ($records as $record) {
            $object = GeneralUtility::makeInstance(Record::class);

            // default properties
            $object->setUid($record['uid']);
            $object->setPlayerId($record['player_id']);
            $object->setGameId($record['game_id']);
            $object->setLevelId($record['level_id']);
            $object->setDifficultyId($record['difficulty_id']);
            $object->setTime(
                (new AdvancedDateTime())->uTimestampToDateTime($record['time'])
            );
            $object->setScore(
                (new AdvancedNumber($localeName))->numberToFormatted($record['score'])
            );
            $object->setDate($record['date']);
            $object->setDescription($record['description'] ?? '');

            // custom properties
            $game = $this->gameRepository->findByUid($record['game_id']);
            $object->setGameTitle($game ? $game->getTitle() : '');
            $level = $this->levelRepository->findByUid($record['level_id']);
            $object->setLevelTitle($level ? $level->getTitle() : '');
            $difficulty = $this->difficultyRepository->findByUid($record['difficulty_id']);
            $object->setDifficultyTitle($difficulty ? $difficulty->getTitle() : '');
            $player = $this->playerRepository->findByUidRaw($record['player_id']);
            $player ? $object->setPlayerDisplayName($player[0]->getUsername() ?? '') : null;

            // add result
            $result[] = $object;
        }
        return $result;
    }
}
