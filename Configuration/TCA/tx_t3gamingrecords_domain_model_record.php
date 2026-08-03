<?php

use Dduers\T3GamingRecords\UserFuncs\LabelsUserFunc;
use Dduers\T3GamingRecords\Validation\FormEvalRecordScore;
use Dduers\T3GamingRecords\Validation\FormEvalRecordTime;
use TYPO3\CMS\Core\Resource\FileType;

return [
    'ctrl' => [

        // title
        'title' => 'Record',

        // label
        'label' => 'game_id',
        // make fields available for user func
        'label_alt' => 'time,score,difficulty_id,player_id,level_id',
        'label_userFunc' => LabelsUserFunc::class . '->recordLabel',

        // settings
        'hideAtCopy' => true,

        // standard fields
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY crdate',
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

        // assets
        'typeicon_classes' => [
            'default' => 'game-record',
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;Speedrun / Highscore, 
                    --palette--;Record or speedrun information;basic,
                --div--;Description, 
                    --palette--;Additional information;description,
                --div--;Picture,
                    fal_media,
                --div--;Options, 
                    --palette--;Options;options'
        ],
    ],
    'palettes' => [
        'basic' => ['showitem' => 'date, --linebreak--, player_id, game_id, --linebreak--, difficulty_id, level_id, --linebreak--, time, score', 'description' => 'This is where the core information about the record is stored, such as the player, game, difficulty, and the time or score achieved.'],
        'description' => ['showitem' => 'description', 'description' => 'This can be used for additional information about the record, such as the conditions under which it was achieved, or any other relevant details.'],
        'options' => ['showitem' => 'hidden, starttime, endtime', 'description' => 'Optional settings for the record, such as whether it is hidden or not.'],
    ],
    'columns' => [
        'date' => [
            'exclude' => 0,
            'label' => 'Date',
            'description' => 'The date when the record was achieved.',
            'config' => [
                'type' => 'datetime',
                'format' => 'date',
                'required' => true,
            ],
        ],
        'player_id' => [
            'exclude' => 0,
            'label' => 'Player',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'required' => true,
                'foreign_table' => 'fe_users',
            ],
        ],
        'game_id' => [
            'exclude' => 0,
            'label' => 'Game',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'required' => true,
                'displayCond' => 'FIELD:player_id:!=:0',
                'foreign_table' => 'tx_t3gamingrecords_domain_model_game',
                'foreign_table_where' => 'AND {#tx_t3gamingrecords_domain_model_game}.{#sys_language_uid} = 0',
            ],
            'onChange' => 'reload',
        ],
        'difficulty_id' => [
            'exclude' => 0,
            'label' => 'Difficulty',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'displayCond' => 'FIELD:game_id:!=:0',
                'foreign_table' => 'tx_t3gamingrecords_domain_model_difficulty',
                // 'foreign_table_where' => 'AND {#tx_t3gamingrecords_domain_model_difficulty}.{#game_id} = ###REC_FIELD_game_id### AND {#tx_t3gamingrecords_domain_model_difficulty}.{#sys_language_uid} = 0',
                'foreign_table_where' => 'AND {#tx_t3gamingrecords_domain_model_difficulty}.{#game_id} = ###REC_FIELD_game_id###',
                'required' => true,
            ],
        ],
        'level_id' => [
            'exclude' => 0,
            'label' => 'Level',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'displayCond' => 'FIELD:game_id:!=:null',
                'foreign_table' => 'tx_t3gamingrecords_domain_model_level',
                'foreign_table_where' => 'AND {#tx_t3gamingrecords_domain_model_level}.{#game_id} = ###REC_FIELD_game_id###',
                'required' => true,
                //'default' => 0,
            ],
        ],
        'time' => [
            'exclude' => 0,
            'label' => 'Time (hh:mm:ss.vvv)',
            'config' => [
                'type' => 'input',
                'nullable' => true,
                'default' => null,
                'eval' => FormEvalRecordTime::class
            ],
        ],
        'score' => [
            'exclude' => 0,
            'label' => 'Score', 
            'config' => [
                'type' => 'input',
                'nullable' => true,
                'default' => null,
                'eval' => FormEvalRecordScore::class
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
        'fal_media' => [
            'exclude' => true,
            'label' => 'Picture',
            'config' => [
                'type' => 'file',
                'maxitems' => 5,
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
