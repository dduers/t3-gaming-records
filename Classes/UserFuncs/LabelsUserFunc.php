<?php

namespace Dduers\T3GamingRecords\UserFuncs;

use Dduers\T3GamingRecords\Domain\Repository\DifficultyRepository;
use Dduers\T3GamingRecords\Domain\Repository\GameRepository;
use Dduers\T3GamingRecords\Domain\Repository\LevelRepository;
use Dduers\T3GamingRecords\Domain\Repository\PlayerRepository;
use Dduers\T3GamingRecords\Utility\AdvancedDateTime;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class LabelsUserFunc
{
    public function __construct()
    {
        //prove that the contructor is called, and guess what - it is
        //DebuggerUtility::var_dump('LabelsUserFunc constructor called', 'LabelsUserFunc');
    }

    public function gameLabel(mixed &$params): void
    {
        $record = $params['row'];
        $params['title'] = $record['title'];
    }

    public function difficultyLabel(mixed &$params): void
    {
        $record = $params['row'];
        $params['title'] = $record['title'];
    }

    public function levelLabel(mixed &$params): void
    {
        $record = $params['row'];
        $params['title'] = $record['title'];
    }

    public function platformLabel(mixed &$params): void
    {
        $record = $params['row'];
        $params['title'] = $record['title'];
    }

    public function publisherLabel(mixed &$params): void
    {
        $publisher = $params['row'];
        $params['title'] = $publisher['title'];
    }

    public function recordLabel(mixed &$params): void
    {
        $record = $params['row'] ?? null;

        $difficultyRepository = GeneralUtility::makeInstance(DifficultyRepository::class);
        $difficultyId = is_int($record['difficulty_id']) ? $record['difficulty_id'] : ($record['difficulty_id'][0] ?? 0);
        $difficultyRecord = $difficultyRepository->findByUid($difficultyId);
        $difficultyTitle = $difficultyRecord ? $difficultyRecord->getTitle() : 'Unknown Difficulty';

        $gameRepository = GeneralUtility::makeInstance(GameRepository::class);
        $gameId = is_int($record['game_id']) ? $record['game_id'] : ($record['game_id'][0] ?? 0);
        $gameRecord = $gameRepository->findByUid($gameId);
        $gameTitle = $gameRecord ? $gameRecord->getTitle() : 'Unknown Game';

        $levelRepository = GeneralUtility::makeInstance(LevelRepository::class);
        $levelId = is_int($record['level_id']) ? $record['level_id'] : ($record['level_id'][0] ?? 0);
        $levelRecord = $levelRepository->findByUid($levelId);
        $levelTitle = $levelRecord ? $levelRecord->getTitle() : 'Unknown Level';

        $playerId = is_int($record['player_id']) ? $record['player_id'] : ($record['player_id'][0] ?? 0);
        $playerRepository = GeneralUtility::makeInstance(PlayerRepository::class);
        $playerRecord = $playerRepository->findByUidRaw($playerId);
        $playerUsername = $playerRecord ? $playerRecord[0]->getUsername() : 'Unknown Player';

        $time = ($record['time'] ?? null) ? (new AdvancedDateTime)->uTimestampToDateTime((int)$record['time']) : null;
        $score = ($record['score'] ?? null) ? number_format($record['score'], 0, '.', '\'') : null;

        $label = sprintf('%s - %s, %s / %s - %s, %s', $gameTitle, $levelTitle, $difficultyTitle, $playerUsername, $time ?? 'No Time', $score ?? 'No Score');
        $params['title'] = $label;
    }
}
