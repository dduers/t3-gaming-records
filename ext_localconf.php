<?php

use Dduers\T3GamingRecords\Controller\GameController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Dduers\T3GamingRecords\Controller\GameDescriptionController;
use Dduers\T3GamingRecords\Controller\GameHeaderController;
use Dduers\T3GamingRecords\Controller\GamePictureController;
use Dduers\T3GamingRecords\Controller\GameTableController;
use Dduers\T3GamingRecords\Controller\PlayerController;
use Dduers\T3GamingRecords\Controller\PlayerHeaderController;
use Dduers\T3GamingRecords\Controller\PlayerTableController;
use Dduers\T3GamingRecords\Controller\RecordController;
use Dduers\T3GamingRecords\Controller\RecordHeaderController;
use Dduers\T3GamingRecords\Controller\RecordNewController;
use Dduers\T3GamingRecords\Controller\RecordPictureController;
use Dduers\T3GamingRecords\Controller\RecordTableController;
use Dduers\T3GamingRecords\Validation\FormEvalRecordScore;
use Dduers\T3GamingRecords\Validation\FormEvalRecordTime;

// backend formevals
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals'][FormEvalRecordTime::class] = '';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals'][FormEvalRecordScore::class] = '';

/**
 * Complete Page Plugins
 */

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'Game',
    [
        GameController::class => 'list, detail',
    ],
    // non-cacheable actions
    [
        GameController::class => 'detail',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'Player',
    [
        PlayerController::class => 'list, detail',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'Record',
    [
        RecordController::class => 'list, detail',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

/**
 * Record Partial Plugin
 */

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'RecordHeader',
    [
        RecordHeaderController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'RecordTable',
    [
        RecordTableController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'RecordPicture',
    [
        RecordPictureController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'RecordNew',
    [
        RecordNewController::class => 'show, perform',
    ],
    // non-cacheable actions
    [
        RecordNewController::class => 'perform',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

/**
 * Game Partial Plugins
 */

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'GameHeader',
    [
        GameHeaderController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'GameTable',
    [
        GameTableController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'GamePicture',
    [
        GamePictureController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'GameDescription',
    [
        GameDescriptionController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

/**
 * Player Partial Plugins
 */

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'PlayerHeader',
    [
        PlayerHeaderController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    't3_gaming_records',
    'PlayerTable',
    [
        PlayerTableController::class => 'show',
    ],
    // non-cacheable actions
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
