<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Nitsan\NsGuestbook\Controller\NsguestbookController;

if (!defined('TYPO3')) {
    die('Access denied.');
}

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
