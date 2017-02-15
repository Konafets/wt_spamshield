<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Lina Wolf <2010@lotypo3.de>
*  based on Code of Alexander Kellner <Alexander.Kellner@einpraegsam.net>
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
 * tx_comments hook
 * 
 * @author Lina Wolf <2010@lotypo3.de>
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_comments extends tslib_pibase {

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
	public $tsKey = 'comments';

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
		$this->additionalValues['honeypotCheck']['prefixInputName'] = 'tx_comments_pi1';
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
	* Implementation of Hook "form" from tx_comments (when the form is rendered)
	* Adds the Honeypot input field to the marker ###JS_USER_DATA###
	* (part of the default template)
	* 
	* @param mixed $params array of 'pObject' => Name of extension 'markers'
	* 								array of markers 'template' the template
	* @param mixed $pObj 
	* @return mixed $markers the changed marker array
	*/
	public function form($params, $pObj) {
		$template = $params['template'];
		$markers = $params['markers'];

		if ( $this->getDiv()->isActivated( $this->tsKey ) ) {
				// Session check - generate session entry
			$methodSessionInstance = t3lib_div::makeInstance('tx_wtspamshield_method_session');
			$methodSessionInstance->setSessionTime();

				// Honeypot check - generate honeypot Input field
			$methodHoneypotInstance = t3lib_div::makeInstance('tx_wtspamshield_method_honeypot');
			$methodHoneypotInstance->additionalValues = $this->additionalValues['honeypotCheck'];
			$markers['###JS_USER_DATA###'] = $methodHoneypotInstance->createHoneypot() . $markers['###JS_USER_DATA###'];
		}
		return $markers;
	}

	/**
	* Implementation of Hook "externalSpamCheck" from tx_comments 
	* Test for spam and addd 1000 spampoints for each Problem found
	* 
	* @param mixed $params array of 'pObject' => Name of extension 'form'
	* 							array of fields in the form 'points' excistent spam points
	* @param mixed $pObj 
	* @return integer $this->points number of spam points increased
	* 									by 100 for every problem that was found
	*/
	public function externalSpamCheck($params, $pObj) {
		$cObj = $GLOBALS['TSFE']->cObj;
		$error = '';
		$validateArray = $params['formdata'];
		$points = $params['points'];

		if ( $this->getDiv()->isActivated( $this->tsKey ) ) {
			$points += $this->validate($validateArray);
		}

		return $points;
	}

	/**
	 * validate
	 * 
	 * @param array $fieldValues
	 * @return string
	 */
	protected function validate(array $fieldValues) {
		$this->additionalValues['nameCheck']['name1'] = $fieldValues['firstname'];
		$this->additionalValues['nameCheck']['name2'] = $fieldValues['lastname'];

		$availableValidators =
			array(
				'blacklistCheck',
				'nameCheck',
				'uniqueCheck',
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

		$processor->validate();
		return $processor->currentFailures * 1000;
	}
}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_wtspamshield_comments.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Extensions/class.tx_wtspamshield_comments.php']);
}

?>