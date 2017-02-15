<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2015 Ralf Zimmermann <ralf.zimmermann@tritum.de>
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
*/

/**
 * pbsurvey hook
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_pbsurvey extends tslib_pibase {

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
	public $tsKey = 'pbsurvey';

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
		$this->additionalValues['honeypotCheck']['prefixInputName'] = 'tx_pbsurvey_pi1';
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
	 * @param array &$arrItem Array with items
	 * @param object &$pObj parent object
	 * @return string $strOutput
	 */
	public function hookItemProcessor($arrItem, &$pObj) {
		$strOutput = '';

		if ($this->getDiv()->isActivated($this->tsKey)) {
				// Session check - generate session entry
			$methodSessionInstance = t3lib_div::makeInstance('tx_wtspamshield_method_session');
			$methodSessionInstance->setSessionTime();

				// Honeypot check - generate honeypot Input field
			$methodHoneypotInstance = t3lib_div::makeInstance('tx_wtspamshield_method_honeypot');
			$methodHoneypotInstance->additionalValues = $this->additionalValues['honeypotCheck'];
			$strOutput = $methodHoneypotInstance->createHoneypot();
		}

		return $strOutput;
	}

	/**
	 *
	 * @param array $arrValidation Array with items
	 * @param array $piVars the request
	 * @param array &$arrError error messages
	 * @param object &$pObj parent object
	 * @return string $strOutput
	 */
	public function validateForm($arrValidation, $piVars, &$arrError, &$pObj) {
		if ($this->getDiv()->isActivated($this->tsKey)) {
			$stringTypes = array(2,4,5,10,12,13,14,15);

			$validationFieds = array();

			$honeypotInputName = $this->additionalValues['honeypotCheck']['honeypotInputName'];
			$honeypotInputValue = $piVars[$honeypotInputName];
			$validationFieds[$honeypotInputName] = $honeypotInputValue;

			foreach($arrValidation as $intKey => $arrQuestionValidation) {
				if (isset($piVars[$intKey])) {
					$strTotalValue = '';

					foreach($piVars[$intKey] as $intRow => $arrRowValue) {
						if (!is_array($arrRowValue)) {
							$intRow = $arrRowValue;
							$arrRowValue = array(0 => $arrRowValue);
						}
						foreach ($arrRowValue as $intColumn => $strValue) {
							if (in_array($arrQuestionValidation['type'], $stringTypes)
								&& !empty($strValue)
							) {
								$strTotalValue = $strValue;
							}

							if ($arrQuestionValidation['type'] == 7) {
								$strTotalValue .= ' ' . $strValue;
							}
						}
					}
					$validationFieds[$intKey] = $strTotalValue;
				}
			}

			$error = $this->validate($validationFieds);

			if (strlen($error) > 0) {
				$arrError[] = $error;
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
		$availableValidators = 
			array(
				'sessionCheck',
				'httpCheck',
				'honeypotCheck',
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
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_wtspamshield_ve_guestbook.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_wtspamshield_ve_guestbook.php']);
}

?>