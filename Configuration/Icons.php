<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
       // Icon identifier
       'ext-ns-guestbook-icon' => [
           // Icon provider class
           'provider' => SvgIconProvider::class,
           // The source SVG for the SvgIconProvider
           'source' => 'EXT:ns_guestbook/Resources/Public/Icons/ns_guestbook.svg',
       ],
       'ext-ns-guestbook-type-default' => [
            // Icon provider class
            'provider' => SvgIconProvider::class,
            // The source SVG for the SvgIconProvider
            'source' => 'EXT:ns_guestbook/Resources/Public/Icons/ns_guestbook.svg',
        ],
    ];
