<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Stefan Froemken <froemken@gmail.com>
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
 * ke_userregister hook
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_ke_userregister extends tslib_pibase {

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
	public $tsKey = 'ke_userregister';

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
		$this->additionalValues['honeypotCheck']['prefixInputName'] = 'tx_keuserregister_pi1';
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
	 * Function is called if form is rendered (set tstamp in session)
	 *
	 * @param array &$markerArray Array with markers
	 * @param object $pObj parent object
	 * @param array $errors Array with errors
	 * @return void
	 */
	public function additionalMarkers(&$markerArray, $pObj, $errors) {
		if ( $this->getDiv()->isActivated($this->tsKey) ) {
				// Session check - generate session entry
			$methodSessionInstance = t3lib_div::makeInstance('tx_wtspamshield_method_session');
			$methodSessionInstance->setSessionTime();

				// Honeypot check - generate honeypot Input field
			$methodHoneypotInstance = t3lib_div::makeInstance('tx_wtspamshield_method_honeypot');
			$methodHoneypotInstance->additionalValues = $this->additionalValues['honeypotCheck'];
			$pObj->templateCode = str_replace('</form>', $methodHoneypotInstance->createHoneypot() . '</form>', $pObj->templateCode);
		}
	}

	/**
	 * Function processSpecialEvaluations is called from a
	 * ke_userregister hook and gives the possibility to disable the
	 * db entry of the registration
	 *
	 * @param array &$errors generated errors till now
	 * @param object &$pObj parent object
	 * @return void
	 */
	public function processSpecialEvaluations(&$errors, &$pObj) {
			// execute this hook only if there are no other errors
		if (is_array($errors) && count($errors)) {
			return;
		}

		$error = '';

		if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility')) {
			$t3Version = \TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
		} else if (class_exists('t3lib_utility_VersionNumber')) {
			$t3Version = t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version);
		} else if (class_exists('t3lib_div')) {
			$t3Version = t3lib_div::int_from_ver(TYPO3_version);
		}

			// get GPvars, downwards compatibility
		if ($t3Version < 4004000) {
			$validateArray = t3lib_div::GPvar('tx_keuserregister_pi1');
		} else {
			$validateArray = t3lib_div::_GP('tx_keuserregister_pi1');
		}

		if ( $this->getDiv()->isActivated($this->tsKey) ) {

			$error = $this->validate($validateArray);
				// Error message
			if ($error) {
					// Workaround: create field via TS and put it in HTML
					// template of ke_userregister
				$errors['wt_spamshield'] = $error;
			}
		}
	}

	/**
	 * validate
	 * 
	 * @param array $fieldValues
	 * @return string
	 */
	protected function validate(array $fieldValues) {
		$this->additionalValues['nameCheck']['name1'] = $fieldValues['first_name'];
		$this->additionalValues['nameCheck']['name2'] = $fieldValues['last_name'];

		$availableValidators =
			array(
				'blacklistCheck',
				'nameCheck',
				'httpCheck',
				'sessionCheck',
				'honeypotCheck',
				'akismetCheck',
			);

		$tsValidators = $this->getDiv()->commaListToArray($this->tsConf['validators.'][$this->tsKey . '.']['enable']);

		$processor = $this->getDiv()->getProcessor();
		$processor->tsKey = $this->tsKey;
		$processor->fieldValues = $fieldValues;
		$processor->additionalValues = $this->additionalValues;
		$processor->failureRate = intval($this->tsConf['validators.'][$this->tsKey . '.']['how_many_validators_can_fail']);
		$processor->methodes = array_intersect($tsValidators, $availableValidators);

		$error = $processor->validate();
		return $error;
	}

}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_wtspamshield_ke_userregister.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_wtspamshield_ke_userregister.php']);
}

?>