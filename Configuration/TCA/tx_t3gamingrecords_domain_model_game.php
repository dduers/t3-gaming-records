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

    /**
     * constrol
     */
    'ctrl' => [

        // title
        'title' => 'Game',

        // label
        'label' => 'title',
        'label_userFunc' => LabelsUserFunc::class . '->gameLabel',

        // settings
        'hideAtCopy' => true,

        // localization
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        //'transOrigDiffSourceField' => 'l10n_diffsource',
        'translationSource' => 'l10n_source',

        // standard fields
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],

        // database settings
        'default_sortby' => 'ORDER BY title ASC',
        'searchFileds' => 'uid,title',

        'security' => [
            // Allow the games table anywhere in the page tree
            'ignorePageTypeRestriction' => false,
        ],

        // assets
        'typeicon_classes' => [
            'default' => 'game-record',
        ],
    ],

    /**
     * columns
     */
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'Localization',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'Original Language',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_t3gamingrecords_domain_model_game',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
                'default' => 0,
            ],
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'Title',
            'l10n_mode' => 'prefixLangTitle',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'required' => true,
                'eval' => 'trim',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'slug' => [
            'label' => 'Path Segment',
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
            'label' => 'Platform',
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
            'label' => 'Description',
            'l10n_mode' => 'prefixLangTitle',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 50,
                'rows' => 3,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'date_release' => [
            'exclude' => 0,
            'label' => 'Release Date',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'size' => 12,
            ],
        ],
        'difficulties' => [
            'exclude' => 0,
            'label' => 'Difficulties',
            'displayCond' => 'FIELD:title:REQ:true',
            'description' => 'Related difficulties or Modes for this game',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_t3gamingrecords_domain_model_difficulty',
                'foreign_field' => 'game_id',
                'foreign_sortby' => 'sorting',
                'appearance' => [
                    'useSortable' => true,
                    'showPossibleLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                ],
            ],
        ],
        'levels' => [
            'exclude' => 0,
            'label' => 'Levels',
            'displayCond' => 'FIELD:title:REQ:true',
            'description' => 'Related levels for this game',
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
                    // 'showPossibleLocalizationRecords' => true,
                    // 'showAllLocalizationLink' => true,
                    // 'showSynchronizationLink' => true,
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
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

    /**
     * palettes
     */
    'palettes' => [
        'basic' => ['showitem' => 'title, slug, --linebreak--, publisher_id, platform_id, --linebreak--, date_release', 'description' => 'General information about the game'],
        'description' => ['showitem' => 'description', 'description' => 'Description of the game'],
        'difficulties' => ['showitem' => 'difficulties', 'description' => 'Difficulties for the game'],
        'levels' => ['showitem' => 'levels', 'description' => 'Levels for the game'],
        'options' => ['showitem' => 'hidden', 'description' => 'Options'],
        'language' => ['showitem' => 'sys_language_uid,l10n_parent,'],
    ],

    /**
     * flex form layouts
     */
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
                    fal_media,
                --div--;Language, 
                    --palette--;Language;language'
        ],
    ],

];
