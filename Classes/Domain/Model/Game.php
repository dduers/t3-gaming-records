<?php

namespace Dduers\T3GamingRecords\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Game extends AbstractEntity
{
    protected string $title = '';
    protected string $description = '';
    protected string $publisherId = '';
    protected int $platformId = 0;
    protected int $dateRelease = 0;
    protected int $falMedia = 0;

    // custom properties
    public string $platformTitle = '';
    public string $publisherTitle = '';

    public function setUid(?int $uid): void
    {
        $this->uid = $uid;
    }

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

    public function getPublisherId(): string
    {
        return $this->publisherId;
    }

    public function setPublisherId(string $publisherId): void
    {
        $this->publisherId = $publisherId;
    }

    public function getPlatformId(): int
    {
        return $this->platformId;
    }

    public function setPlatformId(int $platformId): void
    {
        $this->platformId = $platformId;
    }

    public function getDateRelease(): int
    {
        return $this->dateRelease;
    }

    public function setDateRelease(int $dateRelease): void
    {
        $this->dateRelease = $dateRelease;
    }

    public function getFalMedia(): int
    {
        return $this->falMedia;
    }

    public function setFalMedia(int $falMedia): void
    {
        $this->falMedia = $falMedia;
    }

    public function getPlatformTitle(): string
    {
        return $this->platformTitle;
    }

    public function setPlatformTitle(string $platformTitle): void
    {
        $this->platformTitle = $platformTitle;
    }

    public function getPublisherTitle(): string
    {
        return $this->publisherTitle;
    }

    public function setPublisherTitle(string $publisherTitle): void
    {
        $this->publisherTitle = $publisherTitle;
    }
}
