<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TCA['tx_wtspamshield_blacklist'] =  [
    'ctrl' => $TCA['tx_wtspamshield_blacklist']['ctrl'],
    'interface' =>  [
        'showRecordFieldList' => 'type, value'
    ],
    'feInterface' => $TCA['tx_wtspamshield_log']['feInterface'],
    'columns' =>  [
        'type' =>  [
            'exclude' => 0,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist.type',
            'config' =>  [
                'type' => 'select',
                'items' =>  [
                    ['LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist.type.0', 'ip'],
                    ['LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist.type.1', 'email'],
                ],
                'size' => 1,
                'maxitems' => 1,
            ]
        ],
        'value' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist.value',
            'config' =>  [
                'type' => 'input',
                'size' => '30',
            ]
        ],
    ],
    'types' =>  [
        '0' => ['showitem' => 'type, value']
    ],
    'palettes' =>  [
        '1' => ['showitem' => '']
    ]
];
