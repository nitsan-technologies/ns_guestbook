<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

if (version_compare(TYPO3_branch, '10.0', '>=')) {
    $moduleClass = \Nitsan\NsGuestbook\Controller\NsguestbookController::class;
} else {
    $moduleClass = 'Nsguestbook';
}
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Nitsan.ns_guestbook',
    'Form',
    [
        $moduleClass => 'list, new',
    ],
    // non-cacheable actions
    [
        $moduleClass => 'create',
    ]
);

if (version_compare(TYPO3_branch, '7.0', '>')) {
    if (TYPO3_MODE === 'BE') {
        $icons = [
            'ext-ns-guestbook-icon' => 'ns_guestbook.svg',
        ];
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        foreach ($icons as $identifier => $path) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                ['source' => 'EXT:ns_guestbook/Resources/Public/Icons/' . $path]
            );
        }
    }
}
