<?php
/* * *****************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Anno v. Heimburg <avonheimburg@agenturwerft.de>, Agenturwerft
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as
 *  published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
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
 * **************************************************************** */

namespace T3b\T3bCommon\ViewHelpers\Resource;
/**
 * Adds a JS file to the header of the page
 *
 * Usage:
 *
 * <t3b:resource.js  src="EXT:my_ext/Resources/Public/Javascript/myfile.js" addToHeader="TRUE" />
 *
 * addToHeader is optional, defaults to TRUE
 * file can be a path in the typo3 site, optionally prefixed with EXT:, or a URI. URIs may begin with http://, https://,
 * or a double-slash (//)
 */
class JsViewHelper extends AbstractResourceViewHelper {

    /**
     * Add JS file to the header
     * @param string $src
     * @param bool $addToHeader
     * @return string
     */
    public function render($src, $addToHeader = TRUE) {
        $this->resourceService->addJs($src, $addToHeader);
        return '';
    }
}

?>
