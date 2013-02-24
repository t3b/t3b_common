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

namespace T3b\T3bCommon\ViewHelpers\Head;

/**
 * @author Anno v. Heimburg <anno@vonheimburg.de>
 *
 * Adds a link-tag to the current page header
 */


class LinkViewHelper extends HeaderViewHelper
{

    /**
     * Adds a link tag, with the various attributes set as specified
     *
     * @param string $rel Required. Specifies the relationship between the current document and the linked document
     * @param string $href Required. Specifies the location of the linked document
     * @param string $hreflang Specifies the language of the text in the linked document
     * @param string $media Specifies on what device the linked document will be displayed
     * @param string $sizes Specifies the size of the linked resource. Only for rel="icon"
     * @param string $type Specifies the MIME type of the linked document
     * @return void
     */
    public function render($rel, $href, $hreflang = '', $media = '', $sizes = '', $type = '') {
        $attributes = array();
        $attributes['rel'] = $rel;
        $attributes['href'] = $href;

        if($hreflang) {
            $attributes['hreflang'] = $hreflang;
        }

        if($media) {
            $attributes['media'] = $media;
        }

        if($sizes){
           $attributes['sizes'] = $sizes;
        }

        if($type) {
            $attributes['type'] = $type;
        }

        $tagAttributes = '';

        foreach($attributes as $attribute => $value) {
            $tagAttributes .= " $attribute=\"$value\"";
        }

        $linkTag = "<link" . $tagAttributes . " >";

        $this->addPageHeader($linkTag, md5($rel . ':' . $href ));

    }
}
