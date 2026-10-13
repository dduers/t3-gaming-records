<?php

namespace Dduers\T3GamingRecords\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Publisher extends AbstractEntity
{
    protected string $title = '';
    protected string $developer = '';
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

    public function getDeveloper(): string
    {
        return $this->developer;
    }

    public function setDeveloper(string $developer): void
    {
        $this->developer = $developer;
    }
}
