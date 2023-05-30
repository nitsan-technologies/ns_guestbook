<?php
defined('TYPO3') or die();

$_EXTKEY = 'ns_guestbook';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Form',
    'Guestbook Form'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Message',
    'Guestbook Message'
);

$pluginsPi = [
    'nsguestbook_form' => 'Form.xml',
    'nsguestbook_message'=>'Message.xml'
];

foreach ($pluginsPi as $listType => $pi_flexform) {
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$listType] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($listType,'FILE:EXT:ns_guestbook/Configuration/FlexForms/'.$pi_flexform);
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$listType] = 'recursive,select_key,pages';
}
