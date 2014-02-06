<?php
namespace AwinTest\DependencyInjection;

use AwinTest\DependencyInjection\TestCase;

class GettingDependenciesInSingletonLikeWayTest extends TestCase
{
    public function testGetSameObjectTwice()
    {
        $dependency1 = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\Basic\NoConstructor');
        $dependency2 = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\Basic\NoConstructor');
        $this->assertSame($dependency1, $dependency2);
    }

    public function testCanGetDifferentObject()
    {
        $dependency1 = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\Basic\NoConstructor');
        $dependency2 = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\Basic\NoConstructor', true);
        $this->assertNotSame($dependency1, $dependency2);
    }
}
