<?php

namespace Dduers\T3GamingRecords\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;

final class DatabaseUtility
{
    /**
     * get the table name from model class name
     * 
     * @param string $className
     * @return string
     */
    public function getTableNameFromClass(string $className): string
    {
        $dataMapper = GeneralUtility::makeInstance(DataMapper::class);
        return $dataMapper->getDataMap($className)->getTableName();
    }
}
