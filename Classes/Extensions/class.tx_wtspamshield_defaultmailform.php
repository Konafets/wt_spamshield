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
 * defaultmailform hook (TYPO3 <= 4.5)
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_defaultmailform extends tslib_pibase {

	/**
	 * @var array
	 */
	protected $messages = array();

	/**
	 * @var tx_wtspamshield_div
	 */
	protected $div;

	/**
	 * @var mixed
	 */
	public $additionalValues = array();

	/**
	 * @var string
	 */
	public $tsKey = 'standardMailform';

	/**
	 * @var mixed
	 */
	public $tsConf;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->tsConf = $this->getDiv()->getTsConf();
		$honeypotInputName = $this->tsConf['honeypot.']['inputname.'][$this->tsKey];
		$this->additionalValues['honeypotCheck']['honeypotInputName'] = $honeypotInputName;
	}

	/**
	 * getDiv
	 * 
	 * @return tx_wtspamshield_div
	 */
	protected function getDiv() {
		if (!isset($this->div)) {
			$this->div = t3lib_div::makeInstance('tx_wtspamshield_div');
		}
		return $this->div;
	}

	/**
	 * Function generateSession() is called if the form is
	 * rendered (generate a session)
	 *
	 * @param string $content
	 * @param array $configuration
	 * @return string
	 */
	public function generateSession($content, array $configuration = NULL) {
		if ( $this->getDiv()->isActivated($this->tsKey) ) {
			$forceValue = !(isset($configuration['ifOutdated']) && $configuration['ifOutdated']);

				// Set session on form create
			$methodSessionInstance = t3lib_div::makeInstance('tx_wtspamshield_method_session');
			$methodSessionInstance->setSessionTime($forceValue);
			$methodSessionInstance->saveCurrentTSInSession('standardMailform');
		}

		return $content;
	}

	/**
	 * Function sendFormmail_preProcessVariables() is called after
	 * submit - stop mail if needed
	 *
	 * @param object $form Form Object
	 * @param object $obj Parent Object
	 * @param array $legacyConfArray legacy configuration
	 * @return object $form
	 */
	public function sendFormmail_preProcessVariables($form, $obj, $legacyConfArray = array()) {
		if ( $this->getDiv()->isActivated($this->tsKey, TRUE) ) {
			$error = $this->validate($form);

				// 2c. Redirect and stop mail sending
			if (strlen($error) > 0) {
				$sessionKey = 'wt_spamshield_enable_' . $this->tsKey;
				$sessionValue = $GLOBALS['TSFE']->fe_user->getKey('ses', $sessionKey);
				if ($sessionValue) {
					$this->tsConf = $sessionValue;
				}
				$link = (strlen($this->tsConf['redirect.'][$this->tsKey]) > 0
					? $this->tsConf['redirect.'][$this->tsKey]
					: t3lib_div::getIndpEnv('TYPO3_SITE_URL'));
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: ' . $link);
				header('Connection: close');
				return FALSE;
			}
		}

		return $form;
	}

	/**
	 * validate
	 * 
	 * @param array $fieldValues
	 * @return string
	 */
	protected function validate(array $fieldValues) {

		$availableValidators =
			array(
				'blacklistCheck',
				'httpCheck',
				'uniqueCheck',
				'sessionCheck',
				'honeypotCheck',
			);

		$tsValidators = $this->getDiv()->commaListToArray($this->tsConf['validators.'][$this->tsKey . '_old.']['enable']);

		$processor = $this->getDiv()->getProcessor();
		$processor->tsKey = $this->tsKey;
		$processor->fieldValues = $fieldValues;
		$processor->additionalValues = $this->additionalValues;
		$processor->failureRate = intval($this->tsConf['validators.'][$this->tsKey . '_old.']['how_many_validators_can_fail']);
		$processor->methodes = array_intersect($tsValidators, $availableValidators);

		$error = $processor->validate();
		return $error;
	}
}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_wtspamshield_defaultmailform.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_wtspamshield_defaultmailform.php']);
}

?>