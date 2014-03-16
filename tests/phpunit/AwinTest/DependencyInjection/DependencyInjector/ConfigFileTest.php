<?php
namespace AwinTest\DependencyInjection;

use AwinTest\DependencyInjection\TestCase;

class ConfigFileTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->injector->ingestConfigFile(__DIR__ . '/../Fixtures/example_config.yml');
    }

    public function tearDown()
    {
        $this->injector->reset();
    }

    public function testPuttingClassInConfigFile()
    {
        // ACT
        $result = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting\InterfaceInConstructorParamTypeHints');

        // ASSERT
        $this->assertInstanceOf(
            '\AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting\Implementation1',
            $result->param
        );
    }

    public function testPuttingValueInConfigFile()
    {
        // ACT
        $result = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\Basic\UnknownConstructorArg');

        // ASSERT
        $this->assertEquals('Text from config', $result->param);
    }
}
