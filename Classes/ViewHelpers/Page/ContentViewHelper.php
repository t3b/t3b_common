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
 * Does not take any body.
 *
 * Also supports slide-options, documentation copied from tsref:
 *
 * <dl>
 *
 * <dt>slide</dt>
 * <dd>If set and no content element is found by the select command, then the rootLine will be traversed back until some content is found.
 *  Possible values are "-1" (slide back up to the siteroot), "1" (only the current level) and "2" (up from one level back). Use -1 in combination with collect.
 * </dd>
 *
 * <dt>slideCollect</dt>
 * <dd> If set, all content elements found on current and parent pages will be collected. Otherwise, the sliding would stop after the first hit. Set this value to the amount of levels to collect on, or use "-1" to collect up to the siteroot.</dd>
 *
 * <dt>slideCollectFuzzy</dt>
 * <dd>Only useful in collect mode. If no content elements have been found for the specified depth in collect mode, traverse further until at least one match has occurred.</dd>
 *
 * <dt>slideCollectReverse</dt>
 * <dd>Change order of elements in collect mode. If set, elements of the current page will be at the bottom.</dd>
 * </dl>
 */
class ContentViewHelper extends \T3b\T3bCommon\ViewHelpers\BaseViewHelper
{
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
