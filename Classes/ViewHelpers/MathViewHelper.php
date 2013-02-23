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
 * Evaluates a simple mathematical expression.
 *
 * Usage:
 *
 * <t3b:math>5+7</t3b:math>
 * Output: 12
 *
 * <t3b:math expression="7 * 6" />
 * Output: 42
 *
 * @see \T3b\T3bCommon\Utility\EvalMath
 */

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
            $m = new \T3b\T3bCommon\Utility\EvalMath();
            $m->suppress_errors = TRUE;
            $result = $m->evaluate($expression);
        }

        return $result;
    }
}
