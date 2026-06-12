<?php

namespace Dduers\T3GamingRecords\Domain\Model\FormElements;

use Override;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Form\Domain\Model\FormElements\GenericFormElement;

class SingleSelectFromDatabase extends GenericFormElement //AbstractFormElement
{
    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    #[Override]
    public function setProperty(string $key, $value)
    {
        if ($key === 'table') {
            //DebuggerUtility::var_dump($this->getOptions($value), 'table value');
            $this->setProperty('options', $this->getOptions($value));
            return;
        }
        parent::setProperty($key, $value);
    }

    /**
     * @param string $table
     * @return array
     */
    protected function getOptions(string $table): array
    {
        $options = ['' => ''];
        foreach ($this->getData($table) as $record) {
            $options[$record['uid']] = $record['title'];
        }
        return $options;
    }

    /**
     * @param string $table
     * @return array
     */
    protected function getData(string $table): array
    {
        $tablename = 'tx_t3gamingrecords_domain_model_' . $table;
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tablename);
        $queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));

        $postFormFrameworkData = $this->getRequest()->getParsedBody() ?? [];
        $postFormFrameworkData = array_shift($postFormFrameworkData) ?? [];

        $result = [];
        $formName = $this->getRootForm()->getIdentifier();
        switch ($formName) {
            case 'formNewRecord':
                $gameid = (int)(array_shift($postFormFrameworkData)['select-game-id'] ?? 0);

                $whereConditions =
                    $gameid && in_array($table, ['level', 'difficulty'])
                    ? [$queryBuilder->expr()->eq('game_id', $queryBuilder->createNamedParameter($gameid, Connection::PARAM_INT))]
                    : [];

                $orderBy = in_array($table, ['level', 'difficulty']) ? 'sorting' : 'title';

                $result = $queryBuilder
                    ->select('uid', 'title')
                    ->from($tablename)
                    ->where(...$whereConditions)
                    ->orderBy($orderBy, 'ASC')
                    ->executeQuery()
                    ->fetchAllAssociative();
                break;
        }
        return $result;
    }
}
