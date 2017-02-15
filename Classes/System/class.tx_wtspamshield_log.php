<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Alexander Kellner <Alexander.Kellner@einpraegsam.net>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * log
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_log extends tslib_pibase {

	/**
	 * @var string
	 */
	public $extKey = 'wt_spamshield';

	/**
	 * @var integer
	 */
	public $dbInsert = TRUE;

	/**
	 * Function dbLog to write a log into the database if spam was recognized
	 *
	 * @param string $ext Name of extension in which the spam was recognized
	 * @param integer $points 
	 * @param string $errorMessages Error Message
	 * @param array $formArray Array with submitted values
	 * @return string
	 */
	public function dbLog($ext, $points, $errorMessages, $formArray) {
		$div = t3lib_div::makeInstance('tx_wtspamshield_div');
		$tsConf = $div->getTsConf();

		if ($this->dbInsert) {
			if ($tsConf['logging.']['pid'] == -1) {
				return FALSE;
			}

			if ($tsConf['logging.']['pid'] == -2) {
				$tsConf['logging.']['pid'] = $GLOBALS['TSFE']->id;
			}

			$title = date('d.m.Y H:i:s', time()) . ' - ' .
				$ext . ' - pid: ' . $GLOBALS['TSFE']->id .
				' - Score: ' . $points;

			$errorMessage = 'Score: ' . $points;

			$dbValues = array (
				'pid' => intval($tsConf['logging.']['pid']),
				'tstamp' => time(),
				'crdate' => time(),
				'title' => $title,
				'form' => $ext,
				'errormsg' => $errorMessage,
				'pageid' => $GLOBALS['TSFE']->id,
				'ip' => t3lib_div::getIndpEnv('REMOTE_ADDR'),
				'useragent' => t3lib_div::getIndpEnv('HTTP_USER_AGENT')
			);
				// Downwards compatibility
			if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility')) {
				$t3Version = \TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
			} else if (class_exists('t3lib_utility_VersionNumber')) {
				$t3Version = t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version);
			} else if (class_exists('t3lib_div')) {
				$t3Version = t3lib_div::int_from_ver(TYPO3_version);
			}

			if ($t3Version < 4007000) {
				$dbValues += array(
					'formvalues' => t3lib_div::view_array($formArray) . t3lib_div::view_array($errorMessages)
				);
			} else {
				$dbValues += array(
					'formvalues' => t3lib_utility_Debug::viewArray($formArray) . t3lib_utility_Debug::viewArray($errorMessages)
				);
			}

			$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_wtspamshield_log', $dbValues);
		}
		return '';
	}
}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/System/class.tx_wtspamshield_log.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/System/class.tx_wtspamshield_log.php']);
}

?>