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
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'ext-ns-guestbook-icon',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ns_guestbook/Resources/Public/Icons/ns_guestbook.svg']
);
