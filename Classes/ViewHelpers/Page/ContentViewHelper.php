<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anno v. Heimburg <anno@vonheimburg.de>
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace T3b\T3bCommon\ViewHelpers\Page;

/**
 * @author Anno v. Heimburg <anno@vonheimurg.de>
 *
 * Renders the column from the current page.
 *
 * See tsref for slide and slide.collect options
 *
 * Usage example:
 *
 * <t3b:page.content />
 * Renders column 0
 *
 * <t3b:page.content column="3" />
 * Renders column 3
 *
 * Does not take any body
 */
class ContentViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper
{
    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @return void
     */
    public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Render the column with the given number
     * @param int $column column to render
     * @param int $slide slide mode, see tsref
     * @param int $slideCollect slide.collect (see tsref, overrides and sets slide mode to -1)
     * @param boolean $slideCollectFuzzy slide.collectFuzzy (see tsref, only works with collect)
     * @param boolean $slideCollectReverse slide.collectRevers (see tsref, only works with collect)
     * @return string rendered html
     */
    public function render($column = 0, $slide = 0, $slideCollect = 0, $slideCollectFuzzy = FALSE, $slideCollectReverse = FALSE) {
        $colPos = intval($column);
        $cObject = $this->configurationManager->getContentObject();

        $selectConfig = array();
        $selectConfig['where'] = " colPos = $colPos";

        $contentConfig = array(
            'select.' => $selectConfig,
            'table' => 'tt_content'
        );

        if ($slideCollect !== 0) {
            $slide = -1;
            $slideConfig = array();

            $slideConfig['collect'] = $slideCollect;
            $slideConfig['collectFuzzy'] = $slideCollectFuzzy;
            $slideConfig['collectReverse'] = $slideCollectReverse;

            $contentConfig['slide.'] = $slideConfig;
        }

        if ($slide !== 0) {
            $contentConfig['slide'] = $slide;
        }

        $html = $cObject->CONTENT($contentConfig);

        return $html;
    }

}