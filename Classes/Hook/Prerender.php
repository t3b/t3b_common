<?php
/**
 * @author Anno v. Heimburg <avonheimburg@agenturwerft.de>, Agenturwerft GmbH
 *
 * PreRender-Hook for css and js resource service
 */
namespace T3b\T3bCommon\Hook;

class PreRender
{
    /**
     * @var \T3b\T3bCommon\Service\Resource
     */
    protected $resourceService;

    public function __construct()
    {
        /** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManagerInterface */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\ObjectManagerInterface');
        $this->resourceService = $objectManager->get('\T3b\T3bCommon\Service\Resource');
    }

    public function preRender($parameters, \TYPO3\CMS\Core\Page\PageRenderer $renderer)
    {
        foreach ($this->resourceService->getCssFiles() as $cd) {
            /** @var \T3b\T3bCommon\Service\CssDescriptor  $cd */
            $renderer->addCssFile($cd->file, 'stylesheet', $cd->media);
        }

        foreach ($this->resourceService->getJsLibrariesHeader() as $name => $lib) {
            $renderer->addJsLibrary($name, $lib->uri);
        }

        foreach ($this->resourceService->getJsLibrariesFooter() as $name => $lib) {
            $renderer->addJsFooterLibrary($name, $lib->uri);
        }

        foreach ($this->resourceService->getJsFilesHeader() as $name => $lib) {
            $renderer->addJsFile($lib->uri);
        }

        foreach ($this->resourceService->getJsFilesFooter() as $name => $lib) {
            $renderer->addJsFooterFile($lib->uri);
        }
    }
}
