<?php
namespace TRITUM\WtSpamshield\Extensions;

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
 * powermail 2.x hook
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class Powermail2Validator extends \In2code\Powermail\Domain\Validator\StringValidator {

	/**
	 * @var tx_wtspamshield_div
	 */
	protected $div;

	/**
	 * @var string
	 */
	public $tsKey = 'powermail2';

	/**
	 * @var mixed
	 */
	public $additionalValues = array();

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
	 * Validation of given fields from a SignalSlot
	 *
	 * @param \In2code\Powermail\Domain\Model\Mail $mail
	 * @param \In2code\Powermail\Domain\Validator\CustomValidator $pObj
	 * @return void
	 */
	function validate($mail, $pObj) {
		if ( $this->getDiv()->isActivated($this->tsKey) ) {
			$availableValidators = 
				array(
					'blacklistCheck',
					'akismetCheck',
				);

			$tsValidators = $this->getDiv()->commaListToArray($this->tsConf['validators.'][$this->tsKey . '.']['enable']);

			$fields = array();
			foreach ($mail->getAnswers() as $answer) {
				if (is_array($answer->getValue())) {
					continue;
				}

				$fields[$answer->getField()->getMarker()] = $answer->getValue();
			}

			$processor = $this->getDiv()->getProcessor();
			$processor->tsKey = $this->tsKey;
			$processor->fieldValues = $fields;
			$processor->additionalValues = $this->additionalValues;
			$processor->failureRate = intval($this->tsConf['validators.'][$this->tsKey . '.']['how_many_validators_can_fail']);
			$processor->methodes = array_intersect($tsValidators, $availableValidators);

			$error = $processor->validate();

			if (strlen($error) > 0) {
				$pObj->addError('spam_details', 50 . '%');
				$pObj->setIsValid(FALSE);
			}
		}
	}
}

?>