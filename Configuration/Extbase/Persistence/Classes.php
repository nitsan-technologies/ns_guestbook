<?php

declare(strict_types=1);

use Nitsan\NsGuestbook\Domain\Model\Nsguestbook;

return [
    Nsguestbook::class => [
        'tableName' => 'tx_nsguestbook_domain_model_nsguestbook',
        'properties' => [
            'tstamp' => [
                'fieldName' => 'tstamp'
            ],
        ],
    ],
];
