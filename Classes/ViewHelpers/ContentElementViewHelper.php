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

namespace T3b\T3bCommon\ViewHelpers;

/**
 * @author Anno v. Heimburg <anno@vonheimburg.de>
 *
 * Renders the content element given by the uid
 *
 * Example:
 * <t3b:contentElement uids="93" />
 * <t3b:contentElement uids="93,8,77" />
 */
class ContentElementViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper
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
     * @param string $uids comma-seperated list of content elements to render
     * @return string rendered content element
     */
    public function render($uids) {
        $cObject = $this->configurationManager->getContentObject();

        $recordConfig = array(
            'tables' => 'tt_content',
            'source' => $uids,
        );

        $html = $cObject->RECORDS($recordConfig);
        return $html;
    }


}
