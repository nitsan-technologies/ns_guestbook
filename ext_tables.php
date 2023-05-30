<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsguestbook_domain_model_nsguestbook', 'EXT:ns_guestbook/Resources/Private/Language/locallang_csh_tx_nsguestbook_domain_model_nsguestbook.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsguestbook_domain_model_nsguestbook');