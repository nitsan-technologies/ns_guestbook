<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Nitsan\NsGuestbook\Controller\NsguestbookController;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

if (!defined('TYPO3')) {
    die('Access denied.');
}

$versionNumber =  VersionNumberUtility::convertVersionStringToArray(VersionNumberUtility::getCurrentTypo3Version());

if ($versionNumber['version_main'] <= '12') {
    // @extensionScannerIgnoreLine
    ExtensionUtility::configurePlugin(
        'ns_guestbook',
        'Form',
        [
            NsguestbookController::class => 'new,create',
        ],
        // non-cacheable actions
        [
            NsguestbookController::class => 'create',
        ]
    );

    // @extensionScannerIgnoreLine
    ExtensionUtility::configurePlugin(
        'ns_guestbook',
        'Message',
        [
            NsguestbookController::class => 'list',
        ],
        // non-cacheable actions
        [
            NsguestbookController::class => 'list',
        ]
    );
} else {
    ExtensionUtility::configurePlugin(
        'ns_guestbook',
        'Form',
        [
            NsguestbookController::class => 'new,create',
        ],
        // non-cacheable actions
        [
            NsguestbookController::class => 'create',
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
    );

    ExtensionUtility::configurePlugin(
        'ns_guestbook',
        'Message',
        [
            NsguestbookController::class => 'list',
        ],
        // non-cacheable actions
        [
            NsguestbookController::class => 'list',
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
    );
}