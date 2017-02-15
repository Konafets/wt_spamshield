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
 * unique check
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_method_unique extends tx_wtspamshield_method_abstract {

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
	 * Check if the values are in more fields and return error
	 *
	 * @return string $error Return errormessage if error exists
	 */
	public function validate() {
		$found = 0;
		$wholearray = array();

		$tsConf = $this->getDiv()->getTsConf();
		$error = $this->renderCobj($tsConf['errors.'], 'uniquecheck');

		$myFieldArray = t3lib_div::trimExplode(';', $tsConf['uniqueCheck.']['fields'], 1);
		if (is_array($myFieldArray)) {
			foreach ($myFieldArray as $myKey => $myValue) {
				$wholearray = array();
				$fieldarray = t3lib_div::trimExplode(',', $myValue, 1);

				if (is_array($fieldarray)) {
					foreach ($fieldarray as $key => $value) {
						if ($this->fieldValues[$value]) {
							$wholearray[] = $this->fieldValues[$value];
						}
					}
				}

				if (count($wholearray) != count(array_unique($wholearray))) {
					$found = 1;
				}
			}
		}

		if ($found) {
			return $error;
		}

		return '';
	}

}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_unique.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_unique.php']);
}

?>