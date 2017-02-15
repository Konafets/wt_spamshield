<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility')) {
	$t3Version = \TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
} else if (class_exists('t3lib_utility_VersionNumber')) {
	$t3Version = t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version);
} else if (class_exists('t3lib_div')) {
	$t3Version = t3lib_div::int_from_ver(TYPO3_version);
}

/* Use HOOKS in other extensions */

	// Hook Powermail: Generate Form
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['powermail']['PM_FormWrapMarkerHook'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_powermail.php:tx_wtspamshield_powermail';

	// Hook Powermail: Give error to Powermail
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['powermail']['PM_SubmitBeforeMarkerHook'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_powermail.php:tx_wtspamshield_powermail';

	// Hook Powermail2:
if (
	$t3Version >= 6002000 &&
	t3lib_extMgm::isLoaded('powermail')
) {
	$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
	$signalSlotDispatcher->connect('In2code\\Powermail\\Domain\\Validator\\CustomValidator', 'isValid', 'TRITUM\\WtSpamshield\\Extensions\\Powermail2Validator', 'validate');
} else if (
	$t3Version >= 4007000 &&
	t3lib_extMgm::isLoaded('powermail')
) {
	$signalSlotDispatcher = t3lib_div::makeInstance('Tx_Extbase_SignalSlot_Dispatcher');
	$signalSlotDispatcher->connect('Tx_Powermail_Domain_Validator_CustomValidator', 'isValid', 'tx_wtspamshield_powermail2', 'validate');
}

	// Hook ve_guestbook: Generate Form
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ve_guestbook']['extraItemMarkerHook'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_ve_guestbook.php:tx_wtspamshield_ve_guestbook';

	// Hook ve_guestbook: Give error to guestbook
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ve_guestbook']['preEntryInsertHook'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_ve_guestbook.php:tx_wtspamshield_ve_guestbook';

$extPath = t3lib_extMgm::extPath('wt_spamshield');

	// Validator/ Hook standard mailform: Disable email
if (
	$t3Version >= 6002000 &&
	t3lib_extMgm::isLoaded('form')
) {
	$txFormValidator = $extPath . 'Classes/Extensions/WtspamshieldValidator.php';
	require_once($txFormValidator);
} else if (
	$t3Version >= 6000000 &&
	t3lib_extMgm::isLoaded('form')
) {
	$txFormValidator = $extPath . 'Classes/Extensions/WtspamshieldValidator.php';
	require_once($txFormValidator);
} elseif (
	$t3Version >= 4006000 &&
	t3lib_extMgm::isLoaded('form')
) {
	$txFormValidator = $extPath . 'Classes/Extensions/class.tx_form_System_Validate_Wtspamshield.php';
	require_once($txFormValidator);
} else {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['sendFormmail-PreProcClass'][]
		= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_defaultmailform.php:tx_wtspamshield_defaultmailform';
}

	// Hook direct_mail_subscription
	// Sorry, there is no better way, the autoloader does not work
if (t3lib_extMgm::isLoaded('direct_mail_subscription')) {
	$directMailSubscription = t3lib_extMgm::extPath('direct_mail_subscription') . 'fe_adminLib.inc';
	require_once($directMailSubscription);
}

	// Hook tx_comments: Generate Form
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['form'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_comments.php:tx_wtspamshield_comments->form';

	// Hook tx_comments: Give error to comments
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['comments']['externalSpamCheck'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_comments.php:tx_wtspamshield_comments->externalSpamCheck';

	// Hook tx_keuserregister: Generate Form
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tx_keuserregister']['additionalMarkers'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_ke_userregister.php:tx_wtspamshield_ke_userregister';

	// Hook ke_userregister: Give error to ke_userregister
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tx_keuserregister']['specialEvaluations'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_ke_userregister.php:tx_wtspamshield_ke_userregister';

	// Hook t3_blog
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['t3blog']['aftercommentinsertion'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_t3blog.php:tx_wtspamshield_t3blog->insertNewComment';

	// Hook pbsurvey: Generate Form
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pbsurvey']['tx_pbsurvey_pi1']['processHookItem'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_pbsurvey.php:tx_wtspamshield_pbsurvey';

	// Hook pbsurvey: Give error to guestbook
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pbsurvey']['externalFormValidation'][]
	= 'EXT:wt_spamshield/Classes/Extensions/class.tx_wtspamshield_pbsurvey.php:tx_wtspamshield_pbsurvey';

	// Register tx_wtspamshield_log table in table garbage collection task
if ($t3Version >= 6000000) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask']['options']['tables']['tx_wtspamshield_log'] = array(
		'dateField' => 'tstamp',
		'expirePeriod' => 180,
	);
} elseif ($t3Version >= 4007000) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_scheduler_TableGarbageCollection']['options']['tables']['tx_wtspamshield_log'] = array(
		'dateField' => 'tstamp',
		'expirePeriod' => 180,
	);
}
?>
