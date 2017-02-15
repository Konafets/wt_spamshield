<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Main Settings');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Extensions/direct_mail_subscription', 'direct_mail_subscription');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Extensions/formhandler', 'formhandler');

    // only add static template for default mailform
    // if new form extension is not loaded
if (!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('form')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Extensions/defaultmailform', 'Default Mailform');
}

$TCA['tx_wtspamshield_log'] =  [
    'ctrl' =>  [
        'title'     => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log',
        'label'     => 'title',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate DESC',
        'delete' => 'deleted',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Log.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtspamshield_log.gif',
    ],
    'feInterface' =>  [
        'fe_admin_fieldList' => 'title, form, errormsg, formvalues, pageid, ip, useragent',
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wtspamshield_blacklist');
$TCA['tx_wtspamshield_blacklist'] =  [
    'ctrl' =>  [
        'title'     => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist',
        'label'     => 'value',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY value ASC',
        'delete' => 'deleted',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Blacklist.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_wtspamshield_blacklist.gif',
    ],
    'feInterface' =>  [
        'fe_admin_fieldList' => 'type, value',
    ]
];
