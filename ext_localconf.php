<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ns_guestbook',
    'Form',
    [
        \Nitsan\NsGuestbook\Controller\NsguestbookController::class => 'new,create',
    ],
    // non-cacheable actions
    [
        \Nitsan\NsGuestbook\Controller\NsguestbookController::class => 'create',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ns_guestbook',
    'Message',
    [
        \Nitsan\NsGuestbook\Controller\NsguestbookController::class => 'list',
    ],
    // non-cacheable actions
    [
        \Nitsan\NsGuestbook\Controller\NsguestbookController::class => 'list',
    ]
);
