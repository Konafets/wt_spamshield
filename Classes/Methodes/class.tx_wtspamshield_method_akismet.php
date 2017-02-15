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
 * akismet check
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_method_akismet extends tx_wtspamshield_method_abstract {

	/**
	 * @var mixed
	 */
	public $fieldValues;

	/**
	 * @var mixed
	 */
	public $additionalValues;

	/**
	 * @var string
	 */
	public $tsKey;

	/**
	 * Function validate() send form values to akismet server and
	 * waits for the feedback if it's spam or not
	 *
	 * @return string $error Return errormessage if error exists
	 */
	public function validate() {
		$error = '';

		$akismetArray = array();
		$tsConf = $this->getDiv()->getTsConf();

			// Get field mapping from TS
		$fields = $tsConf['fields.'][$this->tsKey . '.'];
		foreach ($fields as $key => $value) {
			if ($value && array_key_exists($value, $this->fieldValues)) {
				$akismetArray[$key] = $this->fieldValues[$value];
			}
		}

		$akismetArray += array(
			'user_ip' => t3lib_div::getIndpEnv('REMOTE_ADDR'),
			'user_agent' => t3lib_div::getIndpEnv('HTTP_USER_AGENT')
		);

		if ((int) $tsConf['akismetCheck.']['testMode'] == 1) {
			$akismetArray['is_test'] = 1;
		}

		$akismet = new tx_wtspamshield_akismet(
			'http://' . t3lib_div::getIndpEnv('HTTP_HOST') . '/',
			$tsConf['akismetCheck.']['akismetKey'],
			$akismetArray
		);

		if (!$akismet->isError() && $akismet->isSpam()) {
			$error = $this->renderCobj($tsConf['errors.'], 'akismet');
		}

		if (isset($error)) {
			return $error;
		}
		return '';
	}

}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_akismet.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_akismet.php']);
}

?>