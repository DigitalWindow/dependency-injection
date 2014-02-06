<?php
namespace AwinTest\DependencyInjection;

use Awin\DependencyInjection\DependencyInjector;
use AwinTest\DependencyInjection\TestCase;

class BasicTest extends TestCase
{
    public function testGetSingleInstance()
    {
        $instance = DependencyInjector::getSingleInstance();
        $this->assertInstanceOf('\Awin\DependencyInjection\DependencyInjector', $instance);
    }

    public function testGetSingleInstanceActuallyDoesWhatItSays()
    {
        $instance1 = DependencyInjector::getSingleInstance();
        $instance2 = DependencyInjector::getSingleInstance();
        $this->assertSame($instance1, $instance2);
    }

    public function testGeneratingVeryBasicClass()
    {
        $result = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\Basic\NoConstructor');
        $this->assertInstanceOf('\AwinTest\DependencyInjection\Fixtures\Basic\NoConstructor', $result);
    }

    /**
     * @expectedException \Awin\DependencyInjection\Exception\ClassDoesNotExistException
     */
    public function testExceptionThrownIfClassDoesntExist()
    {
        $this->injector->get('ClassThatIsntReal');
    }

    public function testWithUnknownConstructorParam()
    {
        $result = $this->injector->get('\AwinTest\DependencyInjection\Fixtures\Basic\UnknownConstructorArg');
        $this->assertInstanceOf('\AwinTest\DependencyInjection\Fixtures\Basic\UnknownConstructorArg', $result);
        $this->assertNull($result->param);
    }
}
