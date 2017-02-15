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
***************************************************************/

/**
 * processor
 * 
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_processor {

	/**
	 * @var string
	 */
	public $tsKey;

	/**
	 * @var mixed
	 */
	public $fieldValues = array();

	/**
	 * @var mixed
	 */
	public $additionalValues = array();

	/**
	 * @var int
	 */
	public $failureRate;

	/**
	 * @var mixed
	 */
	public $methodes = array();

	/**
	 * @var int
	 */
	public $currentFailures = 0;

	/**
	 * @var mixed
	 */
	public $errorMessages = array();

	/**
	 * log
	 * 
	 * @return void
	 */
	public function log() {
		$methodLogInstance = t3lib_div::makeInstance('tx_wtspamshield_log');
		$methodLogInstance->dbLog($this->tsKey, $this->currentFailures, $this->errorMessages, $this->fieldValues);

		$methodSendEmailInstance = t3lib_div::makeInstance('tx_wtspamshield_mail');
		$methodSendEmailInstance->sendEmail($this->tsKey, $this->currentFailures, $this->errorMessages, $this->fieldValues);
	}

	/**
	 * processValidationChain
	 * 
	 * @return string
	 */
	public function validate() {
		$errorMessage = '';

		$methodMap = array(
			'blacklistCheck' => 'tx_wtspamshield_method_blacklist',
			'nameCheck' => 'tx_wtspamshield_method_namecheck',
			'httpCheck' => 'tx_wtspamshield_method_httpcheck',
			'uniqueCheck' => 'tx_wtspamshield_method_unique',
			'sessionCheck' => 'tx_wtspamshield_method_session',
			'honeypotCheck' => 'tx_wtspamshield_method_honeypot',
			'akismetCheck' => 'tx_wtspamshield_method_akismet',
		);

		foreach ($methodMap as $method => $class) {
			if( in_array($method, $this->methodes)) {
				$methodInstance =  t3lib_div::makeInstance($class);
				$methodInstance->fieldValues = $this->fieldValues;
				$methodInstance->additionalValues = $this->additionalValues[$method];
				$methodInstance->tsKey = $this->tsKey;
				$methodReturn = $methodInstance->validate();
				if (strlen($methodReturn) > 0) {
					$this->currentFailures++;
					$this->errorMessages[] = $methodReturn;
				}
				$this->fieldValues = $methodInstance->fieldValues;
			}
		}

		if($this->currentFailures > $this->failureRate) {
			$this->log();
			$errorMessage = implode(' ', $this->errorMessages);
		}

		return $errorMessage;
	}
}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_processor.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_processor.php']);
}

?>