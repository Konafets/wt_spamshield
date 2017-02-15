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
 * http check
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_method_httpcheck extends tx_wtspamshield_method_abstract {

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
	 * @var string
	 */
	public $searchstring = 'http://|https://|ftp.';

	/**
	 * Function validate()
	 *
	 * @return string $error Return errormessage if error exists
	 */
	public function validate() {
		if (isset($this->fieldValues)) {
			$noOfErrors = 0;
			$tsConf = $this->getDiv()->getTsConf();
			$error = $this->renderCobj($tsConf['errors.'], 'httpCheck');
			$error = sprintf($error, intval($tsConf['httpCheck.']['maximumLinkAmount']));

			foreach ((array) $this->fieldValues as $key => $value) {
				if (!is_array($value)) {

					$result = array();
					preg_match_all('@' . $this->searchstring . '@', strtolower($value), $result);
					if (isset($result[0])) {
						$noOfErrors += count($result[0]);
					}
				} else {
						// ???
					if (!is_array($value2)) {
						foreach ((array) $this->fieldValues[$key] as $key2 => $value2 ) {
							$result = array();
							preg_match_all('@' . $this->searchstring . '@', strtolower($value2), $result);
							if (isset($result[0])) {
								$noOfErrors += count($result[0]);
							}
						}
					}
				}
			}

			if ($noOfErrors > intval($tsConf['httpCheck.']['maximumLinkAmount'])) {
				return $error;
			}

		}
		return '';
	}

}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_httpcheck.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_httpcheck.php']);
}

?>