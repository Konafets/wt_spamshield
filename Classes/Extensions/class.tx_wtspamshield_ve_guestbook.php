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

/**
 * ve_guestbook hook
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_ve_guestbook extends tslib_pibase
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
    public $tsKey = 've_guestbook';

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
        $this->additionalValues['honeypotCheck']['prefixInputName'] = 'tx_veguestbook_pi1';
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
            $this->div = t3lib_div::makeInstance('tx_wtspamshield_div');
        }
        return $this->div;
    }

    /**
     * Function is called if form is rendered (set tstamp in session)
     *
     * @param array &$markerArray Array with markers
     * @param array $row Values from database
     * @param array $config configuration
     * @param object &$obj parent object
     * @return array $markerArray
     */
    public function extraItemMarkerProcessor(&$markerArray, $row, $config, &$obj)
    {

        if ($obj->code == 'FORM' &&
            $this->getDiv()->isActivated($this->tsKey)
        ) {
                // Session check - generate session entry
            $methodSessionInstance = t3lib_div::makeInstance('tx_wtspamshield_method_session');
            $methodSessionInstance->setSessionTime();

                // Honeypot check - generate honeypot Input field
            $methodHoneypotInstance = t3lib_div::makeInstance('tx_wtspamshield_method_honeypot');
            $methodHoneypotInstance->additionalValues = $this->additionalValues['honeypotCheck'];
            $obj->templateCode = str_replace('</form>', $methodHoneypotInstance->createHoneypot() . '</form>', $obj->templateCode);
        }
        return $markerArray;
    }

    /**
     * Function preEntryInsertProcessor is called from a guestbook hook
     * and gives the possibility to disable the db entry of the GB
     *
     * @param array $saveData Values to save
     * @param object &$obj parent object
     * @return array $saveData
     */
    public function preEntryInsertProcessor($saveData, &$obj)
    {
        $cObj = $GLOBALS['TSFE']->cObj;
        $error = '';

        if ($this->getDiv()->isActivated($this->tsKey)) {
                // get GPvars
            $validateArray = t3lib_div::_GP('tx_veguestbook_pi1');
            $error = $this->validate($validateArray);

                // Truncate ve_guestbook temp table
            if ($error) {
                $GLOBALS['TYPO3_DB']->exec_TRUNCATEquery('tx_wtspamshield_veguestbooktemp');
            }

                // Redirect if error happens
            if (strlen($error) > 0) {
                $saveData = ['tstamp' => time()];
                $obj->strEntryTable = 'tx_wtspamshield_veguestbooktemp';
                $obj->config['notify_mail'] = '';
                $obj->config['feedback_mail'] = false;
                if (intval($this->tsConf['redirect.'][$this->tsKey]) > 0) {
                    $obj->config['redirect_page'] =
                        intval($this->tsConf['redirect.'][$this->tsKey]);
                } else {
                    $obj->config['redirect_page'] = $GLOBALS['TSFE']->tmpl->rootLine[0]['uid'];
                }
                unset($obj->tt_news);
            }
        }
        return $saveData;
    }

    /**
     * validate
     *
     * @param array $fieldValues
     * @return string
     */
    protected function validate(array $fieldValues)
    {
        $this->additionalValues['nameCheck']['name1'] = $fieldValues['firstname'];
        $this->additionalValues['nameCheck']['name2'] = $fieldValues['surname'];

        $availableValidators =
            [
                'blacklistCheck',
                'nameCheck',
                'sessionCheck',
                'httpCheck',
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