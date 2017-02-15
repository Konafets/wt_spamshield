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
 * abstract
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_method_abstract extends tslib_pibase {

	/**
	 * @var mixed
	 */
	public $ll = '';

	/**
	 * @var mixed
	 */
	public $l = FALSE;

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
	public function __construct() {
		if ($GLOBALS['LANG']->lang) {
			$this->l = $GLOBALS['LANG'];
		} else {
			$this->l = $GLOBALS['TSFE'];
		}

		$this->ll = $this->includeLocalLang();

		if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility')) {
			$t3Version = \TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
		} else if (class_exists('t3lib_utility_VersionNumber')) {
			$t3Version = t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version);
		} else if (class_exists('t3lib_div')) {
			$t3Version = t3lib_div::int_from_ver(TYPO3_version);
		}

		if ($t3Version >= 6000000) {
			$this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tslib_cObj');
		} else {
			$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		}
	}

	/**
	 * getL10n
	 *
	 * @param string $string
	 * @return string $message
	 */
	public function getL10n($string) {
		$message = $this->l->getLLL($string, $this->ll);
		return $message;
	}

	/**
	 * includeLocalLang
	 *
	 * @return mixed $localLang
	 */
	public function includeLocalLang() {
		if (class_exists('\TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility')) {
			$t3Version = \TYPO3\CMS\Core\Utility\GeneralUtility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
		} else if (class_exists('t3lib_utility_VersionNumber')) {
			$t3Version = t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version);
		} else if (class_exists('t3lib_div')) {
			$t3Version = t3lib_div::int_from_ver(TYPO3_version);
		}

		if ($t3Version >= 6000000) {
			$llFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('wt_spamshield') .
				'Resources/Private/Language/locallang.xml';
			$localLang = \TYPO3\CMS\Core\Utility\GeneralUtility::readLLfile($llFile, $this->l->lang);
		} elseif ($t3Version >= 4006000) {
			$llFile = t3lib_extMgm::extPath('wt_spamshield') . 'Resources/Private/Language/locallang.xml';
			$xmlParser = t3lib_div::makeInstance('t3lib_l10n_parser_Llxml');
			$localLang = $xmlParser->getParsedData($llFile, $this->l->lang);
		} else {
			$llFile = t3lib_extMgm::extPath('wt_spamshield') . 'Resources/Private/Language/locallang.xml';
			$localLang = t3lib_div::readLLXMLfile($llFile, $this->l->lang);
		}
		return $localLang;
	}

	/**
	 * renderCobj
	 *
	 * @param mixed $section
	 * @param string $key
	 * @return mixed $content
	 */
	public function renderCobj($section, $key) {
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
	 * @return	tx_wtspamshield_div
	 */
	public function getDiv() {
		if (!isset($this->div)) {
			$this->div = t3lib_div::makeInstance('tx_wtspamshield_div');
		}
		return $this->div;
	}
}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_abstract.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_abstract.php']);
}

?>