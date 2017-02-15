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
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;

/**
 * log
 *
 * @author Ralf Zimmermann <ralf.zimmermann@tritum.de>
 * @package tritum
 * @subpackage wt_spamshield
 */
class tx_wtspamshield_log extends AbstractPlugin
{

    /**
     * @var string
     */
    public $extKey = 'wt_spamshield';

    /**
     * @var integer
     */
    public $dbInsert = true;

    /**
     * Function dbLog to write a log into the database if spam was recognized
     *
     * @param string $ext Name of extension in which the spam was recognized
     * @param integer $points
     * @param string $errorMessages Error Message
     * @param array $formArray Array with submitted values
     * @return string
     */
    public function dbLog($ext, $points, $errorMessages, $formArray)
    {
        $div = GeneralUtility::makeInstance('tx_wtspamshield_div');
        $tsConf = $div->getTsConf();

        if ($this->dbInsert) {
            if ($tsConf['logging.']['pid'] == -1) {
                return false;
            }

            if ($tsConf['logging.']['pid'] == -2) {
                $tsConf['logging.']['pid'] = $GLOBALS['TSFE']->id;
            }

            $title = date('d.m.Y H:i:s', time()) . ' - ' .
                $ext . ' - pid: ' . $GLOBALS['TSFE']->id .
                ' - Score: ' . $points;

            $errorMessage = 'Score: ' . $points;

            $dbValues =  [
                'pid' => intval($tsConf['logging.']['pid']),
                'tstamp' => time(),
                'crdate' => time(),
                'title' => $title,
                'form' => $ext,
                'errormsg' => $errorMessage,
                'pageid' => $GLOBALS['TSFE']->id,
                'ip' => GeneralUtility::getIndpEnv('REMOTE_ADDR'),
                'useragent' => GeneralUtility::getIndpEnv('HTTP_USER_AGENT')
            ];

            $dbValues += [
                'formvalues' => DebugUtility::viewArray($formArray) . DebugUtility::viewArray($errorMessages)
            ];

            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_wtspamshield_log', $dbValues);
        }
        return '';
    }
}