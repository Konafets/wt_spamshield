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
 * The controlling class. This is the ONLY class the user should instantiate in
 * order to use the Akismet service!
 *
 * @author Bret Kuhns <@link www.miphp.net>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_akismet extends tx_wtspamshield_akismet_object {
	/**
	 * @var integer
	 */
	public $apiPort = 80;

	/**
	 * @var string
	 */
	public $akismetServer = 'rest.akismet.com';

	/**
	 * @var string
	 */
	public $akismetVersion = '1.1';

	/**
	 * @var tx_wtspamshield_akismet_httpclient
	 */
	public $http;

	/**
	 * @var mixed
	 */
	public $ignore = array(
			'HTTP_COOKIE',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED_HOST',
			'HTTP_MAX_FORWARDS',
			'HTTP_X_FORWARDED_SERVER',
			'REDIRECT_STATUS',
			'SERVER_PORT',
			'PATH',
			'DOCUMENT_ROOT',
			'SERVER_ADMIN',
			'QUERY_STRING',
			'PHP_SELF',
			'argv'
		);

	/**
	 * @var string
	 */
	public $blogUrl = '';

	/**
	 * @var string
	 */
	public $apiKey  = '';

	/**
	 * @var mixed
	 */
	public $comment = array();

	/**
	 * Constructor
	 * 
	 * Set instance variables, connect to Akismet, and check API key
	 * 
	 * @param string $blogUrl The URL to your own blog
	 * @param string $apiKey Your wordpress API key
	 * @param mixed $comment A formatted comment array to be
	 *                       examined by the Akismet service
	 * @return void
	 */
	public function __construct($blogUrl, $apiKey, $comment) {

		$this->blogUrl = $blogUrl;
		$this->apiKey  = $apiKey;

		$this->urls = array (
			'verify' => $this->akismetServer . '/'
						. $this->akismetVersion
						. '/verify-key',

			'commentCheck' => $this->apiKey . '.'
							. $this->akismetServer . '/'
							. $this->akismetVersion
							. '/comment-check',

			'submitSpam' => $this->apiKey . '.' 
							. $this->akismetServer . '/'
							. $this->akismetVersion
							. '/submit-spam',

			'submitHam' => $this->apiKey . '.'
							. $this->akismetServer . '/'
							. $this->akismetVersion
							. '/submit-ham'
		);

			// Populate the comment array with information needed by Akismet
		$this->comment = $comment;
		$this->formatCommentArray();

		if (!isset($this->comment['user_ip'])) {
			$this->comment['user_ip'] = ($_SERVER['REMOTE_ADDR'] != getenv('SERVER_ADDR'))
				? $_SERVER['REMOTE_ADDR']
				: getenv('HTTP_X_FORWARDED_FOR');
		}

		if (!isset($this->comment['user_agent'])) {
			$this->comment['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		}

		if (!isset($this->comment['referrer'])) {
			$this->comment['referrer'] = $_SERVER['HTTP_REFERER'];
		}
		$this->comment['blog'] = $blogUrl;

			// Connect to the Akismet server and populate errors if they exist
		$this->http = new tx_wtspamshield_akismet_httpclient();
		if ($this->http->errorsExist()) {
			$this->errors = array_merge($this->errors, $this->http->getErrors());
		}

			// Check if the API key is valid
		if (!$this->isValidApiKey()) {
			$this->setError(AKISMET_INVALID_KEY, 'Your Akismet API key is not valid.');
		}
	}

	/**
	 * Query the Akismet and determine if the comment is spam or not
	 * 
	 * @return boolean
	 */
	public function isSpam() {
		$response = $this->http->getResponse($this->getQueryString(), $this->urls['commentCheck']);
		return ($response == 'true');
	}

	/**
	 * Submit this comment as an unchecked spam to the Akismet server
	 * 
	 * @return void
	 */
	public function submitSpam() {
		$this->http->getResponse($this->getQueryString(), $this->urls['submitSpam']);
	}

	/**
	 * Submit a false-positive comment as "ham" to the Akismet server
	 *
	 * @return void
	 */
	public function submitHam() {
		$this->http->getResponse($this->getQueryString(), $this->urls['submitHam']);
	}

	/**
	 * Check with the Akismet server to determine if the API key is valid
	 *
	 * @return boolean
	 */
	protected function isValidApiKey() {
		$keyCheck = $this->http->getResponse('key=' . $this->apiKey . '&blog=' . $this->blogUrl, $this->urls['verify']);
		return ($keyCheck == 'valid');
	}

	/**
	 * Format the comment array in accordance to the Akismet API
	 *
	 * @return void
	 */
	protected function formatCommentArray() {
		$format = array(
				'type' => 'comment_type',
				'author' => 'comment_author',
				'email' => 'comment_author_email',
				'website' => 'comment_author_url',
				'body' => 'comment_content'
			);

		foreach ($format as $short => $long) {
			if (isset($this->comment[$short])) {
				$this->comment[$long] = $this->comment[$short];
				unset($this->comment[$short]);
			}
		}
	}

	/**
	 * Build a query string for use with HTTP requests
	 *
	 * @return string
	 */
	protected function getQueryString() {
		foreach ($_SERVER as $key => $value) {
			if (!in_array($key, $this->ignore)) {
				if ($key == 'REMOTE_ADDR') {
					$this->comment[$key] = $this->comment['user_ip'];
				} else {
					$this->comment[$key] = $value;
				}
			}
		}

		$queryString = '';

		foreach ($this->comment as $key => $data) {
			$queryString .= $key . '=' . urlencode(stripslashes($data)) . '&';
		}

		return $queryString;
	}

}

if (defined('TYPO3_MODE')
	&& isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/System/class.tx_wtspamshield_akismet.php'])
) {
	require_once ($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/wt_spamshield/Classes/System/class.tx_wtspamshield_akismet.php']);
}

?>