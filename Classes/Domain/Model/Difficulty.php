<?php

namespace Dduers\T3GamingRecords\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Difficulty extends AbstractEntity
{
    protected string $title = '';
    protected int $gameId = 0;
    protected string $description = '';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getGameId(): int
    {
        return $this->gameId;
    }

    public function setGameId(int $gameId): void
    {
        $this->gameId = $gameId;
    }
}
