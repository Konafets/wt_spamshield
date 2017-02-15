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
 * 01.26.2006 12:29:28est
 * 
 * Akismet PHP4 class
 * 
 * <b>Usage</b>
 * <code>
 *    $comment = array(
 *           'author'    => 'viagra-test-123',
 *           'email'     => 'test@example.com',
 *           'website'   => 'http://www.example.com/',
 *           'body'      => 'This is a test comment',
 *           'permalink' => 'http://yourdomain.com/yourblogpost.url',
 *        );
 *
 *    $akismet = new Akismet('http://www.yourdomain.com/',
 * 							'YOUR_WORDPRESS_API_KEY', $comment);
 *
 *    if($akismet->isError()) {
 *        echo"Couldn't connected to Akismet server!";
 *    } else {
 *        if($akismet->isSpam()) {
 *            echo"Spam detected";
 *        } else {
 *            echo"yay, no spam!";
 *        }
 *    }
 * </code>
 * 
 * @author Bret Kuhns {@link www.miphp.net}
 * @link http://www.miphp.net/blog/view/php4_akismet_class/
 * @version 0.3.3
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

define('AKISMET_SERVER_NOT_FOUND', 0);
define('AKISMET_RESPONSE_FAILED', 1);
define('AKISMET_INVALID_KEY', 2);

/**
 * Base class to assist in error handling between Akismet classes
 *
 * @author Bret Kuhns <@link www.miphp.net>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_akismet_object {

	/**
	 * @var mixed
	 */
	public $errors = array();

	/**
	 * Add a new error to the errors array in the object
	 *
	 * @param string $name A name (array key) for the error
	 * @param string $message The error message
	 * @return void
	 */
	public function setError($name, $message) {
		$this->errors[$name] = $message;
	}

	/**
	 * Return a specific error message from the errors array
	 *
	 * @param string $name The name of the error you want
	 * @return mixed Returns a String if the error exists,
	 *               a false boolean if it does not exist
	 */
	public function getError($name) {
		if ($this->isError($name)) {
			return $this->errors[$name];
		}
		return FALSE;
	}

	/**
	 * Return all errors in the object
	 *
	 * @return mixed
	 */
	public function getErrors() {
		return (array)$this->errors;
	}

	/**
	 * Check if a certain error exists
	 *
	 * @return boolean
	 */
	public function isError() {
		return isset($this->errors[$name]);
	}

	/**
	 * Check if any errors exist
	 *
	 * @return boolean
	 */
	public function errorsExist() {
		return (count($this->errors) > 0);
	}
}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/System/class.tx_wtspamshield_akismet_object.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/System/class.tx_wtspamshield_akismet_object.php']);
}

?>