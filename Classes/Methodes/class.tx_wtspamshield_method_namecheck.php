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
 * name check
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_method_namecheck extends tx_wtspamshield_method_abstract {

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
	 * Function validate() to disable the same first- and lastname
	 *
	 * @return string $error Return errormessage if error exists
	 */
	public function validate() {
		if ($this->additionalValues['name1'] === $this->additionalValues['name2'] && $this->additionalValues['name1']) {
			$tsConf = $this->getDiv()->getTsConf();
			$error = $this->renderCobj($tsConf['errors.'], 'nameCheck');
		}

		if (isset($error)) {
			return $error;
		}
	}
}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_namecheck.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/Methodes/class.tx_wtspamshield_method_namecheck.php']);
}

?>