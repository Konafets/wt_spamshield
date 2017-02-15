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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * abstract
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_method_abstract extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{

    /**
     * @var mixed
     */
    public $ll = '';

    /**
     * @var mixed
     */
    public $l = false;

    /**
     * @var mixed
     */
    public $cObj;

    /**
     * @var tx_wtspamshield_div
     */
    protected $div;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        if ($GLOBALS['LANG']->lang) {
            $this->l = $GLOBALS['LANG'];
        } else {
            $this->l = $GLOBALS['TSFE'];
        }

        $this->ll = $this->includeLocalLang();

        $this->cObj = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
    }

    /**
     * getL10n
     *
     * @param string $string
     * @return string $message
     */
    public function getL10n($string)
    {
        $message = $this->l->getLLL($string, $this->ll);
        return $message;
    }

    /**
     * includeLocalLang
     *
     * @return mixed $localLang
     */
    public function includeLocalLang()
    {
        $llFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('wt_spamshield') .
            'Resources/Private/Language/locallang.xml';
        $localLang = GeneralUtility::readLLfile($llFile, $this->l->lang);

        return $localLang;
    }

    /**
     * renderCobj
     *
     * @param mixed $section
     * @param string $key
     * @return mixed $content
     */
    public function renderCobj($section, $key)
    {
        $cObjType = $section[$key];
        $cObjvalues = $section[$key . '.'];
        $lll = $cObjvalues['value'];
        $cObjvalues['value'] = $this->getL10n($lll);
        $content = $this->cObj->cObjGetSingle($cObjType, $cObjvalues);
        return $content;
    }

    /**
     * getDiv
     *
     * @return  tx_wtspamshield_div
     */
    public function getDiv()
    {
        if (!isset($this->div)) {
            $this->div = GeneralUtility::makeInstance('tx_wtspamshield_div');
        }
        return $this->div;
    }
}