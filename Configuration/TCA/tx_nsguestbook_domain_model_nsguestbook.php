<?php

$temp = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'crdate DESC',
		'versioningWS' => TRUE,
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,city,email,website,message,',
		'iconfile' => 'EXT:ns_guestbook/Resources/Public/Icons/tx_nsguestbook_domain_model_nsguestbook.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, city, email, website, message',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden1, name, city, email, website, message, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_nsguestbook_domain_model_nsguestbook',
				'foreign_table_where' => 'AND tx_nsguestbook_domain_model_nsguestbook.pid=###CURRENT_PID### AND tx_nsguestbook_domain_model_nsguestbook.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'size' => 13,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
				'behaviour' => array(
			  		'allowLanguageSynchronization' => true
			  	),
				  
			),
		),
		'endtime' => array(
			'exclude' => 1,			
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'size' => 13,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
				'behaviour' => array(
			  		'allowLanguageSynchronization' => true
			  	),
			),
		),

		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,email,required'
			),
		),
		'website' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.website',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'message' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:ns_guestbook/Resources/Private/Language/locallang_db.xlf:tx_nsguestbook_domain_model_nsguestbook.message',
			'config' => array(
                     'type' => 'text',
                     'enableRichtext' => true,                     
             ),			
		),		
		
	),
);

if(version_compare(TYPO3_branch, '7.0', '<')){
	$temp['columns']['message']['config']['type'] = 'text'; 
	$temp['columns']['message']['config']['cols'] = '80'; 
	$temp['columns']['message']['config']['rows'] = '3'; 
	$temp['columns']['message']['config']['softref'] = 'typolink_tag,images,email[subst],url'; 
	$temp['columns']['message']['defaultExtras'] = 'richtext[]:rte_transform[mode=tx_examples_transformation-ts_css]'; 
}

return $temp;