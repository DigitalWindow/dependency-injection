<?php
namespace AwinTest\DependencyInjection;

use AwinTest\DependencyInjection\TestCase;
use AwinTest\DependencyInjection\Fixtures\ObjectConstructorParams\Simple as ClassWithSubdependencies;

class ObjectSubdependencyTest extends TestCase
{
    public function testGettingDependencyWithObjectSubdependencies()
    {
        $result = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\ObjectConstructorParams\Simple'); /* @var $result ClassWithSubdependencies*/

        $this->assertInstanceOf('\AwinTest\DependencyInjection\Fixtures\ObjectConstructorParams\Simple', $result);
        $this->assertInstanceOf('\AwinTest\DependencyInjection\Fixtures\Basic\NoConstructor',            $result->param1);
    }
}