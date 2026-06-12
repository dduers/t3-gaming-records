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

use Dduers\T3GamingRecords\UserFuncs\LabelsUserFunc;

return [
    'ctrl' => [
        'title' => 'Publisher',
        'label' => 'title',
        'label_alt' => 'developer',
        'label_userFunc' => LabelsUserFunc::class . '->publisherLabel',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        //'sortby' => 'title',
        'default_sortby' => 'ORDER BY title',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => false,
        ],
        'typeicon_classes' => [
            'default' => 'game-record',
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;General,
                    --palette--;Basic Fields;basic,
                --div--;Description,
                    --palette--;Description;description,
                --div--;Options,
                    --palette--;Options;options
            '
        ],
    ],
    'palettes' => [
        'basic' => ['showitem' => 'title, developer', 'description' => 'These fields are mendatory.'],
        'description' => ['showitem' => 'description', 'description' => 'Extended Information'],
        'options' => ['showitem' => 'hidden, starttime, endtime', 'description' => 'Additional options'],
    ],
    'columns' => [
        'title' => [
            'exclude' => 0,
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'size' => 63,
                'required' => true,
                'eval' => 'trim',
            ],
        ],
        'developer' => [
            'exclude' => 0,
            'label' => 'Developer',
            'config' => [
                'type' => 'input',
                'size' => 127,
                //'required' => true,
                'eval' => 'trim',
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => 'Description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => 50,
                'rows' => 3,
            ],
        ],
    ],
];
