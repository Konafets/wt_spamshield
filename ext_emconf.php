<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "wt_spamshield".
 *
 * Auto generated 15-02-2017 21:33
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Spamshield',
	'description' => 'Spam shield without captcha to avoid spam in powermail, ve_guestbook, comments, t3_blog, direct_mail_subscription and standard TYPO3 mailforms. Session check, Link check, Time check, Akismet check, Name check, Honeypot check (see manual for details)',
	'category' => 'services',
	'version' => '1.3.1',
	'state' => 'stable',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearcacheonload' => false,
	'author' => 'Bjoern Jacob, Ralf Zimmermann, Alex Kellner',
	'author_email' => 'bj@tritum.de, rz@tritum.de, alexander.kellner@in2code.de',
	'author_company' => 'TRITUM, in2code',
	'constraints' => 
	array (
		'depends' => 
		array (
			'php' => '5.3.0-0.0.0',
			'typo3' => '4.5.0-6.2.99',
		),
		'conflicts' => 
		array (
			'mf_akismet' => '0.0.0-9.9.9',
			'wt_calculating_captcha' => '0.0.0-0.0.0',
		),
		'suggests' => 
		array (
		),
	),
	'_md5_values_when_last_written' => '',
);

