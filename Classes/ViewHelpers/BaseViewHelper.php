<?php

namespace T3b\T3bCommon\ViewHelpers;

/**
 * @author Anno v. Heimburg <anno@vonheimburg.de>
 *
 * Base class for ViewHelpers
 *
 */
class BaseViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper
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
     * Check whether we are currently running cached
     *
     * @return boolean
     */
    protected function isCached()
    {
        $userObjType = $this->configurationManager->getContentObject()->getUserObjectType();
        return ($userObjType !== \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::OBJECTTYPE_USER_INT);
    }
}
