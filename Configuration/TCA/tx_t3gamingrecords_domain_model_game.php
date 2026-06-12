<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Dduers\T3GamingRecords\Backend\FormEngine\SlugPrefix;
use Dduers\T3GamingRecords\UserFuncs\LabelsUserFunc;
use TYPO3\CMS\Core\Resource\FileType;

return [
    'ctrl' => [
        'title' => 'Game', //'LLL:examples.db:tx_examples_dummy',
        'label' => 'title',
        'label_alt' => 'publisher_id, platform_id',
        //'label_alt_force' => true,
        'label_userFunc' => LabelsUserFunc::class . '->gameLabel',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY title ASC',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'security' => [
            // Allow the games table anywhere in the page tree
            'ignorePageTypeRestriction' => false,
        ],
        'typeicon_classes' => [
            'default' => 'game-record', //'tx_examples-dummy',
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    --palette--;Basic Fields;basic, 
                --div--;Difficulties & Levels, 
                    --palette--;Difficulties;difficulties,
                    --palette--;Levels;levels,
                --div--;Description,
                    --palette--;Description;description,
                --div--;Options, 
                    --palette--;Options;options,
                --div--;Picture,
                    fal_media'
        ],
    ],
    'palettes' => [
        'basic' => ['showitem' => 'title, slug, --linebreak--, publisher_id, platform_id, --linebreak--, date_release', 'description' => 'General information about the game'],
        'description' => ['showitem' => 'description', 'description' => 'Description of the game'],
        'difficulties' => ['showitem' => 'difficulties', 'description' => 'Difficulties for the game'],
        'levels' => ['showitem' => 'levels', 'description' => 'Levels for the game'],
        'options' => ['showitem' => 'hidden', 'description' => 'Options'],
    ],
    'columns' => [
        'title' => [
            'exclude' => 0,
            'label' => 'Title', //'LLL:examples.db:tx_examples_dummy.title',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'required' => true,
                'eval' => 'trim',
            ],
        ],
        'slug' => [
            'label' => 'Path Segment',
            //'displayCond' => 'VERSION:IS:false',
            'config' => [
                'type' => 'slug',
                'size' => 255,
                'generatorOptions' => [
                    'fields' => ['title'],
                    'replacements' => [
                        '/' => '-',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'unique',
                'default' => '',
                'appearance' => [
                    'prefix' => SlugPrefix::class . '->getPrefix',
                ],
            ],
        ],
        'publisher_id' => [
            'exclude' => 0,
            'label' => 'Publisher',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'displayCond' => 'FIELD:game_id:!=:0',
                'foreign_table' => 'tx_t3gamingrecords_domain_model_publisher',
                'required' => true,
                //'eval' => 'trim',
            ],
        ],
        'platform_id' => [
            'exclude' => 0,
            'label' => 'Platform', //'LLL:examples.db:tx_examples_dummy.title',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'displayCond' => 'FIELD:game_id:!=:0',
                'foreign_table' => 'tx_t3gamingrecords_domain_model_platform',
                'required' => true,
                //'default' => 0,
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => 'Description', //LLL:examples.db:tx_examples_dummy.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 50,
                'rows' => 3,
            ],
        ],
        'date_release' => [
            'exclude' => 0,
            'label' => 'Release Date', //'LLL:examples.db:tx_examples_dummy.some_date',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'size' => 12,
            ],
        ],
        'difficulties' => [
            'exclude' => 0,
            'label' => 'Difficulties', //LLL:examples.db:tx_examples_dummy.difficulties',
            'displayCond' => 'FIELD:title:REQ:true',
            'description' => 'Related difficulties or Modes for this game', //LLL:examples.db:tx_examples_dummy.difficulties.description',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_t3gamingrecords_domain_model_difficulty',
                'foreign_field' => 'game_id',
                'foreign_sortby' => 'sorting',
                //'foreign_table_field' => 'parenttable',
                'appearance' => [
                    'showSynchronizationLink' => true,
                    'useSortable' => true,
                    //'showRemovedLocalizationRecords' => true,
                    //'showHiddenLocalizationRecords' => true,
                    //'showAllLocalizationLink' => true,
                    //'showPossibleLocalizationRecords' => true,
                ],

            ],
        ],
        'levels' => [
            'exclude' => 0,
            'label' => 'Levels', //LLL:examples.db:tx_examples_dummy.levels',
            'displayCond' => 'FIELD:title:REQ:true',
            'description' => 'Related levels for this game', //LLL:examples.db:tx_examples_dummy.levels.description',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_t3gamingrecords_domain_model_level',
                'foreign_field' => 'game_id',
                'foreign_sortby' => 'sorting',
                'appearance' => [
                    'showSynchronizationLink' => true,
                    'useSortable' => true,
                ],
            ],
        ],
        'fal_media' => [
            'exclude' => true,
            'label' => 'Picture',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'appearance' => [
                    'createNewRelationLinkTitle' => 'Relation Link',
                    'fileUploadAllowed' => false,
                    'fileByUrlAllowed' => false,
                ],
                'overrideChildTca' => [
                    'types' => [
                        (FileType::IMAGE->value) => [
                            'showitem' => '
                                --palette--;Picture Palette,
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                    ],
                ],
                'allowed' => 'common-media-types',
            ],
        ],
    ],
];
