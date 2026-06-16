<?php

namespace Dduers\T3GamingRecords\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Demanded repository interface
 * common plugin settings
 */
class DataDemand extends AbstractEntity
{
    protected string $localeName = '';
    protected string $dataPids = '';
    // low level default for queries
    protected array $selectFields = ['*'];
    protected string $orderBy = 'uid';
    protected string $orderDirection = 'asc';

    // why lover why?
    protected string $orderByAllowed = '';
    protected string $action = '';
    protected string $class = '';

    // not available in parent classes, so implemented here
    public function setUid(int $uid)
    {
        $this->uid = $uid;
        return $this;
    }

    public function getLocaleName(): string
    {
        return $this->localeName;
    }

    public function setLocaleName(string $localeName)
    {
        $this->localeName = $localeName;
        return $this;
    }

    public function setSelectFields(string ...$selectFields)
    {
        $this->selectFields = $selectFields;
        return $this;
    }

    public function getSelectFields(): array
    {
        return $this->selectFields;
    }

    public function setDataPids(string $dataPids)
    {
        $this->dataPids = $dataPids;
        return $this;
    }

    public function getDataPids(): string
    {
        return $this->dataPids;
    }

    public function setOrderBy(string $order)
    {
        $this->orderBy = $order;
        return $this;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function setOrderDirection(string $orderDirection)
    {
        $this->orderDirection = $orderDirection;
        return $this;
    }

    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    //////////////////////// why lover why ///////////////////////////////////////////
    public function setOrderByAllowed(string $orderByAllowed)
    {
        $this->orderByAllowed = $orderByAllowed;
        return $this;
    }

    public function getOrderByAllowed(): string
    {
        return $this->orderByAllowed;
    }

    public function setAction(string $action)
    {
        $this->action = $action;
        return $this;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(string $class)
    {
        $this->class = $class;
        return $this;
    }
}
