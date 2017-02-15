<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtspamshield_log'] = array (
	'ctrl' => $TCA['tx_wtspamshield_log']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'title,form,errormsg,formvalues,pageid,ip,useragent'
	),
	'feInterface' => $TCA['tx_wtspamshield_log']['feInterface'],
	'columns' => array (
		'form' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.form',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'title' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.title',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'errormsg' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.errormsg',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'formvalues' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.formvalues',
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array (
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xml:tx_powermail_mails.content_RTE',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				),
			)
		),
		'pageid' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.pageid',
			'config' => array (
				'type' => 'input',
				'size' => '5',
			)
		),
		'ip' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.ip',
			'config' => array (
				'type' => 'input',
				'size' => '30',
			)
		),
		'useragent' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_log.useragent',
			'config' => array (
				'type' => 'input',
				'size' => '30',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'form;;;;1-1-1, errormsg, formvalues;;;richtext[], pageid, ip, useragent')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);

?>