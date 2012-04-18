<?php
require_once 'PHP/PMD/AbstractRule.php';
require_once 'PHP/PMD/Rule/IClassAware.php';

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
