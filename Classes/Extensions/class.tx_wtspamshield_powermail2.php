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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * powermail 2.x hook
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_powermail2 extends Tx_Powermail_Domain_Validator_CustomValidator
{

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
    public $additionalValues = [];

    /**
     * @var mixed
     */
    public $tsConf;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->tsConf = $this->getDiv()->getTsConf();
    }

    /**
     * getDiv
     *
     * @return tx_wtspamshield_div
     */
    protected function getDiv()
    {
        if (!isset($this->div)) {
            $this->div = GeneralUtility::makeInstance('tx_wtspamshield_div');
        }
        return $this->div;
    }

    /**
     * Validation of given fields from a SignalSlot
     *
     * @param $fields
     * @return void
     */
    function validate($fields, $controller)
    {
        if ($this->getDiv()->isActivated($this->tsKey)) {
            $availableValidators =
                [
                    'blacklistCheck',
                    'akismetCheck',
                ];

            $tsValidators = $this->getDiv()->commaListToArray($this->tsConf['validators.'][$this->tsKey . '.']['enable']);

            $processor = $this->getDiv()->getProcessor();
            $processor->tsKey = $this->tsKey;
            $processor->fieldValues = $fields;
            $processor->additionalValues = $this->additionalValues;
            $processor->failureRate = intval($this->tsConf['validators.'][$this->tsKey . '.']['how_many_validators_can_fail']);
            $processor->methodes = array_intersect($tsValidators, $availableValidators);

            $error = $processor->validate();

            if (strlen($error) > 0) {
                $controller->addError('spam_details', 50 . '%');
                $controller->isValid = false;
            }
        }
    }
}
