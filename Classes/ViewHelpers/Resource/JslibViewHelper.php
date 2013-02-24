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
 * Adds a JS library to the header of the page, prevents multiple
 * loading of the same JS library and prevents library version conflicts
 *
 * See Tx_AwPluginBase_Service_Resource for supported library names
 *
 * Usage:
 *
 * <t3b:resource.jslib name="jquery" version="1.7" addToHeader="0" />
 *
 */
class JslibViewHelper extends AbstractResourceViewHelper {

    /**
     * Add a Javascript library
     *
     * @param string $name A JS library name understood by the Resource service
     * @param string $version The desired version
     * @param bool $addToHeader Add the library to the header (TRUE) or the end of the document (FALSE), defaults to TRUE
     * @return string
     */
    public function render($name, $version, $addToHeader = TRUE) {
        $name = $this->arguments['name'];
        $version = $this->arguments['version'];

        $this->resourceService->addJsLibrary($name, $version, $this->arguments['addToHeader']);

        return '';
    }
}

?>
