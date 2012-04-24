<?php
require_once 'PHP/PMD/AbstractRule.php';
require_once 'PHP/PMD/Rule/IClassAware.php';

/**
 * Checks that a class composed of only static methods has private
 *   __construct() method defined.
 *
 * @copyright Copyright (c) 2012 bne1.
 * @author Andrew Udvare [au] <andrew@bne1.com>
 * @license http://www.opensource.org/licenses/mit-license.php
 *
 * @package Sutra
 * @link http://www.sutralib.com/
 *
 * @version 1.0
 */
class PHP_PMD_Rule_StaticClassPrivateConstructor extends PHP_PMD_AbstractRule
  implements PHP_PMD_Rule_IClassAware {
  /**
   * This method checks that if the class is composed of all static methods,
   *   the class has a private __construct() method defined.
   *
   * @param PHP_PMD_AbstractNode $class The context source code node.
   * @return void
   */
  public function apply(PHP_PMD_AbstractNode $class) {
    if (!$this->_determineIfStatic($class)) {
      return;
    }

    $methods = $class->getMethods();
    $has_construct = FALSE;
    $construct = NULL;

    foreach ($methods as $method) {
      if (strcasecmp($method->getImage(), '__construct') === 0) {
        $has_construct = TRUE;
        $construct = $method;
        break;
      }
    }

    if (($has_construct && !$construct->isPrivate()) || !$has_construct) {
      $this->addViolation($class, array($class->getImage()));
    }
  }

  /**
   * Determines if the class is a static class simply by checking that all
   *   methods are static.
   *
   * @param PHP_PMD_Node_Class $class The class context source node.
   * @return boolean If the class has only static methods.
   */
  private function _determineIfStatic(PHP_PMD_Node_Class $class) {
    $ret = TRUE;

    foreach ($class->getMethods() as $method) {
      if (strcasecmp($method->getImage(), '__construct') === 0) {
        if (!$method->isPrivate()) {
          $ret = FALSE;
          break;
        }
      }

      if (!$method->isStatic()) {
        $ret = FALSE;
        break;
      }
    }

    return $ret;
  }
}

/**
 * Copyright (c) 2012 Andrew Udvare <andrew@bne1.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */
