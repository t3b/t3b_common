<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Register pre-render hook for pagerenderer
/** @var $_EXTKEY string */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . "Classes/Hook/PreRender.php:T3b\\T3bCommon\\Hook\\PreRender->preRender";