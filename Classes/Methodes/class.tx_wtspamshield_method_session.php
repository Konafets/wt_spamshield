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
 * session check
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_method_session extends tx_wtspamshield_method_abstract {

	/**
	 * @var mixed
	 */
	public $fieldValues;

	/**
	 * @var mixed
	 */
	public $additionalValues;

	/**
	 * @var string
	 */
	public $tsKey;

	/**
	 * Set Timestamp in session (when the form is rendered)
	 *
	 * @param boolean $forceValue Whether to force setting the
	 *                            timestampe in the session
	 * @return void
	 */
	public function setSessionTime($forceValue = TRUE) {
		$tsConf = $this->getDiv()->getTsConf();

		$sessionEndTime = intval($tsConf['sessionCheck.']['sessionEndTime']);
		$timeStamp = intval($GLOBALS['TSFE']->fe_user->getKey('ses', 'wt_spamshield_form_tstamp'));
		$isOutdated = ($timeStamp + $sessionEndTime < time());

		if ($forceValue || $isOutdated) {
			$GLOBALS['TSFE']->fe_user->setKey('ses', 'wt_spamshield_form_tstamp', time());
			$GLOBALS['TSFE']->storeSessionData();
		}

	}

	/**
	 * Save the current Page TS in session (when the form is rendered)
	 *
	 * @param string $key
	 * @return void
	 */
	public function saveCurrentTSInSession($key) {
		$key = 'wt_spamshield_enable_' . $key;
		$value = $GLOBALS['TSFE']->tmpl->setup['plugin.']['wt_spamshield.'];
		$GLOBALS['TSFE']->fe_user->setKey('ses', $key, $value);
		$GLOBALS['TSFE']->storeSessionData();
	}

	/**
	 * Return Errormessage if session it runned out
	 * 
	 * @return string $error Return errormessage if error exists
	 */
	public function validate() {
		$error = '';

		$sessTstamp = intval($GLOBALS['TSFE']->fe_user->getKey('ses', 'wt_spamshield_form_tstamp'));
		$tsConf = $this->getDiv()->getTsConf();

		$sessionStartTime = intval($tsConf['sessionCheck.']['sessionStartTime']);
		$sessionEndTime = intval($tsConf['sessionCheck.']['sessionEndTime']);

		if ($sessTstamp > 0) {
			if ((($sessTstamp + $sessionEndTime) < time()) && ($sessionEndTime > 0)) {
				$error = $this->renderCobj($tsConf['errors.'], 'session_error_1');
			} elseif ( (($sessTstamp + $sessionStartTime) > time())
						&& ($sessionStartTime > 0)
			) {
				$error = $this->renderCobj($tsConf['errors.'], 'session_error_2');
			}
		} else {
			$error = $this->renderCobj($tsConf['errors.'], 'session_error_3');
		}

		return $error;
	}

}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_session.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_session.php']);
}

?>