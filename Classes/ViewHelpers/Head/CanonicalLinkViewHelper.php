<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thorsten Boock <t.boock@exinit.de>, Exinit GmbH & Co. KG
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

namespace T3b\T3bCommon\ViewHelpers\Head;

/**
 * Sets a canonical-link-tag in the page's head.
 *
 * Uses the current page as default. If you want additional parameters in the canonical link (such as
 * for a news detail view), add those parameters to the protectedParameters-option
 *
 * Usage: <t3b:pageRenderer.canonical protectedParameters="{0: 'tx_news[news]'}" />
 *
 * @package T3bCommon
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CanonicalLinkViewHelper extends HeaderViewHelper
{

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $contentObject;

    /* =============================================
        PUBLIC METHODS
       ============================================= */

    /**
     * @return void
     */
    public function initializeObject()
    {
        $this->contentObject = $this->configurationManager->getContentObject();
    }

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('protectedParameters', 'array', 'Arguments not to remove from the URI', FALSE, 'stylesheet');
    }

    /**
     * @return void
     * @todo remove the str_replace workaround if there's another way to achieve this
     */
    public function render()
    {
        $url = $this->contentObject->typoLink_URL($this->buildTypolinkConfiguration());
        // at least in typo3 4.6, typoLink_URL returns a string which indeed has been URL-encoded but still contains '&' instead of '&amp;'
        if (strpos($url, '&amp;') === FALSE) {
            $url = str_replace('&', '&amp;', $url);
        }
        $linkTag = '<link rel="canonical" href="' . $url . '"/>';
        $this->addPageHeader($linkTag, get_class($this));
    }

    /* =============================================
        PROTECTED METHODS
       ============================================= */

    /**
     * @return array
     */
    protected function buildTypolinkConfiguration()
    {
        $typolinkConfiguration = array(
            'parameter' => $GLOBALS['TSFE']->id,
            'forceAbsoluteUrl' => TRUE,
        );
        if (isset($this->arguments['protectedParameters']) && is_array($this->arguments['protectedParameters'])) {
            $typolinkConfiguration['additionalParams'] = self::buildParameterString($this->arguments['protectedParameters']);
        }
        return $typolinkConfiguration;
    }

    /**
     * @param array $protectedParameters
     * @return string
     */
    protected static function buildParameterString(array $protectedParameters)
    {
        $parameterString = '';
        foreach ($protectedParameters as $protectedParameter) {
            $protectedParameterValue = self::getSingleParameterValue($protectedParameter);
            if ($protectedParameterValue !== NULL) {
                $parameterString .= '&' . $protectedParameter . '=' . $protectedParameterValue;
            }
        }
        return $parameterString;
    }

    /**
     * @param $parameterName
     * @return mixed|NULL
     */
    protected static function getSingleParameterValue($parameterName)
    {
        $parameterValue = NULL;
        $bracePosition = strpos($parameterName, '[');
        if ($bracePosition === FALSE) {
            $parameterValue = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP($parameterName);
        } else {
            $namespace = substr($parameterName, 0, $bracePosition);
            $pluginParameters = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP($namespace);
            if ($pluginParameters) {
                $regExp = '/\[([A-Za-z1-9]+)\]/';
                preg_match_all($regExp, $parameterName, $arrayIndexesFound);
                // multi dimensional array
                if (is_array($arrayIndexesFound[1])) {
                    $tempValue = NULL;
                    $tempParameters = $pluginParameters;
                    $oldIndex = $arrayIndexesFound[1][0];
                    if (is_array($tempParameters[$oldIndex])) {
                        for ($i = 1; $i < count($arrayIndexesFound[1]); $i++) {
                            $arrayIndex = $arrayIndexesFound[1][$i];
                            $tempParameters = $tempParameters[$oldIndex];
                            $tempValue = $tempParameters[$arrayIndex];
                            $oldIndex = $arrayIndex;
                        }
                    } else {
                        $tempValue = $tempParameters[$oldIndex];
                    }
                    $parameterValue = $tempValue;
                }
            }
        }
        return $parameterValue;
    }

}