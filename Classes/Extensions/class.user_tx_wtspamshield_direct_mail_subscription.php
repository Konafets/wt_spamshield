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
 * direct_mail_subscription hook
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class user_tx_wtspamshield_direct_mail_subscription extends user_feAdmin {

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
	public $tsKey = 'direct_mail_subscription';

	/**
	 * @var mixed
	 */
	public $tsConf;

	/**
	 * @var string
	 */
	public $spamshieldDisplayError;

	/**
	 * @var mixed
	 */
	public $parentConf;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->tsConf = $this->getDiv()->getTsConf();
		$honeypotInputName = $this->tsConf['honeypot.']['inputname.'][$this->tsKey];
		$this->additionalValues['honeypotCheck']['prefixInputName'] = 'FE[tt_address]';
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
	 * displayCreateScreen
	 * 
	 * @return mixed
	 */
	public function displayCreateScreen() {

		if ( $this->getDiv()->isActivated($this->tsKey) ) {
			if (isset($this->parentConf)) {
				$this->conf['create'] = $this->parentConf;
			}
			$methodHoneypotInstance = t3lib_div::makeInstance('tx_wtspamshield_method_honeypot');
			$methodHoneypotInstance->additionalValues = $this->additionalValues['honeypotCheck'];
			$this->markerArray['###HIDDENFIELDS###'] .= $methodHoneypotInstance->createHoneypot();
			if ($this->spamshieldDisplayError) {
				$this->markerArray['###HIDDENFIELDS###'] .= $this->spamshieldDisplayError;
			}
		}

		return parent::displayCreateScreen();
	}

	/**
	 * save
	 * 
	 * @return	mixed
	 */
	public function save() {
		$error = '';

		if ( $this->getDiv()->isActivated($this->tsKey) ) {
			$validateArray = $this->dataArr;
			$error = $this->validate($validateArray);

			if (strlen($error) > 0) {
					// $this->error='###TEMPLATE_NO_PERMISSIONS###';
				$this->saved = 0;
				$this->cmd = 'create';
				$this->parentConf = $this->conf['create'];
				unset($this->conf['create']);
				$this->spamshieldDisplayError = $error;
			}
		}

		return parent::save();
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
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.user_tx_wtspamshield_direct_mail_subscription.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.user_tx_wtspamshield_direct_mail_subscription.php']);
}

?>