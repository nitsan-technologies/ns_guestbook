<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$_EXTKEY = 'ns_guestbook';

ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Form',
    'Guestbook Form',
    'ext-ns-guestbook-icon',
    'plugins'
);

ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Message',
    'Guestbook Message',
    'ext-ns-guestbook-icon',
    'plugins'
);

$pluginsPi = [
    'nsguestbook_form' => 'Form.xml',
    'nsguestbook_message' => 'Message.xml'
];

foreach ($pluginsPi as $listType => $pi_flexform) {
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$listType] = 'pi_flexform';

    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--div--;Configuration,pi_flexform,pages',
        $listType,
        'after:subheader',
    );

    // @extensionScannerIgnoreLine
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:ns_guestbook/Configuration/FlexForms/'.$pi_flexform,
        $listType,
    );
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$listType] = 'recursive,select_key';
}

$GLOBALS['TCA']['tx_nsguestbook_domain_model_nsguestbook']['ctrl']['security']['ignorePageTypeRestriction'] = true;
