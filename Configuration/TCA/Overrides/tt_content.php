<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$flexForm = 'FILE:EXT:t3_gaming_records/Configuration/FlexForms/game_page.xml';
$ctypeKey = ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'Game',
    'Games',
    'game-record',
    'Gaming Records (Pages)',
    'Display the games page',
    $flexForm
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Pages,pi_flexform,',
    $ctypeKey,
    'after:subheader',
);

$flexForm = 'FILE:EXT:t3_gaming_records/Configuration/FlexForms/game_table.xml';
$ctypeKey = ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'GameTable',
    'Game Table',
    'game-record',
    'Gaming Records (Partials)',
    'Show list of all games',
    $flexForm
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Pages,pi_flexform,',
    $ctypeKey,
    'after:subheader',
);

ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'GameHeader',
    'Game Header',
    'game-record',
    'Gaming Records (Partials)',
    'Display the game header'
);
ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'GamePicture',
    'Game Picture',
    'game-record',
    'Gaming Records (Partials)',
    'Show a cover picture of a game'
);
ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'GameDescription',
    'Game Description',
    'game-record',
    'Gaming Records (Partials)',
    'Show the description text of a game'
);



$flexForm = 'FILE:EXT:t3_gaming_records/Configuration/FlexForms/player_page.xml';
$ctypeKey = ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'Player',
    'Players',
    'game-record',
    'Gaming Records (Pages)',
    'Display the players page',
    $flexForm
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Pages,pi_flexform,',
    $ctypeKey,
    'after:subheader',
);

$flexForm = 'FILE:EXT:t3_gaming_records/Configuration/FlexForms/player_table.xml';
$ctypeKey = ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'PlayerTable',
    'Player Table',
    'game-record',
    'Gaming Records (Partials)',
    'Show a list of all players',
    $flexForm
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Pages,pi_flexform,',
    $ctypeKey,
    'after:subheader',
);
ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'PlayerHeader',
    'Player Header',
    'game-record',
    'Gaming Records (Partials)',
    'Display the player header'
);



$flexForm = 'FILE:EXT:t3_gaming_records/Configuration/FlexForms/record_page.xml';
$ctypeKey = ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'Record',
    'Records',
    'game-record',
    'Gaming Records (Pages)',
    'Show the highscores and speedrun page',
    $flexForm
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Pages,pi_flexform,',
    $ctypeKey,
    'after:subheader',
);
$flexForm = 'FILE:EXT:t3_gaming_records/Configuration/FlexForms/record_table.xml';
$ctypeKey = ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'RecordTable',
    'Record Table',
    'game-record',
    'Gaming Records (Partials)',
    'Show all highscores and speedrun information',
    $flexForm
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Pages,pi_flexform,',
    $ctypeKey,
    'after:subheader',
);
ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'RecordHeader',
    'Record Header',
    'game-record',
    'Gaming Records (Partials)',
    'Display the record header'
);
ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'RecordPicture',
    'Record Picture',
    'game-record',
    'Gaming Records (Partials)',
    'Show picture gallery of a record'
);

$flexForm = 'FILE:EXT:t3_gaming_records/Configuration/FlexForms/form_newrecord.xml';
$ctypeKey = ExtensionUtility::registerPlugin(
    't3_gaming_records',
    'FormNewRecord',
    'New Record Form',
    'game-record',
    'Gaming Records (Forms)',
    'Form to submit a new record',
    $flexForm
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Pages,pi_flexform,',
    $ctypeKey,
    'after:subheader',
);