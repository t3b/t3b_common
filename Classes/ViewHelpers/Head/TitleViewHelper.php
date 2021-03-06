<?php

namespace T3b\T3bCommon\ViewHelpers\Head;

/**
 * @author Anno v. Heimburg <anno@vonheimburg.de>
 *
 * Sets the page title to its title attribute or its content
 *
 * <t3b:head.title title="foo" />
 * <t3b:head.title>foo</t3b:head.title>
 */
class TitleViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper
{
    /**
     * Change the title of the current page
     * @param string $title the page title
     * @return string
     */
    public function render($title = '') {
        if (empty($title)) {
            $title = $this->renderChildren();
        }

        $GLOBALS['TSFE']->page['title'] = $title;
        $GLOBALS['TSFE']->indexedDocTitle = $title;

        return "";
    }
}
