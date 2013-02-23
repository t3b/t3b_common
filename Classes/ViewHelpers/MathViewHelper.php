<?php

/**
 * @author Anno v. Heimburg <anno@vonheimburg.de>
 *
 *
 */
namespace T3b\Common\ViewHelpers;

class MathViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\BaseViewHelper
{
    /**
     * Evaluates a mathematical expression
     * @param string $expression expression to evaluate
     * @return string evaluated expression
     */
    public function render($expression = '')
    {
        if (empty($expression)) {
            $expression = $this->renderChildren();
        }

        $expression = trim($expression);
        $result = '';

        if (strlen($expression) > 0) {
            $m = new \T3b\Common\Utility\EvalMath();
            $m->suppress_errors = TRUE;
            $result = $m->evaluate($expression);
        }

        return $result;
    }
}
