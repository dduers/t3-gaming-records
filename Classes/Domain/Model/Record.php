<?php

namespace Dduers\T3GamingRecords\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Record extends AbstractEntity
{
    protected ?string $time = null;
    protected ?int $score = null;
    protected string $description = '';
    protected int $gameId = 0;
    protected int $difficultyId = 0;
    protected int $playerId = 0;
    protected int $levelId = 0;
    protected int $date = 0;

    // non database fields
    public string $levelTitle = '';
    public string $difficultyTitle = '';
    public string $gameTitle = '';
    public string $playerDisplayName = '';

    public function setUid(?int $uid): void
    {
        $this->uid = $uid;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function setDate(int $date): void
    {
        $this->date = $date;
    }

    public function getLevelId(): int
    {
        return $this->levelId;
    }

    public function setLevelId(int $levelId): void
    {
        $this->levelId = $levelId;
    }

    public function getGameId(): int
    {
        return $this->gameId;
    }

    public function setGameId(int $gameId): void
    {
        $this->gameId = $gameId;
    }

    public function getDifficultyId(): int
    {
        return $this->difficultyId;
    }

    public function setDifficultyId(int $difficultyId): void
    {
        $this->difficultyId = $difficultyId;
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    public function setPlayerId(int $playerId): void
    {
        $this->playerId = $playerId;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): void
    {
        $this->time = $time;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): void
    {
        $this->score = $score;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    // non database fields
    public function setLevelTitle(string $levelTitle): void
    {
        $this->levelTitle = $levelTitle;
    }

    public function setDifficultyTitle(string $difficultyTitle): void
    {
        $this->difficultyTitle = $difficultyTitle;
    }

    public function setGameTitle(string $gameTitle): void
    {
        $this->gameTitle = $gameTitle;
    }

    public function setPlayerDisplayName(string $playerDisplayName): void
    {
        $this->playerDisplayName = $playerDisplayName;
    }
}
