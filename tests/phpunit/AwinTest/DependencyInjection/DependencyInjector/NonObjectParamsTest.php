<?php
namespace AwinTest\DependencyInjection;

use AwinTest\DependencyInjection\TestCase;
use AwinTest\DependencyInjection\Fixtures\NonObjectConstructorParams\OptionalParams as FixtureWithOptionalParams;

class NonObjectParamsTest extends TestCase
{
    public function testCanGetDependencyWithNoConfiguration()
    {
        $result = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\NonObjectConstructorParams\OptionalParams'); /* @var $result FixtureWithOptionalParams*/

        $this->assertInstanceOf('\AwinTest\DependencyInjection\Fixtures\NonObjectConstructorParams\OptionalParams', $result);
        $this->assertEquals('default value defined in class', $result->param1);
        $this->assertEquals('default value defined in class', $result->param2);
    }

    public function testCanAddAnOptionalDependency()
    {
        $this->injector->configureDependencyParamValue(
            '\AwinTest\DependencyInjection\Fixtures\NonObjectConstructorParams\OptionalParams',
            'param2',
            'configured using injector'
        );

        $result = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\NonObjectConstructorParams\OptionalParams'); /* @var $result FixtureWithOptionalParams*/

        $this->assertEquals('default value defined in class', $result->param1);
        $this->assertEquals('configured using injector',      $result->param2);
    }
}
