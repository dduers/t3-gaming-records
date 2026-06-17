<?php

namespace Dduers\T3GamingRecords\Domain\Model\FormElements;

use Dduers\T3GamingRecords\Domain\Model\Dto\GameDemand;
use Dduers\T3GamingRecords\Domain\Repository\GameRepository;
use Override;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Model\FormElements\GenericFormElement;

class SingleSelectFromDatabase extends GenericFormElement //AbstractFormElement
{
    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    #[Override]
    public function setProperty(string $key, $value): void
    {
        if ($key === 'table') {
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
        $result = [];
        $formName = $this->getRootForm()->getIdentifier();

        // do queries storage page unaware
        switch ($formName) {
            case 'formNewRecord':

                switch ($table) {
                    case 'game':

                        $repository = GeneralUtility::makeInstance(GameRepository::class);
                        $querySettings = $repository->createQuery()->getQuerySettings();
                        $querySettings->setRespectStoragePage(false);
                        $repository->setDefaultQuerySettings($querySettings);

                        $demand = GeneralUtility::makeInstance(GameDemand::class);
                        $demand = $demand->createDemand(['orderBy' => 'title', 'orderDirection' => 'ASC'], $this->request);

                        foreach ($repository->findByDemand($demand) as $record) {
                            $result[] = ['uid' => $record->getUid(), 'title' => $record->getTitle()];
                        }

                        break;

                    case 'level':
                    case 'difficulty':

                        $postFormFrameworkData = $this->getRequest()->getParsedBody() ?? [];
                        $postFormFrameworkData = array_shift($postFormFrameworkData) ?? [];

                        $gameId = (int)(array_shift($postFormFrameworkData)['select-game-id'] ?? 0);
                        $tableName = 'tx_t3gamingrecords_domain_model_' . $table;

                        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tableName);
                        $queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));

                        $whereConditions = [];
                        if ($gameId) {
                            $whereConditions = [$queryBuilder->expr()->eq('game_id', $queryBuilder->createNamedParameter($gameId, Connection::PARAM_INT))];
                        }

                        $result = $queryBuilder
                            ->select('uid', 'title')
                            ->from($tableName)
                            ->where(...$whereConditions)
                            ->orderBy('sorting', 'ASC')
                            ->executeQuery()
                            ->fetchAllAssociative();

                        break;
                }

                break;
        }

        return $result;
    }
}
