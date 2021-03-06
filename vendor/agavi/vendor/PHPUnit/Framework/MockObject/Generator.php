<?php
/**
 * PHPUnit
 *
 * Copyright (c) 2002-2008, Sebastian Bergmann <sb@sebastian-bergmann.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Testing
 * @package    PHPUnit
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2002-2008 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id: Generator.php 4024 2008-11-13 12:21:44Z sb $
 * @link       http://www.phpunit.de/
 * @since      File available since Release 3.4.0
 */

require_once 'PHPUnit/Framework/MockObject/Matcher.php';
require_once 'PHPUnit/Framework/MockObject/Invocation.php';
require_once 'PHPUnit/Framework/MockObject/MockObject.php';
require_once 'PHPUnit/Util/Class.php';
require_once 'PHPUnit/Util/Filter.php';
require_once 'PHPUnit/Util/Template.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * Mock Object Code Generator
 *
 * @category   Testing
 * @package    PHPUnit
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2002-2008 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 3.4.0
 */
class PHPUnit_Framework_MockObject_Generator
{
    protected static $cache = array();

    public static function generate($originalClassName, array $methods = array(), $mockClassName = '', $callOriginalConstructor = TRUE, $callOriginalClone = TRUE, $callAutoload = TRUE)
    {
        if ($mockClassName == '') {
            $key = md5(
              $originalClassName .
              serialize($methods) .
              serialize($callOriginalConstructor) .
              serialize($callOriginalClone)
            );

            if (isset(self::$cache[$key])) {
                return self::$cache[$key];
            }
        }

        $mock = self::generateMock(
          $originalClassName,
          $methods,
          $mockClassName,
          $callOriginalConstructor,
          $callOriginalClone,
          $callAutoload
        );

        if (isset($key)) {
            self::$cache[$key] = $mock;
        }

        return $mock;
    }

    protected static function generateMock($originalClassName, array $methods, $mockClassName, $callOriginalConstructor, $callOriginalClone, $callAutoload)
    {
        $templateDir   = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Generator' . DIRECTORY_SEPARATOR;
        $classTemplate = new PHPUnit_Util_Template($templateDir . 'mocked_class.tpl');

        if (!$callOriginalClone) {
            $cloneTemplate = new PHPUnit_Util_Template($templateDir . 'mocked_clone.tpl');
        } else {
            $cloneTemplate = new PHPUnit_Util_Template($templateDir . 'unmocked_clone.tpl');
        }

        $mockClassName = self::generateMockClassName(
          $originalClassName, $mockClassName
        );

        if (class_exists($originalClassName, $callAutoload)) {
            $isClass     = TRUE;
            $isInterface = FALSE;
        } else {
            $isClass = FALSE;

            if (interface_exists($originalClassName, $callAutoload)) {
                $callOriginalConstructor = FALSE;
                $isInterface             = TRUE;
            }
        }

        if (!class_exists($mockClassName['fullClassName'], $callAutoload) &&
            !interface_exists($mockClassName['fullClassName'], $callAutoload)) {
            $prologue = 'class ' . $mockClassName['className'] . "\n{\n}\n\n";

            if (!empty($mockClassName['namespaceName'])) {
                $prologue = 'namespace ' . $mockClassName['namespaceName'] . ";\n\n" . $prologue;
            }
        }

        $class = new ReflectionClass($mockClassName['fullClassName']);

        if ($class->isFinal()) {
            throw new RuntimeException(
              sprintf(
                'Class "%s" is declared "final" and cannot be mocked.',
                $mockClassName['fullClassName']
              )
            );
        }

        if (is_array($methods) && empty($methods) && ($isClass || $isInterface)) {
            $methods = get_class_methods($originalClassName);
        }

        $mockedMethods = '';

        foreach ($methods as $methodName) {
            try {
                $method = $class->getMethod($methodName);

                if (self::canMockMethod($method)) {
                    $mockedMethods .= self::generateMockedMethodDefinitionFromExisting(
                      $templateDir, $method
                    );
                }
            }

            catch (ReflectionException $e) {
                $mockedMethods .= self::generateMockedMethodDefinition(
                  $templateDir, $class->getName(), $methodName
                );
            }
        }

        $classTemplate->setVar(
          array(
            'prologue'          => isset($prologue) ? $prologue : '',
            'class_declaration' => self::generateMockClassDeclaration(
                                     $class, $mockClassName
                                   ),
            'constructor'       => self::generateMockConstructor(
                                     $templateDir,
                                     $class,
                                     $mockClassName['mockClassName'],
                                     $callOriginalConstructor
                                   ),
            'clone'             => $cloneTemplate->render(),
            'mocked_methods'    => $mockedMethods
          )
        );

        return array(
          'code'          => $classTemplate->render(),
          'mockClassName' => $mockClassName['mockClassName']
        );
    }

    protected static function generateMockClassName($originalClassName, $mockClassName)
    {
        $classNameParts = explode('\\', $originalClassName);

        if (count($classNameParts) > 1) {
            $originalClassName = array_pop($classNameParts);
            $namespaceName     = join('\\', $classNameParts);
            $fullClassName     = $namespaceName . '\\' . $originalClassName;
        } else {
            $namespaceName = '';
            $fullClassName = $originalClassName;
        }

        if ($mockClassName == '') {
            do {
                $mockClassName = 'Mock_' . $originalClassName . '_' . substr(md5(microtime()), 0, 8);
            }
            while (class_exists($mockClassName, FALSE));
        }

        return array(
          'mockClassName' => $mockClassName,
          'className'     => $originalClassName,
          'fullClassName' => $fullClassName,
          'namespaceName' => $namespaceName
        );
    }

    protected static function generateMockClassDeclaration(ReflectionClass $class, array $mockClassName)
    {
        $buffer = 'class ';

        if ($class->isInterface()) {
            $buffer .= sprintf(
              "%s implements %s%s",
              $mockClassName['mockClassName'],
              !empty($mockClassName['namespaceName']) ? $mockClassName['namespaceName'] . '\\' : '',
              $mockClassName['className']
            );
        } else {
            $buffer .= sprintf(
              "%s extends %s%s",
              $mockClassName['mockClassName'],
              !empty($mockClassName['namespaceName']) ? $mockClassName['namespaceName'] . '\\' : '',
              $mockClassName['className']
            );
        }

        return $buffer;
    }

    protected static function generateMockConstructor($templateDir, ReflectionClass $class, $mockedClassName, $callOriginalConstructor)
    {
        $arguments              = '';
        $constructor            = $class->getConstructor();
        $constructorInInterface = FALSE;

        if ($constructor !== NULL && $callOriginalConstructor) {
            $template = new PHPUnit_Util_Template($templateDir . 'unmocked_constructor.tpl');
        } else {
            $template = new PHPUnit_Util_Template($templateDir . 'mocked_constructor.tpl');
        }

        if ($constructor !== NULL) {
            if (!$callOriginalConstructor) {
                $constructorName = $constructor->getName();

                foreach (PHPUnit_Util_Class::getHierarchy($class->getName(), TRUE) as $_class) {
                    foreach ($_class->getInterfaces() as $interface) {
                        if ($interface->hasMethod($constructorName)) {
                            $constructorInInterface = TRUE;
                            break 2;
                        }
                    }
                }
            }

            if ($callOriginalConstructor || $constructorInInterface) {
                $arguments = PHPUnit_Util_Class::getMethodParameters($constructor);
            }
        }

        $template->setVar(
          array(
            'arguments'         => $arguments,
            'mocked_class_name' => $mockedClassName
          )
        );

        return $template->render();
    }

    protected static function generateMockedMethodDefinitionFromExisting($templateDir, ReflectionMethod $method)
    {
        if ($method->isPrivate()) {
            $modifier = 'private';
        }

        else if ($method->isProtected()) {
            $modifier = 'protected';
        }

        else {
            $modifier = 'public';
        }

        if ($method->isStatic()) {
            $modifier .= ' static';
        }

        if ($method->returnsReference()) {
            $reference = '&';
        } else {
            $reference = '';
        }

        return self::generateMockedMethodDefinition(
          $templateDir,
          $method->getDeclaringClass()->getName(),
          $method->getName(),
          $modifier,
          PHPUnit_Util_Class::getMethodParameters($method),
          $reference
        );
    }

    protected static function generateMockedMethodDefinition($templateDir, $className, $methodName, $modifier = 'public', $arguments = '', $reference = '')
    {
        $template = new PHPUnit_Util_Template($templateDir . 'mocked_method.tpl');

        $template->setVar(
          array(
            'arguments'   => $arguments,
            'class_name'  => $className,
            'method_name' => $methodName,
            'modifier'    => $modifier,
            'reference'   => $reference
          )
        );

        return $template->render();
    }

    protected static function canMockMethod(ReflectionMethod $method)
    {
        $className  = $method->getDeclaringClass()->getName();
        $methodName = $method->getName();

        if ($method->isFinal() ||
            $methodName == '__construct' || $methodName == $className ||
            $methodName == '__destruct'  || $method->getName() == '__clone') {
            return FALSE;
        }

        return TRUE;
    }
}
?>
