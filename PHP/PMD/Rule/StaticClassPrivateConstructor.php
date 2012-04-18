<?php
require_once 'PHP/PMD/AbstractRule.php';
require_once 'PHP/PMD/Rule/IClassAware.php';

class PHP_PMD_Rule_StaticClassPrivateConstructor
  extends PHP_PMD_AbstractRule
  implements PHP_PMD_Rule_IClassAware {
  /**
   * This method checks that all private class methods are at least accessed
   * by one method.
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
      $this->addViolation($method, array($class->getImage()));
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
        continue;
      }

      if (!$method->isStatic()) {
        $ret = FALSE;
        break;
      }
    }

    return $ret;
  }
}
