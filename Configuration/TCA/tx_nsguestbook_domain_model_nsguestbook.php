<?php

$label = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';

$temp = [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'dividers2tabs' => true,
        'sortby' => 'crdate DESC',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,city,email,website,message,terms,',
        'iconfile' => 'EXT:ns_guestbook/Resources/Public/Icons/tx_nsguestbook_domain_model_nsguestbook.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_diffsource, hidden1, name, city, email, website, message, terms,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden, starttime, endtime'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
        'timeRestriction' => ['showitem' => 'starttime, endtime'],
    ],
    'columns' => [

        'sys_language_uid' => [
            'exclude' => 1,
            'label' => $label.'LGL.language',
            'config' => [
                'type' => 'language',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
            ],
        ],

        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'tstamp' => [
            'exclude' => true,
            'label' => 'tstamp',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],

        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],

        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],

        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ],
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
        ],

        'name' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'city' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.email',
            'config' => [
                'type' => 'email',
                'size' => 30,
                'eval' => 'trim',
                'required' => true

            ],
        ],
        'website' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.website',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'message' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.message',
            'config' => [
                     'type' => 'text',
                     'enableRichtext' => true,
             ],
        ],
        'terms' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.terms',
            'config' => [
                'type' => 'check',
                'readOnly' => 1,
            ],
        ],
    ],
];


return $temp;
