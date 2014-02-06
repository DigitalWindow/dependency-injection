<?php
namespace AwinTest\DependencyInjection;

use AwinTest\DependencyInjection\TestCase;
use AwinTest\DependencyInjection\Fixtures\AbstractClassTypeHinting\AbstractClassInConstructorParamTypeHints;

class AbstractClassTypeHintingTest extends TestCase
{
    public function testCanGetDependencyWithAbstractClassInConstructorTypeHints()
    {
        // ARRANGE
        $dependencyClassname    = '\AwinTest\DependencyInjection\Fixtures\AbstractClassTypeHinting\AbstractClassInConstructorParamTypeHints';
        $subdependencyClassname = '\AwinTest\DependencyInjection\Fixtures\AbstractClassTypeHinting\Child2';

        $this->injector->configureDependencyParamClass($dependencyClassname, 'param1', $subdependencyClassname);

        // ACT
        $result = $this->injector->get($dependencyClassname); /* @var $result AbstractClassInConstructorParamTypeHints */

        // ASSERT
        $this->assertInstanceOf($dependencyClassname,    $result);
        $this->assertInstanceOf($subdependencyClassname, $result->param);
    }

    /**
     * @expectedException \Awin\DependencyInjection\Exception\BadDiSubclassConfigurationException
     */
    public function testCannotSaveInvalidSubdependencyClass()
    {
        // ARRANGE
        $dependencyClassname       = '\AwinTest\DependencyInjection\Fixtures\AbstractClassTypeHinting\AbstractClassInConstructorParamTypeHints';
        $badSubdependencyClassname = '\AwinTest\DependencyInjection\Fixtures\AbstractClassTypeHinting\NotAChild';
        $this->injector->configureDependencyParamClass($dependencyClassname, 'param1', $badSubdependencyClassname);

        // ACT
        $this->injector->get($dependencyClassname);
    }
}
