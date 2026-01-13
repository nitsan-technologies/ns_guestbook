<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

defined('TYPO3') or die();

$_EXTKEY = 'ns_guestbook';
$versionNumber =  VersionNumberUtility::convertVersionStringToArray(VersionNumberUtility::getCurrentTypo3Version());

if ($versionNumber['version_main'] <= '12') {
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
        // @extensionScannerIgnoreLine
        ExtensionManagementUtility::addPiFlexFormValue($listType, 'FILE:EXT:ns_guestbook/Configuration/FlexForms/'.$pi_flexform);
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$listType] = 'recursive,select_key';
    }

    $GLOBALS['TCA']['tx_nsguestbook_domain_model_nsguestbook']['ctrl']['security']['ignorePageTypeRestriction'] = true;

} else {
    $ctypeKey = ExtensionUtility::registerPlugin(
        $_EXTKEY,
        'Form',
        'Guestbook Form',
        'ext-ns-guestbook-icon',
        'plugins',
        'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:be_desctiption',
        'FILE:EXT:ns_guestbook/Configuration/FlexForms/Form.xml'
    );

    $ctypeKey = ExtensionUtility::registerPlugin(
        $_EXTKEY,
        'Message',
        'Guestbook Message',
        'ext-ns-guestbook-icon',
        'plugins',
        'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:be_desctiption',
        'FILE:EXT:ns_guestbook/Configuration/FlexForms/Message.xml'
    );

    $pluginsPi = [
        'nsguestbook_form' => 'Form.xml',
        'nsguestbook_message' => 'Message.xml',
    ];

    foreach ($pluginsPi as $ctypeKey => $piFlexform) {
        ExtensionManagementUtility::addToAllTCAtypes(
            'tt_content',
            '--div--;Configuration,pi_flexform,pages',
            $ctypeKey,
            'after:pi_flexform',
        );

        // @extensionScannerIgnoreLine
        ExtensionManagementUtility::addPiFlexFormValue(
            '*',
            'FILE:EXT:ns_guestbook/Configuration/FlexForms/'.$piFlexform,
            $ctypeKey,
        );
    }

    $GLOBALS['TCA']['tx_nsguestbook_domain_model_nsguestbook']['ctrl']['security']['ignorePageTypeRestriction'] = true;
}