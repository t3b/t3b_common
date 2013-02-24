<?php
namespace T3b\T3bCommon\ViewHelpers\Head;
/**
 * @author Anno v. Heimburg <avonheimburg@agenturwerft.de>, Agenturwerft GmbH
 *
 * Base for adding header data
 */
abstract class HeaderViewHelper extends \T3b\T3bCommon\ViewHelpers\BaseViewHelper
{
    /**
     * Add header data regardless of whether we are in cached or non-cached context
     *
     * @param string $value header data to add
     * @param string $name optional name to identify the header, allows overwriting when in non-cached context
     */
    protected function addPageHeader($value, $name = '') {
        if (empty($name)) {
            $name = md5($value);
        }

        /**
         * @var $tsfe \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
         */
        $tsfe = $GLOBALS['TSFE'];

        $tsfe->additionalHeaderData[$name] = $value;
    }
}
