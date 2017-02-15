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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;

/**
 * powermail hook
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_powermail extends AbstractPlugin
{

    /**
     * @var tx_wtspamshield_div
     */
    protected $div;

    /**
     * @var mixed
     */
    public $additionalValues = [];

    /**
     * @var string
     */
    public $tsKey = 'powermail';

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
        $honeypotInputName = $this->tsConf['honeypot.']['inputname.'][$this->tsKey];
        $this->additionalValues['honeypotCheck']['prefixInputName'] = 'tx_powermail_pi1';
        $this->additionalValues['honeypotCheck']['honeypotInputName'] = $honeypotInputName;
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
     * Function PM_FormWrapMarkerHook() to manipulate whole formwrap
     *
     * @param array $outerMarkerArray Marker Array out of the loop from powermail
     * @param array &$subpartArray subpartArray Array from powermail
     * @param array $conf ts configuration from powermail
     * @param array $obj Parent Object
     * @return void
     */
    public function PM_FormWrapMarkerHook($outerMarkerArray, &$subpartArray, $conf, $obj)
    {

        if ($this->getDiv()->isActivated($this->tsKey)) {
                // Set session on form create
            $methodSessionInstance = GeneralUtility::makeInstance('tx_wtspamshield_method_session');
            $methodSessionInstance->setSessionTime();

                // Add Honeypot
            $methodHoneypotInstance = GeneralUtility::makeInstance('tx_wtspamshield_method_honeypot');
            $methodHoneypotInstance->additionalValues = $this->additionalValues['honeypotCheck'];
            $subpartArray['###POWERMAIL_CONTENT###'] .= $methodHoneypotInstance->createHoneypot();
        }
    }


    /**
     * Function PM_FieldWrapMarkerHook() to manipulate Fieldwraps
     *
     * @param array $obj Parent Object
     * @param array $markerArray Marker Array from powermail
     * @param array $sessiondata Values from powermail Session
     * @return string If not false is returned, powermail will show
     *                an error. If string is returned, powermail will
     *                show this string as errormessage
     */
    public function PM_SubmitBeforeMarkerHook($obj, $markerArray = [], $sessiondata = [])
    {
        $error = '';

        if ($this->getDiv()->isActivated($this->tsKey)) {
            $error = $this->validate($sessiondata);

                // Return Error message if exists
            if (strlen($error) > 0) {
                if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_spamshield']['customMessageOnError'][$this->tsKey])) {
                    $customError = '';
                    foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['wt_spamshield']['customMessageOnError'][$this->tsKey] as $_classRef) {
                        $_procObj = &GeneralUtility::getUserObj($_classRef);
                        $customError .= $_procObj->customMessageOnError($error, $this);
                    }
                    return $customError;
                } else {
                    return '<div class="wtspamshield-errormsg">' . $error . '</div>';
                }
            }
        }

        return false;
    }

    /**
     * validate
     *
     * @param array $fieldValues
     * @return string
     */
    protected function validate(array $fieldValues)
    {

        $availableValidators =
            [
                'blacklistCheck',
                'sessionCheck',
                'httpCheck',
                'uniqueCheck',
                'honeypotCheck',
                'akismetCheck',
            ];

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