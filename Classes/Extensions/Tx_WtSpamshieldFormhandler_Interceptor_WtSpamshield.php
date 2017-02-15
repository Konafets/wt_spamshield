<?php
/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * Spam protection for the form withouth Captcha using wt_spamshield extension. 
 *
 * @author	Charles Brunet <charles@cbrunet.net>
 */
class Tx_WtSpamshieldFormhandler_Interceptor_WtSpamshield extends Tx_Formhandler_Interceptor_AntiSpamFormTime {


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
	public $tsKey = 'formhandler';

	/**
	 * @var mixed
	 */
	public $tsConf;

	/**	
	 * Initialize the class variables
	 *
	 * @param array $gp GET and POST variable array
	 * @param array $settings Typoscript configuration for the component (component.1.config.*)
	 *
	 * @return void
	 */
	public function init($gp, $settings) {
		// $this->tsConf is config from wt_spamshield
		// $settings is config from formhandler
		$this->tsConf = $this->getDiv()->getTsConf();


		if (isset($settings['validators.'])) {
			if (isset($settings['validators.']['enable'])) {
				$this->tsConf['validators.'][$this->tsKey . '.']['enable'] = $settings['validators.']['enable'];
			}
			if (isset($settings['validators.']['how_many_validators_can_fail'])) {
				$this->tsConf['validators.'][$this->tsKey . '.']['how_many_validators_can_fail'] = $settings['validators.']['how_many_validators_can_fail'];
			}
		}

		
		if (isset($settings['httpCheck.'])) {
			if (isset($settings['httpCheck.']['maximumLinkAmount'])) {
				$this->tsConf['httpCheck.']['maximumLinkAmount'] = $settings['httpCheck.']['maximumLinkAmount'];
			}			 
		}

		if (isset($settings['uniqueCheck.'])) {
			if (isset($settings['uniqueCheck.']['fields'])) {
				$this->tsConf['uniqueCheck.']['fields'] = $settings['uniqueCheck.']['fields'];
			}
		}

		$honeypotInputName = $this->tsConf['honeypot.']['inputname.'][$this->tsKey];
		if (isset($settings['honeypotCheck.'])) {
			if (isset($settings['honeypotCheck.']['inputname'])) {
				$honeypotInputName = $settings['honeypotCheck.']['inputname'];
			}
		}
		$this->additionalValues['honeypotCheck']['honeypotInputName'] = $honeypotInputName;

		if (isset($settings['akismetCheck.'])) {
			if (isset($settings['akismetCheck.']['fields.'])) {
				foreach ($settings['akismetCheck.']['fields.'] as $key => $value) {
					$this->tsConf['fields.'][$this->tsKey . '.'][$key] = $value;
				}
			}
		}

		// This is a little hack to pass config values to wt_spamshield.
		// It could probably fail if there are more than one plugin on the same page.
		$GLOBALS['TSFE']->tmpl->setup['plugin.']['wt_spamshield.'] = $this->tsConf;
		

		parent::init($gp, $settings);
	}

	/**
	 * getDiv
	 * 
	 * @return tx_wtspamshield_div
	 */
	protected function getDiv() {
		if (!isset($this->div)) {
			$this->div = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_wtspamshield_div');
		}
		return $this->div;
	}


	/**
	 * Performs checks if the submitted form should be treated as Spam.
	 *
	 * @return boolean
	 */
	protected function doCheck() {
		if ( $this->getDiv()->isActivated($this->tsKey) ) {
			$error = $this->validate($this->gp);
			$this->gp['wtspamshield'] = strip_tags($error);
			if (strlen($error) > 0) {
				return TRUE;
			}
		}
		return FALSE;
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