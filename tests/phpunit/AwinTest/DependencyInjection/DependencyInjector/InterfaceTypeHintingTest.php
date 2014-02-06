<?php
namespace AwinTest\DependencyInjection;

use AwinTest\DependencyInjection\TestCase;
use AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting\InterfaceInConstructorParamTypeHints;

class InterfaceTypeHintingTest extends TestCase
{
    public function testCanGetDependencyWithInterfaceInConstructorTypeHints()
    {
        // ARRANGE
        $dependencyClassname    = '\AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting\InterfaceInConstructorParamTypeHints';
        $subdependencyClassname = '\AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting\Implementation2';

        $this->injector->configureDependencyParamClass($dependencyClassname, 'param1', $subdependencyClassname);

        // ACT
        $result = $this->injector->get($dependencyClassname); /* @var $result InterfaceInConstructorParamTypeHints */

        // ASSERT
        $this->assertInstanceOf($dependencyClassname,    $result);
        $this->assertInstanceOf($subdependencyClassname, $result->param);
    }

    /**
     * @expectedException \Awin\DependencyInjection\Exception\BadDiInterfaceConfigurationException
     */
    public function testCannotSaveInvalidSubdependencyClass()
    {
        // ARRANGE
        $dependencyClassname       = '\AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting\InterfaceInConstructorParamTypeHints';
        $badSubdependencyClassname = '\AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting\DoesntImplementAnything';
        $this->injector->configureDependencyParamClass($dependencyClassname, 'param1', $badSubdependencyClassname);

        // ACT
        $this->injector->get($dependencyClassname);
    }
}
