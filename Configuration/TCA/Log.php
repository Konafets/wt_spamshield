<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TCA['tx_wtspamshield_log'] =  [
    'ctrl' => $TCA['tx_wtspamshield_log']['ctrl'],
    'interface' =>  [
        'showRecordFieldList' => 'title,form,errormsg,formvalues,pageid,ip,useragent'
    ],
    'feInterface' => $TCA['tx_wtspamshield_log']['feInterface'],
    'columns' =>  [
        'form' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.form',
            'config' =>  [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required',
            ]
        ],
        'title' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.title',
            'config' =>  [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required',
            ]
        ],
        'errormsg' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.errormsg',
            'config' =>  [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required',
            ]
        ],
        'formvalues' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.formvalues',
            'config' =>  [
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
                'wizards' =>  [
                    '_PADDING' => 2,
                    'RTE' => [
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xml:tx_powermail_mails.content_RTE',
                        'icon' => 'wizard_rte2.gif',
                        'script' => 'wizard_rte.php',
                    ],
                ],
            ]
        ],
        'pageid' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.pageid',
            'config' =>  [
                'type' => 'input',
                'size' => '5',
            ]
        ],
        'ip' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.ip',
            'config' =>  [
                'type' => 'input',
                'size' => '30',
            ]
        ],
        'useragent' =>  [
            'exclude' => 1,
            'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.useragent',
            'config' =>  [
                'type' => 'input',
                'size' => '30',
            ]
        ],
    ],
    'types' =>  [
        '0' => ['showitem' => 'form;;;;1-1-1, errormsg, formvalues;;;richtext[], pageid, ip, useragent']
    ],
    'palettes' =>  [
        '1' => ['showitem' => '']
    ]
];
