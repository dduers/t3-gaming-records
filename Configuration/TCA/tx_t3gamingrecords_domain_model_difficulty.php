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

return [
    'ctrl' => [
        'title' => 'Difficulty', //'LLL:examples.db:tx_examples_dummy',
        'label' => 'title',
        'label_alt' => 'game_id',
        //'label_alt_force' => true,
        'label_userFunc' => LabelsUserFunc::class . '->difficultyLabel',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        //'type' => 'record_type',
        'default_sortby' => 'ORDER BY sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
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
                    --palette--;General;general,
                --div--;Description,
                    --palette--;Description;description,
                --div--;Access,
                    --palette--;Access;access,
            '
        ],
    ],
    'palettes' => [
        'general' => ['showitem' => 'title, slug', 'description' => 'Difficulty title, e.g. Easy, Medium, Hard'],
        'description' => ['showitem' => 'description', 'description' => 'Information about the difficulty'],
        'access' => ['showitem' => 'hidden;Hidden, --linebreak--, starttime;Start Time, --linebreak--, endtime;End Time', 'description' => 'Control the visibility of this level record'],
    ],
    'columns' => [
        'title' => [
            'exclude' => 0,
            'label' => 'Title', //'LLL:examples.db:tx_examples_dummy.title',
            'config' => [
                'type' => 'input',
                'size' => 63,
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
    ],
];
