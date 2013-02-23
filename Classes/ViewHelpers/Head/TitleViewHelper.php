<?php
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
    public function render($title = '') {
        if (empty($title)) {
            $title = $this->renderChildren();
        }

        $GLOBALS['TSFE']->page['title'] = $title;
        $GLOBALS['TSFE']->indexedDocTitle = $title;

        return "";
    }
}
