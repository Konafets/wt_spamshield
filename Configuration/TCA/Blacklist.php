<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_wtspamshield_blacklist'] = array (
	'ctrl' => $TCA['tx_wtspamshield_blacklist']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'type, value'
	),
	'feInterface' => $TCA['tx_wtspamshield_log']['feInterface'],
	'columns' => array (
		'type' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist.type',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist.type.0', 'ip'),
					array('LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist.type.1', 'email'),
				),
				'size' => 1,
				'maxitems' => 1,
			)
		),
		'value' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:wt_spamshield/Resources/Private/Language/locallang_db.xml:tx_wtspamshield_blacklist.value',
			'config' => array (
				'type' => 'input',
				'size' => '30',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'type, value')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);

?>