<?php
require_once 'PHP/PMD/AbstractRule.php';
require_once 'PHP/PMD/Rule/IClassAware.php';

/**
 * Checks that a class' public static methods all have a constant with the same
 *   name and the correct callback string. This allows for nicer looking
 *   callbacks with methods like call_user_func().
 *
 * Example of ugliness:
 * call_user_func('someClass::staticMethod')
 *
 * With the constant defined:
 * call_user_func(someClass::staticMethod)
 *
 * Most IDEs will auto-complete a constant, but almost none (if not none) will
 *   auto-complete a callback string for it is treated simply as a string
 *   regardless of context.
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
class PHP_PMD_Rule_StaticMethodConstants
  extends PHP_PMD_AbstractRule
  implements PHP_PMD_Rule_IClassAware {
  /**
   * This method checks that all public static methods have a constant defined
   *   within the class of the callback string.
   *
   * @param PHP_PMD_AbstractNode $class The context source code node.
   * @return void
   */
  public function apply(PHP_PMD_AbstractNode $class) {
    $methods = $class->getMethods();
    $constants = $class->getConstants();
    $class_name = $class->getImage();

    foreach ($methods as $method) {
      if ($method->isStatic()) {
        $name = $method->getImage();
        $want = $class_name.'::'.$name;

        if (!isset($constants[$name]) || $constants[$name] !== $want) {
          $this->addViolation($method, array($name, $want));
        }
      }
    }
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
