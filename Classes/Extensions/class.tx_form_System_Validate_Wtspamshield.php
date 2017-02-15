<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2015 Ralf Zimmermann <Ralf.Zimmermann@tritum.de>
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
 * defaultmailform wtspamshield rule (TYPO3 4.6, 4.7)
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_form_System_Validate_Wtspamshield extends tx_form_System_Validate_Abstract {

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
	 * @param array $arguments
	 * @return void
	 */
	public function __construct($arguments) {
		$this->tsConf = $this->getDiv()->getTsConf();
		$honeypotInputName = $this->tsConf['honeypot.']['inputname.'][$this->tsKey];
		$this->additionalValues['honeypotCheck']['prefixInputName'] = 'tx_form';
		$this->additionalValues['honeypotCheck']['honeypotInputName'] = $honeypotInputName;
		parent::__construct($arguments);
	}

	/**
	 * getDiv
	 * 
	 * @return	tx_wtspamshield_div
	 */
	protected function getDiv() {
		if (!isset($this->div)) {
			$this->div = t3lib_div::makeInstance('tx_wtspamshield_div');
		}
		return $this->div;
	}

	/**
	 * Returns TRUE if submitted value validates according to rule
	 *
	 * @return	boolean
	 * @see tx_form_System_Validate_Interface::isValid()
	 */
	public function isValid() {

		if ( $this->getDiv()->isActivated($this->tsKey) ) {
			$error = '';

			if ($this->requestHandler->has($this->fieldName)) {
				$value = $this->requestHandler->getByMethod($this->fieldName);
				$validateArray = array(
					$this->fieldName => $value
				);
				$error = $this->validate($validateArray);
			}

			if (strlen($error) > 0 ) {
				$this->setError('', strip_tags($error));
				return FALSE;
			}
		}

		return TRUE;
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
				'honeypotCheck',
			);

		$tsValidators = $this->getDiv()->commaListToArray($this->tsConf['validators.'][$this->tsKey . '_new.']['enable']);

		$processor = $this->getDiv()->getProcessor();
		$processor->tsKey = $this->tsKey;
		$processor->fieldValues = $fieldValues;
		$processor->additionalValues = $this->additionalValues;
		$processor->failureRate = intval($this->tsConf['validators.'][$this->tsKey . '_new.']['how_many_validators_can_fail']);
		$processor->methodes = array_intersect($tsValidators, $availableValidators);

		$error = $processor->validate();
		return $error;
	}

}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_form_System_Validate_Wtspamshield.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_form_System_Validate_Wtspamshield.php']);
}

?>