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
 * Used by the Akismet class to communicate with the Akismet service
 *
 * @author Bret Kuhns <@link www.miphp.net>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_akismet_httpclient extends tx_wtspamshield_akismet_object {
	/**
	 * @var string
	 */
	public $akismetVersion = '1.1';

	/**
	 * @var mixed
	 */
	public $con;

	/**
	 * @var string
	 */
	public $host;

	/**
	 * @var integer
	 */
	public $port;

	/**
	 * @var string
	 */
	public $apiKey;

	/**
	 * @var string
	 */
	public $blogUrl;

	/**
	 * @var mixed
	 */
	public $errors = array();

	/**
	 * Constructor
	 *
	 * @param integer $port
	 * @return void
	 */
	public function __construct($port = 80) {
		$this->port = $port;
	}

	/**
	 * Use the connection active in $con to get a response from the
	 * server and return that response
	 *
	 * @param mixed $request
	 * @param string $url
	 * @param string $type
	 * @return mixed
	 */
	public function getResponse($request, $url) {
		$this->connect();

		if ($this->con && !$this->isError(AKISMET_SERVER_NOT_FOUND)) {
			curl_setopt($this->con, CURLOPT_URL, $url);
			curl_setopt($this->con, CURLOPT_POSTFIELDS, $request);

			if(!$response = curl_exec($this->con)) {
				$this->setError(AKISMET_RESPONSE_FAILED, 'The response could not be retrieved.');
				return;
			}

			$this->disconnect();
			return $response;
		}
	}

    /**
     * Initializes a new cURL session/handle
     *
     * @return	boolean
    */
    public function connect() {
		if (!is_resource($this->con)) {
			if(!$this->con = curl_init()) {
			   $this->setError(AKISMET_SERVER_NOT_FOUND, 'Could not connect to akismet server.');
			   return;
			}
		}

		curl_setopt($this->con, CURLOPT_HEADER, 0);
		curl_setopt($this->con, CURLOPT_POST, 1);
		curl_setopt($this->con, CURLOPT_TIMEOUT, 0); 
		curl_setopt($this->con, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->con, CURLOPT_USERAGENT, 
					"Akismet PHP4 Class");
		curl_setopt($this->con, CURLOPT_FRESH_CONNECT, 1);

		if ($this->port != 80) {
			curl_setopt($this->con, CURLOPT_PORT, $this->port);
		}

		return true;
    }

	/**
	 * Close the connection to the Akismet server
	 *
	 * @return void
	 */
	public function disconnect() {
		if (is_resource($this->con)) {
			if (!curl_close($this->con)) {
				$this->setError(AKISMET_SERVER_NOT_FOUND, 'Could not close the CURL instance');
				return;
			}
		}

		return true;
	}
}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/System/class.tx_wtspamshield_akismet_httpclient.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/System/class.tx_wtspamshield_akismet_httpclient.php']);
}

?>